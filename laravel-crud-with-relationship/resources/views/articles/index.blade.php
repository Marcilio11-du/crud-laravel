@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
        <div>
            <h1 style="margin:0; font-size: 2.5rem; letter-spacing: -2px">News <span style="color:var(--purple)">Feed</span></h1>
            <p style="color:var(--muted)">Gerenciamento de publicações</p>
        </div>
        <label for="modal-toggle" class="btn btn-primary">+ NOVO ARTIGO</label>
    </div>

    @if($errors->any())
        <div style="background: rgba(248, 113, 113, 0.1); border: 1px solid #f87171; padding: 1rem; border-radius: 12px; margin-bottom: 2rem;">
            <ul style="margin:0; color:#f87171; font-size: 0.8rem">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table>
        <thead>
        <tr>
            <th>Capa</th>
            <th>Título</th>
            <th>Categoria</th>
            <th>Autores</th>
            <th>Publicado em</th>
            <th style="text-align:right">Ações</th>
        </tr>
        </thead>
        <tbody>
        @forelse($articles as $article)
            <tr>
                {{-- Imagem de capa --}}
                <td>
                    @if($article->cover_path)
                        <img src="{{ asset('storage/' . $article->cover_path) }}" width="60" height="45"
                             style="border-radius:6px; object-fit:cover; border: 1px solid var(--borda);">
                    @else
                        <div style="width:60px; height:45px; background:var(--azul-escuro); border-radius:6px; border:1px solid var(--borda); display:flex; align-items:center; justify-content:center;">
                            <span style="color:var(--muted); font-size:0.6rem;">SEM CAPA</span>
                        </div>
                    @endif
                </td>

                {{-- Título + preview do conteúdo --}}
                <td>
                    <div style="font-weight:bold; color:white;">{{ $article->title }}</div>
                    <div style="font-size:0.7rem; color:var(--muted); margin-top:3px;">
                        {{ Str::limit($article->content, 60) }}
                    </div>
                </td>

                {{-- Categoria --}}
                <td>
                    <span style="background:var(--bg); padding: 4px 10px; border-radius: 5px; font-size:0.7rem;">
                        {{ $article->category->name }}
                    </span>
                </td>

                {{-- Autores --}}
                <td style="font-size:0.75rem; color:var(--muted);">
                    @forelse($article->users as $author)
                        <span style="display:inline-block; background:var(--azul-escuro); border:1px solid var(--borda); border-radius:4px; padding:2px 7px; margin:2px; font-size:0.65rem; color:white;">
                            {{ $author->fst_name }} {{ $author->sur_name }}
                        </span>
                    @empty
                        <span style="color:var(--muted)">—</span>
                    @endforelse
                </td>

                {{-- Data --}}
                <td style="font-size:0.75rem; color:var(--muted); white-space:nowrap;">
                    {{ $article->publishing_date->format('d/m/Y H:i') }}
                </td>

                {{-- Ações --}}
                <td style="text-align:right; white-space:nowrap;">
                    <a href="{{ route('article.edit', $article->id) }}"
                       style="color:var(--blue); text-decoration:none; font-size:0.8rem; margin-right:1rem;">EDITAR</a>
                    <form action="{{ route('article.destroy', $article->id) }}" method="POST"
                          style="display:inline" onsubmit="return confirm('Mover para lixeira?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                style="background:none; border:none; color:#f87171; cursor:pointer; font-weight:bold; font-size:0.8rem;">
                            EXCLUIR
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center; color:var(--muted); padding: 3rem;">Feed vazio.</td>
            </tr>
        @endforelse
        </tbody>
    </table>


@endsection
