<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    public function __construct(protected ArticleService $service) {}

    public function index()
    {
        $articles = $this->service->listActive();
        return view('articles.index', compact('articles'));
    }

    public function store(StoreArticleRequest $request)
    {
        $this->service->store($request->validated());
        return redirect()->route('article.index')->with('success', 'Artigo publicado com sucesso!');
    }

    public function destroy($id)
    {
        $this->service->softDelete($id);
        return redirect()->route('article.index')->with('success', 'Artigo movido para a lixeira.');
    }

    public function trash()
    {
        $articles = $this->service->listTrashed();
        // Retorna JSON quando chamado via fetch (modal), view quando acesso directo
        if (request()->wantsJson()) {
            return response()->json($articles);
        }
        return view('articles.trash', compact('articles'));
    }

    public function restore($id)
    {
        $this->service->restore($id);
        return redirect()->route('articles.trash')->with('success', 'Artigo restaurado!');
    }

    // Retorna JSON com os dados do artigo para preencher o modal de edição
    public function edit($id)
    {
        $article = Article::with('users')->findOrFail($id);
        return response()->json([
            'article'  => $article,
            'user_ids' => $article->users->pluck('id'),
        ]);
    }

    public function update(StoreArticleRequest $request, $id)
    {
        $this->service->update($id, $request->validated());
        return redirect()->route('article.index')->with('success', 'Artigo atualizado com sucesso!');
    }

    // Hard delete — apaga permanentemente da BD
    public function forceDelete($id)
    {
        $this->service->forceDelete($id);
        return redirect()->route('articles.trash')->with('success', 'Artigo eliminado permanentemente.');
    }
}
