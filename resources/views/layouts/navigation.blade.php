<nav class="site-navbar">
    <div class="navbar-container">

        {{-- LOGO --}}
        <a href="{{ route('landing') }}" class="navbar-logo">
            Rasa Nusantara
        </a>

        {{-- MENU --}}
        <div class="navbar-links">

            @auth

                @if (Auth::user()->role === 'admin')

                    {{-- ADMIN --}}
                    <a href="{{ route('orders.index') }}">
                        Dashboard Order
                    </a>

                @else

                    {{-- CUSTOMER --}}
                    <a href="{{ route('landing') }}">
                        Beranda
                    </a>

                    <a href="{{ route('checkout') }}">
                        Pesan Sekarang
                    </a>

                    <a href="{{ route('pesanan-saya') }}">
                        Pesanan Saya
                    </a>
                @endif

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf

                    <button type="submit" class="logout-button">
                        Keluar
                    </button>
                </form>

            @else

                {{-- GUEST --}}
                <a href="{{ route('landing') }}">
                    Beranda
                </a>

                <a href="{{ route('login') }}">
                    Masuk
                </a>

                <a href="{{ route('register') }}">
                    Daftar
                </a>

            @endauth

        </div>
    </div>
</nav>

<style>
    .site-navbar {
        width: 100%;
        background: #3b281d;
        color: #fff;
        position: relative;
        z-index: 100;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
    }

    .navbar-container {
        width: min(1140px, calc(100% - 48px));
        min-height: 76px;
        margin: 0 auto;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 30px;
    }

    .navbar-logo {
        color: #fff !important;
        text-decoration: none !important;
        font-family: Georgia, serif;
        font-size: 26px;
        font-weight: 700;
        white-space: nowrap;
        transition: 0.2s ease;
    }

    .navbar-logo:hover {
        opacity: 0.85;
    }

    .navbar-links {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 30px;
    }

    .navbar-links a {
        color: #f7ead7 !important;
        text-decoration: none !important;
        font-size: 15px;
        font-weight: 600;
        transition: 0.2s ease;
        white-space: nowrap;
    }

    .navbar-links a:hover {
        color: #d95b3b !important;
    }

    .logout-form {
        margin: 0;
        padding: 0;
    }

    .logout-button {
        border: 0;
        background: transparent;
        color: #f7ead7;
        font-family: inherit;
        font-size: 15px;
        font-weight: 600;
        padding: 0;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .logout-button:hover {
        color: #d95b3b;
    }

    @media (max-width: 700px) {
        .navbar-container {
            width: calc(100% - 30px);
            min-height: auto;
            padding: 18px 0;
            flex-direction: column;
            align-items: flex-start;
        }

        .navbar-links {
            width: 100%;
            gap: 18px;
            flex-wrap: wrap;
        }

        .navbar-logo {
            font-size: 23px;
        }
    }
</style>