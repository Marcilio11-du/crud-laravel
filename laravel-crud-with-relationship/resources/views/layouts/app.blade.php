<!DOCTYPE html>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Master</title>
    <style>
        :root {
            --bg: #020617; --card: #0f172a; --border: #1e293b;
            --purple: #7c3aed; --purple-hover: #6d28d9;
            --blue: #3b82f6; --red: #ef4444; --green: #10b981;
            --text: #f1f5f9; --muted: #64748b;
        }
        * { box-sizing: border-box; }
        body { background: var(--bg); color: var(--text); font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; }


        nav { background: rgba(2,6,23,0.9); backdrop-filter: blur(12px); padding: 1rem 5%; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 50; }
        .nav-brand { font-weight: 900; color: var(--purple); font-size: 1.5rem; letter-spacing: -1px; }
        .container { max-width: 1100px; margin: 2rem auto; padding: 0 2rem; }

        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th { text-align: left; color: var(--purple); padding: 1rem; font-size: 0.75rem; text-transform: uppercase; border-bottom: 1px solid var(--border); }
        td { padding: 1rem; border-bottom: 1px solid var(--border); background: var(--card); vertical-align: middle; }

        /* MODAIS */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.85); display: none; justify-content: center;
            align-items: flex-start; z-index: 100; backdrop-filter: blur(10px);
            overflow-y: auto; padding: 2rem 1rem;
        }
        .modal-overlay.open { display: flex; }
        .modal-content {
            background: var(--card); width: 90%; max-width: 580px;
            padding: 2.5rem; border-radius: 24px; border: 1px solid var(--purple);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5); animation: slideUp 0.3s ease;
            margin: auto;
        }
        .modal-content.wide { max-width: 720px; }

        /* BOTÕES */
        .btn { padding: 0.7rem 1.4rem; border-radius: 10px; border: none; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s; font-size: 0.85rem; }
        .btn-primary { background: var(--purple); color: white; }
        .btn-primary:hover { background: var(--purple-hover); transform: translateY(-2px); }
        .btn-cancel  { background: #334155; color: white; }
        .btn-danger  { background: var(--red); color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-green   { background: var(--green); color: white; }

        /* FORMULÁRIO */
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; margin-bottom: 0.4rem; font-size: 0.78rem; color: var(--purple); font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        input, select, textarea { width: 100%; padding: 0.7rem 0.9rem; background: var(--bg); border: 1px solid var(--border); border-radius: 10px; color: white; font-size: 0.9rem; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--purple); }
        option { background: #0f172a; color: white; }

        /* TABS de gestão */
        .tab-bar { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.75rem; }
        .tab { padding: 0.4rem 1rem; border-radius: 8px; cursor: pointer; font-size: 0.8rem; font-weight: bold; color: var(--muted); background: none; border: 1px solid transparent; transition: 0.2s; }
        .tab.active { background: var(--purple); color: white; border-color: var(--purple); }

        /* LISTA de gestão */
        .manage-list { list-style: none; margin: 0; padding: 0; max-height: 200px; overflow-y: auto; }
        .manage-list li { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0.75rem; border-radius: 8px; margin-bottom: 4px; background: var(--bg); font-size: 0.85rem; }
        .manage-list li span { color: var(--text); }
        .manage-list li button { background: none; border: none; color: var(--red); cursor: pointer; font-size: 0.75rem; font-weight: bold; }

        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>


</head>
<body>

<nav>
    <div class="nav-brand">ARTICLE<span style="color:white">MASTER</span></div>
    <div style="display:flex; gap:1.5rem; align-items:center;">
        <a href="{{ route('article.index') }}" style="text-decoration:none; color:white; font-size:0.9rem;">Ativos</a>
        <button onclick="openModal('modal-trash')" style="background:none; border:none; color:var(--muted); cursor:pointer; font-size:0.9rem; font-weight:bold; padding:0;">Lixeira</button>
        <button onclick="openModal('modal-manage')" style="background:none; border:none; color:var(--muted); cursor:pointer; font-size:0.9rem; font-weight:bold; padding:0;">Gerir</button>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div style="background:rgba(16,185,129,0.1); border:1px solid var(--green); padding:1rem; border-radius:12px; margin-bottom:2rem;">
            {{ session('success') }}
        </div>
    @endif
    @yield('content')
</div>


<div class="modal-overlay" id="modal-create">
    <div class="modal-content">
        <h2 style="margin-top:0">Novo <span style="color:var(--purple)">Artigo</span></h2>
        <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" required>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="category_id">
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Data de Publicação</label>
                    <input type="datetime-local" name="publishing_date">
                </div>
            </div>
            <div class="form-group">
                <label>Autores (Ctrl para múltiplos)</label>
                <select name="users[]" multiple style="height:90px;">
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
            <div style="display:flex; justify-content:flex-end; gap:1rem; margin-top:1rem;">
                <button type="button" class="btn btn-cancel" onclick="closeModal('modal-create')">CANCELAR</button>
                <button type="submit" class="btn btn-primary">LANÇAR</button>
            </div>
        </form>
    </div>
</div>


<div class="modal-overlay" id="modal-edit">
    <div class="modal-content">
        <h2 style="margin-top:0">Editar <span style="color:var(--blue)">Artigo</span></h2>
        <form id="edit-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" id="edit-title" required>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="category_id" id="edit-category">
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Data de Publicação</label>
                    <input type="datetime-local" name="publishing_date" id="edit-date">
                </div>
            </div>
            <div class="form-group">
                <label>Autores (Ctrl para múltiplos)</label>
                <select name="users[]" id="edit-users" multiple style="height:90px;">
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->fst_name }} {{ $user->sur_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Conteúdo</label>
                <textarea name="content" id="edit-content" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label>Nova Capa (Opcional)</label>
                <div id="edit-cover-preview" style="margin-bottom:8px;"></div>
                <input type="file" name="cover">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:1rem; margin-top:1rem;">
                <button type="button" class="btn btn-cancel" onclick="closeModal('modal-edit')">CANCELAR</button>
                <button type="submit" class="btn btn-primary" style="background:var(--blue);">ATUALIZAR</button>
            </div>
        </form>
    </div>
</div>



<div class="modal-overlay" id="modal-trash">
    <div class="modal-content wide">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <h2 style="margin:0;">Lixeira</h2>
            <button onclick="closeModal('modal-trash')" style="background:none; border:none; color:var(--muted); cursor:pointer; font-size:1.2rem;">✕</button>
        </div>
        <table>
            <thead>
            <tr>
                <th>Título</th>
                <th>Removido em</th>
                <th style="text-align:center;">Ações</th>
            </tr>
            </thead>
            <tbody id="trash-tbody">
            <tr><td colspan="3" style="text-align:center; color:var(--muted); padding:2rem;">A carregar...</td></tr>
            </tbody>
        </table>
        <div style="margin-top:1rem; text-align:right;">
            <button onclick="closeModal('modal-trash')" class="btn btn-cancel">FECHAR</button>
        </div>
    </div>
</div>



<div class="modal-overlay" id="modal-manage">
    <div class="modal-content">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h2 style="margin:0;">Gerir</h2>
            <button onclick="closeModal('modal-manage')" style="background:none; border:none; color:var(--muted); cursor:pointer; font-size:1.2rem;">✕</button>
        </div>


        <div class="tab-bar">
            <button class="tab active" onclick="switchTab('tab-cat')">Categorias</button>
            <button class="tab"        onclick="switchTab('tab-usr')">Utilizadores</button>
        </div>

        {{-- Categorias --}}
        <div id="tab-cat">
            <form action="{{ route('categories.store') }}" method="POST" style="display:flex; gap:0.5rem; margin-bottom:1rem;">
                @csrf
                <input type="text" name="name" placeholder="Nova categoria..." style="flex:1;">
                <button type="submit" class="btn btn-primary" style="white-space:nowrap;">+ ADICIONAR</button>
            </form>
            <ul class="manage-list">
                @foreach(\App\Models\Category::all() as $cat)
                    <li>
                        <span>{{ $cat->name }}</span>
                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Apagar categoria?')">
                            @csrf @method('DELETE')
                            <button type="submit">✕ APAGAR</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Utilizadores --}}
        <div id="tab-usr" style="display:none;">
            <form action="{{ route('users.store') }}" method="POST" style="display:grid; grid-template-columns:1fr 1fr auto; gap:0.5rem; margin-bottom:1rem;">
                @csrf
                <input type="text" name="fst_name" placeholder="Primeiro nome...">
                <input type="text" name="sur_name" placeholder="Apelido...">
                <button type="submit" class="btn btn-primary" style="white-space:nowrap;">+ ADICIONAR</button>
            </form>
            <ul class="manage-list">
                @foreach(\App\Models\User::all() as $user)
                    <li>
                        <span>{{ $user->fst_name }} {{ $user->sur_name }}</span>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apagar utilizador?')">
                            @csrf @method('DELETE')
                            <button type="submit">✕ APAGAR</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    ```

</div>

<script>
    // ── Abrir / Fechar modais ──────────────────────────────
    function openModal(id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
    }
    // Fechar ao clicar no overlay
    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeModal(overlay.id);
        });
    });

    // ── Tabs de gestão ─────────────────────────────────────
    function switchTab(tabId) {
        document.getElementById('tab-cat').style.display = 'none';
        document.getElementById('tab-usr').style.display = 'none';
        document.getElementById(tabId).style.display = 'block';
        document.querySelectorAll('.tab').forEach(function(t) { t.classList.remove('active'); });
        event.target.classList.add('active');
    }

    // ── Abrir modal de edição com dados do artigo ──────────
    function editArticle(id) {
        fetch('/article/' + id + '/edit', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                var a = data.article;
                document.getElementById('edit-title').value   = a.title;
                document.getElementById('edit-content').value = a.content;
                document.getElementById('edit-category').value = a.category_id;

                // Data
                if (a.publishing_date) {
                    document.getElementById('edit-date').value = a.publishing_date.replace(' ', 'T').substring(0, 16);
                }


                var sel = document.getElementById('edit-users');
                Array.from(sel.options).forEach(function(opt) {
                    opt.selected = data.user_ids.includes(parseInt(opt.value));
                });


                var preview = document.getElementById('edit-cover-preview');
                preview.innerHTML = a.cover_path
                    ? '<img src="/storage/' + a.cover_path + '" width="80" style="border-radius:6px; border:1px solid var(--purple);">'
                    : '';

                // Action do form
                document.getElementById('edit-form').action = '/article/' + id;

                openModal('modal-edit');
            });
    }

    // ── Carregar lixeira via fetch ─────────────────────────
    function openTrash() {
        fetch('/articles/trash', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(r) { return r.json(); })
            .then(function(articles) {
                var tbody = document.getElementById('trash-tbody');
                if (!articles.length) {
                    tbody.innerHTML = '<tr><td colspan="3" style="text-align:center; color:var(--muted); padding:2rem;">A lixeira está vazia.</td></tr>';
                } else {
                    tbody.innerHTML = articles.map(function(a) {
                        var date = a.deleted_at ? a.deleted_at.substring(0, 16).replace('T', ' ') : '—';
                        return '<tr>' +
                            '<td style="color:var(--text);">' + a.title + '</td>' +
                            '<td style="font-size:0.8rem; color:var(--muted);">' + date + '</td>' +
                            '<td style="text-align:center;">' +
                            // Restaurar
                            '<form action="/articles/' + a.id + '/restore" method="POST" style="display:inline;">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                            '<input type="hidden" name="_method" value="PATCH">' +
                            '<button type="submit" class="btn btn-green" style="margin-right:6px; font-size:0.7rem; padding:4px 10px;">RESTAURAR</button>' +
                            '</form>' +
                            // Hard delete
                            '<form action="/articles/' + a.id + '/force" method="POST" style="display:inline;" onsubmit="return confirm(\'Apagar permanentemente? Esta acção não pode ser desfeita.\')">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                            '<input type="hidden" name="_method" value="DELETE">' +
                            '<button type="submit" class="btn btn-danger" style="font-size:0.7rem; padding:4px 10px;">APAGAR</button>' +
                            '</form>' +
                            '</td>' +
                            '</tr>';
                    }).join('');
                }
            });
        openModal('modal-trash');
    }

    // Sobrescrever o openModal para a lixeira carregar os dados
    var _origOpen = openModal;
    document.querySelector('[onclick="openModal(\'modal-trash\')"]').onclick = function() { openTrash(); };
</script>

</body>
</html>
