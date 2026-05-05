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
            if (isset($data['cover'])) {
                $data['cover_path'] = $data['cover']->store('articles', 'public');
            }
            $users = $data['users'] ?? [];
            unset($data['cover'], $data['users']);

            $article = Article::create($data);
            if (!empty($users)) $article->users()->sync($users);
            return $article;
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $article = $this->findById($id);
            if (isset($data['cover'])) {
                if ($article->cover_path) Storage::disk('public')->delete($article->cover_path);
                $data['cover_path'] = $data['cover']->store('articles', 'public');
            }
            $users = $data['users'] ?? [];
            unset($data['cover'], $data['users']);

            $article->update($data);
            $article->users()->sync($users);
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

    public function forceDelete(int $id)
    {
        $article = $this->findById($id, true);
        if ($article->cover_path) {
            Storage::disk('public')->delete($article->cover_path);
        }
        $article->forceDelete();
    }
}
