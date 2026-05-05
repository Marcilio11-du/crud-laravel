<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Master - Expert System</title>
    <style>

        :root {
            --bg: #020617; --card: #0f172a; --border: #1e293b;
            --purple: #7c3aed; --purple-hover: #6d28d9;
            --blue: #3b82f6; --text: #f1f5f9; --muted: #64748b;
        }

        body { background: var(--bg); color: var(--text); font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; }
        nav { background: rgba(2, 6, 23, 0.9); backdrop-filter: blur(12px); padding: 1rem 5%; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .nav-brand { font-weight: 900; color: var(--purple); font-size: 1.5rem; letter-spacing: -1px; }
        .container { max-width: 1100px; margin: 2rem auto; padding: 0 2rem; }

        /* TABELA */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th { text-align: left; color: var(--purple); padding: 1rem; font-size: 0.75rem; text-transform: uppercase; border-bottom: 1px solid var(--border); }
        td { padding: 1rem; border-bottom: 1px solid var(--border); background: var(--card); }

        /* MODAL LOGIC (CSS ONLY) */
        #modal-toggle { display: none; }
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.85); display: none; justify-content: center;
            align-items: center; z-index: 100; backdrop-filter: blur(10px);
            overflow-y: auto;
        }
        #modal-toggle:checked ~ .modal-overlay { display: flex; }
        .modal-content {
            background: var(--card); width: 90%; max-width: 580px;
            padding: 2.5rem; border-radius: 24px; border: 1px solid var(--purple);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5); animation: slideUp 0.3s ease;
            margin: auto;
        }

        /* BOTÕES */
        .btn { padding: 0.8rem 1.5rem; border-radius: 12px; border: none; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; transition: 0.2s; }
        .btn-primary { background: var(--purple); color: white; }
        .btn-primary:hover { background: var(--purple-hover); transform: translateY(-2px); }
        .btn-cancel { background: #334155; color: white; }

        /* FORMULÁRIO */
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; margin-bottom: 0.5rem; font-size: 0.8rem; color: var(--purple); font-weight: bold; }
        input, select, textarea { width: 100%; padding: 0.8rem; background: var(--bg); border: 1px solid var(--border); border-radius: 10px; color: white; box-sizing: border-box; }

        option { background: #0f172a; color: white; }

        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
<input type="checkbox" id="modal-toggle">
<nav>
    <div class="nav-brand">ARTICLE<span style="color: white">MASTER</span></div>
    <div style="display: flex; gap: 2rem;">
        <a href="{{ route('article.index') }}" style="text-decoration:none; color:white">Ativos</a>
        <a href="{{ route('articles.trash') }}" style="text-decoration:none; color:var(--muted)">Lixeira</a>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; padding: 1rem; border-radius: 12px; margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif
    @yield('content')
</div>

<div class="modal-overlay">
    <div class="modal-content">
        <h2 style="margin-top:0">Novo <span style="color:var(--purple)">Artigo</span></h2>
        <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" required>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem">
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="category_id">
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Data de Publicação (Opcional)</label>
                    <input type="datetime-local" name="publishing_date">
                </div>
            </div>


            <div class="form-group">
                <label>Autores (Ctrl para múltiplos)</label>
                <select name="users[]" multiple style="height: 90px;">
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->fst_name }} {{ $user->sur_name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label>Conteúdo</label>
                <textarea name="content" rows="4"></textarea>
            </div>


            <div class="form-group">
                <label>Imagem de Capa</label>
                <input type="file" name="cover">
            </div>

            <div style="display:flex; justify-content: flex-end; gap: 1rem; margin-top: 1rem">
                <label for="modal-toggle" class="btn btn-cancel">CANCELAR</label>
                <button type="submit" class="btn btn-primary">LANÇAR</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
