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

                    <a href="{{ route('checkout') }}" class="navbar-cta">
                        Pesan Sekarang
                    </a>

                    <a href="{{ route('pesanan-saya') }}">
                        Pesanan Saya
                    </a>
                @endif

                <a href="{{ route('profile.edit') }}">
                    Profil
                </a>

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

                <a href="{{ route('register') }}" class="navbar-cta">
                    Daftar
                </a>

            @endauth

        </div>
    </div>
</nav>

<style>
    .site-navbar {
        width: 100%;
        background: #0e2116;
        color: #fff;
        position: relative;
        z-index: 100;
        border-bottom: 1px solid rgba(201, 163, 91, .18);
    }

    .navbar-container {
        width: min(1140px, calc(100% - 48px));
        min-height: 82px;
        margin: 0 auto;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 26px;
    }

    .navbar-logo {
        color: #f6efe1 !important;
        text-decoration: none !important;
        font-family: 'Fraunces', Georgia, serif;
        font-size: 23px;
        font-style: italic;
        font-weight: 600;
        letter-spacing: 0.01em;
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
        color: #f6efe1 !important;
        text-decoration: none !important;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: .04em;
        transition: 0.2s ease;
        white-space: nowrap;
    }

    .navbar-links a:hover {
        color: #c9a35b !important;
    }

    .navbar-links a.navbar-cta {
        padding: 10px 20px;
        border-radius: 2px 999px 2px 999px;
        background: #c9a35b;
        color: #12271b !important;
        font-weight: 700;
        letter-spacing: 0;
    }

    .navbar-links a.navbar-cta:hover {
        background: #ddba74;
    }

    .logout-form {
        margin: 0;
        padding: 0;
    }

    .logout-button {
        border: 0;
        background: transparent;
        color: #f6efe1;
        font-family: inherit;
        font-size: 15px;
        font-weight: 600;
        padding: 0;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .logout-button:hover {
        color: #c9a35b;
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