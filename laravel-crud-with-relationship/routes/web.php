<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ── Artigos: rotas especiais ANTES do resource ──────────────────────────
Route::get('articles/trash',          [ArticleController::class, 'trash'])->name('articles.trash');
Route::patch('articles/{id}/restore', [ArticleController::class, 'restore'])->name('articles.restore');
Route::delete('articles/{id}/force',  [ArticleController::class, 'forceDelete'])->name('articles.force-delete');

// Recurso principal
Route::resource('article', ArticleController::class);

Route::post('categories',          [CategoryController::class, 'store'])->name('categories.store');
Route::delete('categories/{id}',   [CategoryController::class, 'destroy'])->name('categories.destroy');


Route::post('users',               [UserController::class, 'store'])->name('users.store');
Route::delete('users/{id}',        [UserController::class, 'destroy'])->name('users.destroy');
