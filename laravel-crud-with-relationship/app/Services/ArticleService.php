<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    public function listActive()
    {
        return Article::with(['category', 'users'])->latest()->get();
    }

    public function listTrashed()
    {
        return Article::onlyTrashed()->with('category')->get();
    }

    public function findById(int $id, bool $withTrashed = false)
    {
        $query = Article::query();
        if ($withTrashed) $query->withTrashed();
        return $query->findOrFail($id);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Corrigido: campo do form é 'cover', coluna na BD é 'cover_path'
            if (isset($data['cover'])) {
                $data['cover_path'] = $data['cover']->store('articles', 'public');
            }

            // Corrigido: remover campos que não existem na tabela articles antes do create()
            $users = $data['users'] ?? [];
            unset($data['cover'], $data['users']);

            $article = Article::create($data);

            if (!empty($users)) {
                $article->users()->sync($users);
            }

            return $article;
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $article = $this->findById($id);

            // Corrigido: cover → cover_path
            if (isset($data['cover'])) {
                if ($article->cover_path) {
                    Storage::disk('public')->delete($article->cover_path);
                }
                $data['cover_path'] = $data['cover']->store('articles', 'public');
            }

            // Corrigido: remover campos que não existem na tabela articles antes do update()
            $users = $data['users'] ?? [];
            unset($data['cover'], $data['users']);

            $article->update($data);

            if (!empty($users)) {
                $article->users()->sync($users);
            }

            return $article;
        });
    }

    public function softDelete(int $id)
    {
        return $this->findById($id)->delete();
    }

    public function restore(int $id)
    {
        return $this->findById($id, true)->restore();
    }
}
