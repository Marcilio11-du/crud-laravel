<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

// Rotas da Lixeira (devem vir ANTES do resource para não serem capturadas como {article})
Route::get('articles/trash', [ArticleController::class, 'trash'])->name('articles.trash');
Route::patch('articles/{id}/restore', [ArticleController::class, 'restore'])->name('articles.restore');

// Recurso Principal
Route::resource('article', ArticleController::class);
