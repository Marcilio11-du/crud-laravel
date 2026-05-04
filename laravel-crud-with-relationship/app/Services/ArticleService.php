<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    public function listActive()
    {
        // Eager Loading (with) evita o problema N+1 de performance
        return Article::with(['category', 'authors'])->latest()->get();
    }

    public function listTrashed()
    {
        return Article::onlyTrashed()->with('category')->get();
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Tratamento da Imagem (Upload)
            if (isset($data['cover'])) {

                $path = $data['cover']->store('articles', 'public');
                $data['cover_path'] = $path;
            }

            // Criar o Artigo
            $artigo = Artigo::create($data);

            // Relacionamento N:N (Tabela Pivot)
            $artigo->autores()->sync($data['autores']);

            return $artigo;
        });
    }

    public function softDelete(int $id)
    {
        return Article::findOrFail($id)->delete();
    }

    public function restore(int $id)
    {
        return Article::onlyTrashed()->findOrFail($id)->restore();
    }
}
