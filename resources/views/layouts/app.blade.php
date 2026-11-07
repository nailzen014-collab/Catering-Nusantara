<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#12271B">
    <meta name="description"
        content="@yield('description', 'Rasa Nusantara — katering rumahan khas Bogor untuk pernikahan, acara kantor, dan keluarga.')">

    <title>{{ config('app.name', 'Rasa Nusantara') }} — @yield('title', 'Beranda')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,600&family=Karla:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        document.documentElement.classList.add('js');
    </script>

    @stack('head')
</head>

<body class="bg-cream font-body text-ink antialiased">

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

    @stack('scripts')

</body>

</html>
