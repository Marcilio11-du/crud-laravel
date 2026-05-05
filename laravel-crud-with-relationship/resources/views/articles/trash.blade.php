@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="margin:0; color: white;">Artigos na <span style="color: #ef4444;">Lixeira</span></h2>
        {{-- Corrigido: artigos.index → article.index --}}
        <a href="{{ route('article.index') }}" style="color: var(--roxo-principal); text-decoration: none; font-weight: bold;">← Voltar para Ativos</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>Título</th>
            <th>Removido em</th>
            <th style="text-align: center;">Ações</th>
        </tr>
        </thead>
        <tbody>
        @forelse($articles as $article)
            <tr>
                <td style="color: var(--texto-muted);">{{ $article->title }}</td>
                <td style="font-size: 0.85rem; color: #64748b;">{{ $article->deleted_at->format('d/m/Y H:i') }}</td>
                <td style="text-align: center;">
                    <form action="{{ route('articles.restore', $article->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="background: #059669; color: white; border: none; padding: 5px 15px; border-radius: 4px; cursor: pointer; font-size: 0.75rem; font-weight: bold;">
                            RESTAURAR
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" style="text-align: center; padding: 3rem; color: var(--texto-muted);">A lixeira está vazia.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
