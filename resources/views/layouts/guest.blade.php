<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Rasa Nusantara') }} — @yield('title', 'Masuk')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Karla:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream: #F7ECDA; --ink: #3B2A1E; --clay: #A6432D; --clay-dark: #7E301F;
            --turmeric: #C98A2C; --leaf: #4B6043; --card: #FFFBF2; --line: #E4D4B8;
            --font-display: 'Fraunces', serif; --font-body: 'Karla', sans-serif;
        }
        * { box-sizing: border-box; }
        body {
            font-family: var(--font-body);
            margin: 0;
            min-height: 100vh;
            background: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-card {
            background: var(--card);
            width: 100%;
            max-width: 400px;
            padding: 40px 36px;
            border-radius: 4px 24px 4px 24px; /* radius asimetris, bukan seragam */
            box-shadow: 0 12px 32px rgba(0,0,0,0.28);
        }
        .auth-card .brand {
            font-family: var(--font-display);
            text-align: center;
            color: var(--clay-dark);
            font-weight: 600;
            font-size: 1.4rem;
            margin-bottom: 28px;
            text-decoration: none;
            display: block;
        }
        .auth-card label { display: block; font-size: 0.85rem; color: var(--ink); margin-bottom: 6px; font-weight: 600; }
        .auth-card input, .auth-card select {
            width: 100%; padding: 11px 13px; border: 1.5px solid var(--line); border-radius: 6px;
            margin-bottom: 16px; font-size: 0.95rem; font-family: var(--font-body); background: #fff;
        }
        .auth-card input:focus, .auth-card select:focus { outline: none; border-color: var(--clay); }
        .auth-card .error { color: #A6432D; font-size: 0.8rem; margin-top: -12px; margin-bottom: 14px; }
        .auth-card button {
            width: 100%; background: var(--clay); color: #fff; border: none; padding: 13px;
            border-radius: 6px; font-weight: 700; font-family: var(--font-body); cursor: pointer; font-size: 0.95rem;
        }
        .auth-card button:hover { background: var(--clay-dark); }
        .auth-card .switch-link { text-align: center; margin-top: 20px; font-size: 0.85rem; color: #8A7458; }
        .auth-card .switch-link a { color: var(--clay); text-decoration: none; font-weight: 700; }
        .status-msg { background: #EAF1E5; color: var(--leaf); padding: 10px 14px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 16px; }
        @yield('extra-style')
    </style>
</head>
<body>
    <div class="auth-card">
        <a href="{{ url('/') }}" class="brand">Rasa Nusantara</a>
        @if (session('status'))
            <div class="status-msg">{{ session('status') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>