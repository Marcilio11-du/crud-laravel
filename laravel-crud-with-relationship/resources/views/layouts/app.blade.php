<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Manager</title>
    <style>
        :root {
            --azul-escuro: #0f172a;
            --azul-card: #1e293b;
            --roxo-principal: #7c3aed;
            --roxo-hover: #6d28d9;
            --texto-claro: #f1f5f9;
            --texto-muted: #94a3b8;
            --borda: #334155;
        }

        body {
            background-color: var(--azul-escuro);
            color: var(--texto-claro);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #0b1120;
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--borda);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-brand { font-size: 1.5rem; font-weight: bold; color: var(--roxo-principal); }
        .nav-links a {
            color: var(--texto-muted);
            text-decoration: none;
            margin-left: 1.5rem;
            transition: 0.3s;
        }
        .nav-links a:hover { color: var(--roxo-principal); }

        .container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; padding-bottom: 5rem; }

        table { width: 100%; border-collapse: collapse; background: var(--azul-card); border-radius: 8px; overflow: hidden; }
        th { background: #161e2d; padding: 1rem; text-align: left; color: var(--roxo-principal); font-size: 0.8rem; text-transform: uppercase; }
        td { padding: 1rem; border-bottom: 1px solid var(--borda); }
        tr:hover { background: #243045; }

        .btn-add-container {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
        }

        .btn-primary {
            background-color: var(--roxo-principal);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover { background-color: var(--roxo-hover); }

        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: var(--texto-muted); font-size: 0.9rem; }
        input {
            width: 100%;
            padding: 0.6rem;
            background: var(--azul-escuro);
            border: 1px solid var(--borda);
            border-radius: 5px;
            color: white;
            box-sizing: border-box;
        }
        input:focus { border-color: var(--roxo-principal); outline: none; }

        .alert { padding: 1rem; border-radius: 5px; background: rgba(124, 58, 237, 0.1); border: 1px solid var(--roxo-principal); margin-bottom: 1rem; }
    </style>
</head>
<body>
<nav>
    <div class="nav-brand">HARDWARE APP</div>
    <div class="nav-links">
        <a href="{{ route('components.index') }}">Ativos</a>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>
</body>
</html>
