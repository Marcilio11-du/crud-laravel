@extends('layouts.app')

@section('content')
    <div style="background: var(--azul-card); padding: 2rem; border-radius: 12px; border: 1px solid var(--borda); max-width: 800px; margin: 0 auto;">
        <h2 style="margin-top: 0; margin-bottom: 2rem; border-bottom: 1px solid var(--borda); padding-bottom: 1rem;">Editar Artigo</h2>

        <form action="{{ route('article.update', $article->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Título do Artigo</label>

                <input type="text" name="title" value="{{ old('title', $article->title) }}" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="category_id" style="width:100%; padding:0.6rem; background: var(--azul-escuro); color:white; border: 1px solid var(--borda); border-radius:5px;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $article->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Data de Publicação</label>

                    <input type="datetime-local" name="publishing_date" value="{{ $article->publishing_date->format('Y-m-d\TH:i') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Alterar Capa (Opcional)</label>
                @if($article->cover_path)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/'. $article->cover_path) }}" width="100" style="border-radius: 8px; border: 1px solid var(--roxo-principal);">
                    </div>
                @endif
                <input type="file" name="cover">
            </div>

            <div class="form-group">
                <label>Autores (Selecione múltiplos)</label>

                <select name="authors[]" multiple style="width:100%; height: 120px; background: var(--azul-escuro); color:white; border: 1px solid var(--borda); border-radius:5px; padding: 10px;">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, $article->users->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $user->fst_name }} {{ $user->sur_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Conteúdo</label>
                <textarea name="content" rows="6" style="width:100%; background: var(--azul-escuro); color:white; border: 1px solid var(--borda); border-radius:5px; padding: 10px;">{{ old('content', $article->content) }}</textarea>
            </div>

            <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem; align-items: center;">
                <a href="{{ route('article.index') }}" style="color: var(--texto-muted); text-decoration: none;">Descartar</a>
                <button type="submit" class="btn-primary" style="background-color: #3b82f6;">ATUALIZAR ARTIGO</button>
            </div>
        </form>
    </div>
@endsection
