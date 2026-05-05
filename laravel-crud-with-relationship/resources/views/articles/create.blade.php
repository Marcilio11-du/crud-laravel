@extends('layouts.app')

@section('content')
    <div style="background: var(--azul-card); padding: 2rem; border-radius: 12px; border: 1px solid var(--borda);">
        <h2 style="margin-top: 0; margin-bottom: 2rem;">Publicar Novo Artigo</h2>

        <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Título do Artigo</label>

                <input type="text" name="title" value="{{ old('title') }}" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label>Categoria</label>

                    <select name="category_id" style="width:100%; padding:0.6rem; background: var(--azul-escuro); color:white; border: 1px solid var(--borda); border-radius:5px;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Data de Publicação</label>

                    <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Capa do Artigo (Upload)</label>
                <input type="file" name="cover">
            </div>

            <div class="form-group">
                <label>Autores (Selecione múltiplos segurando Ctrl)</label>

                <select name="authors[]" multiple style="width:100%; height: 120px; background: var(--azul-escuro); color: white; border: 1px solid var(--borda); border-radius:5px; padding: 10px;">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" style="color: white; background: var(--azul-escuro);"
                            {{ in_array($user->id, (array) old('authors')) ? 'selected' : '' }}>
                            {{ $user->fst_name }} {{ $user->sur_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Conteúdo</label>

                <textarea name="content" rows="6" style="width:100%; background: var(--azul-escuro); color:white; border: 1px solid var(--borda); border-radius:5px; padding: 10px;">{{ old('content') }}</textarea>
            </div>

            <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('article.index') }}" style="color: var(--texto-muted); text-decoration: none;">Cancelar</a>
                <button type="submit" class="btn-primary">PUBLICAR ARTIGO</button>
            </div>
        </form>
    </div>
@endsection
