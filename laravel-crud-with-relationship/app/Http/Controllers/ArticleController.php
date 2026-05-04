<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Categoria;
use App\Models\Category;
use App\Models\User;
use App\Models\Utilizador;
use App\Services\ArticleService;
use App\Services\ArtigoService;
use App\Http\Requests\StoreArtigoRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(protected ArticleService $service) {}

    public function index()
    {
        $articles = $this->service->listActive();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        return view('articles.create', compact('categories', 'users'));
    }

    public function store(StoreArticleRequest $request)
    {
        $this->service->store($request->validated());
        return redirect()->route('article.index')->with('success', 'Artigo publicado com sucesso!');
    }

    public function destroy($id)
    {
        $this->service->softDelete($id);
        return redirect()->route('articles.index')->with('success', 'Artigo movido para a lixeira.');
    }

    public function trash()
    {
        $articles = $this->service->listTrashed();
        return view('articles.trash', compact('articles'));
    }

    public function restore($id)
    {
        $this->service->restore($id);
        return redirect()->route('articles.trash')->with('success', 'Artigo restaurado!');
    }
}
