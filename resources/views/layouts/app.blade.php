<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Rasa Nusantara') }} — @yield('title', 'Beranda')
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Karla:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        :root {
            --cream: #F7ECDA;
            --ink: #3B2A1E;
            --clay: #A6432D;
            --clay-dark: #7E301F;
            --turmeric: #C98A2C;
            --leaf: #4B6043;
            --card: #FFFBF2;
            --line: #E4D4B8;
            --muted: #8A7458;

            --font-display: 'Fraunces', serif;
            --font-body: 'Karla', sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            margin: 0;
            background: var(--cream);
            color: var(--ink);
            line-height: 1.55;
        }

        h1,
        h2,
        h3 {
            font-family: var(--font-display);
            font-weight: 600;
            margin: 0;
        }

        .container {
            max-width: 1040px;
            margin: 0 auto;
            padding: 0 24px;
        }

        a {
            color: var(--clay);
        }

        /* Divider bergelombang */

        .wavy-divider {
            height: 24px;
            background: var(--cream);

            mask-image: radial-gradient(
                circle at 12px 0,
                transparent 12px,
                black 13px
            );

            -webkit-mask-image: radial-gradient(
                circle at 12px 0,
                transparent 12px,
                black 13px
            );

            mask-size: 24px 24px;
            -webkit-mask-size: 24px 24px;

            mask-repeat: repeat-x;
            -webkit-mask-repeat: repeat-x;
        }

        /* Navbar */

        .navbar {
            background: var(--ink);
            padding: 18px 0;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .brand {
            font-family: var(--font-display);
            color: var(--cream);
            font-size: 1.3rem;
            font-weight: 600;
            text-decoration: none;
        }

        .navbar .nav-links a {
            margin-left: 20px;
            color: #E8D9BE;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
        }

        .navbar .nav-links a:hover {
            color: var(--turmeric);
        }

        .navbar .nav-links form {
            display: inline;
        }

        .navbar .nav-links button {
            background: none;
            border: none;
            color: #E8D9BE;
            cursor: pointer;
            font-size: 0.92rem;
            font-weight: 500;
            margin-left: 20px;
            font-family: var(--font-body);
        }

        .navbar .nav-links button:hover {
            color: var(--turmeric);
        }

        /* Page header */

        .page-header {
            background: var(--card);
            border-bottom: 1px solid var(--line);
            padding: 28px 0;
        }

        .page-header h1 {
            color: var(--clay-dark);
            font-size: 1.6rem;
        }

        /* Table */

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card);
            border-radius: 4px;
            overflow: hidden;
        }

        main {
            min-height: calc(100vh - 68px);
        }

        th,
        td {
            padding: 14px 18px;
            text-align: left;
            vertical-align: top;
            border-bottom: 1px solid var(--line);
        }

        th {
            background: var(--ink);
            color: var(--cream);
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 0.95rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #FBF6EA;
        }

        .sub-label {
            color: #8A7458;
            font-size: 0.82em;
        }

        .item-list {
            margin: 0;
            padding-left: 18px;
        }

        .item-list li {
            margin-bottom: 3px;
        }

        /* Badge pita */

        .ribbon {
            display: inline-block;
            padding: 3px 12px 3px 10px;
            font-size: 0.78em;
            font-weight: 600;
            color: #fff;
            position: relative;
        }

        .ribbon.status-pending {
            background: var(--turmeric);
        }

        .ribbon.status-processing {
            background: var(--clay);
        }

        .ribbon.status-delivered {
            background: var(--leaf);
        }

        .ribbon.status-cancelled {
            background: #8A7458;
        }

        .pagination {
            margin-top: 24px;
        }

        /* Empty state */

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #8A7458;
        }

        .empty-state strong {
            display: block;
            color: var(--ink);
            font-family: var(--font-display);
            font-size: 1.15rem;
            margin-bottom: 6px;
        }

        @yield('extra-style')

    </style>

</head>

<body>

    @include('layouts.navigation')

    @hasSection('header')

        <header class="page-header">

            <div class="container">
                @yield('header')
            </div>

        </header>

    @endif

    <main>

        @yield('content')

    </main>

</body>

</html>