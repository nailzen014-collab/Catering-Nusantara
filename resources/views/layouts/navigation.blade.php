<header
    x-data="{ open: false, scrolled: false }"
    x-on:scroll.window="scrolled = window.scrollY > 8"
    x-on:keydown.escape.window="open = false"
    x-effect="document.documentElement.classList.toggle('overflow-hidden', open)"
    class="sticky top-0 z-50 border-b transition-colors duration-300"
    :class="scrolled || open ? 'border-ink/10 bg-cream/95 backdrop-blur-md' : 'border-transparent bg-cream'"
>
    <div class="mx-auto flex h-16 w-full max-w-shell items-center justify-between gap-6 px-5 sm:px-8 lg:h-20">
        <a href="{{ route('landing') }}" class="group flex items-baseline gap-2" aria-label="Rasa Nusantara — beranda">
            <span class="font-display text-[1.35rem] italic font-semibold tracking-tight text-ink lg:text-[1.5rem]">Rasa Nusantara</span>
            <span class="hidden text-[10px] font-semibold uppercase tracking-[0.24em] text-muted sm:inline">Bogor</span>
        </a>

        <nav class="hidden items-center gap-8 lg:flex" aria-label="Navigasi utama">
            <a href="{{ route('landing') }}#paket" class="nav-link">Paket</a>
            <a href="{{ route('landing') }}#menu" class="nav-link">Menu</a>
            <a href="{{ route('landing') }}#tentang" class="nav-link">Dapur kami</a>
            <a href="{{ route('landing') }}#testimoni" class="nav-link">Testimoni</a>
        </nav>

        <div class="hidden items-center gap-5 lg:flex">
            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('orders.index') }}" class="nav-link">Pesanan masuk</a>
                @else
                    <a href="{{ route('pesanan-saya') }}" class="nav-link">Pesanan saya</a>
                @endif

                <x-user-badge :user="Auth::user()" />

                @if (Auth::user()->role !== 'admin')
                    <a href="{{ route('checkout') }}" class="cta cta-gold">Pesan sekarang</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit"
                        class="text-[13px] font-medium tracking-wide text-ink/50 transition-colors hover:text-clay">
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                <a href="{{ route('register') }}" class="cta cta-gold">Daftar</a>
            @endauth
        </div>

        <button type="button"
            class="flex h-10 w-10 items-center justify-center rounded-full border border-ink/15 text-ink transition-colors hover:border-ink/40 lg:hidden"
            x-on:click="open = !open"
            :aria-expanded="open ? 'true' : 'false'"
            aria-controls="mobile-menu"
            aria-label="Buka menu navigasi">
            <svg x-show="!open" class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M1 4h14M1 8h14M1 12h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            </svg>
            <svg x-show="open" x-cloak class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    <div id="mobile-menu" x-show="open" x-cloak x-transition.opacity.duration.200ms
        class="border-t border-ink/10 bg-cream lg:hidden">
        <div class="mx-auto max-w-shell px-5 pb-8 pt-6 sm:px-8">
            @auth
                <div class="mb-5 flex items-center justify-between gap-3 border-b border-ink/10 pb-5">
                    <x-user-badge :user="Auth::user()" />
                    <span class="text-[10px] uppercase tracking-[0.18em] text-muted">Masuk sebagai</span>
                </div>
            @endauth

            <nav class="flex flex-col divide-y divide-ink/10" aria-label="Navigasi seluler">
                <a href="{{ route('landing') }}#paket" class="py-3.5 font-display text-2xl text-ink" x-on:click="open = false">Paket</a>
                <a href="{{ route('landing') }}#menu" class="py-3.5 font-display text-2xl text-ink" x-on:click="open = false">Menu</a>
                <a href="{{ route('landing') }}#tentang" class="py-3.5 font-display text-2xl text-ink" x-on:click="open = false">Dapur kami</a>
                <a href="{{ route('landing') }}#testimoni" class="py-3.5 font-display text-2xl text-ink" x-on:click="open = false">Testimoni</a>

                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('orders.index') }}" class="py-3.5 text-sm font-medium text-ink" x-on:click="open = false">Pesanan masuk</a>
                    @else
                        <a href="{{ route('pesanan-saya') }}" class="py-3.5 text-sm font-medium text-ink" x-on:click="open = false">Pesanan saya</a>
                    @endif
                @endauth
            </nav>

            <div class="mt-6 flex flex-wrap items-center gap-3">
                @auth
                    @if (Auth::user()->role !== 'admin')
                        <a href="{{ route('checkout') }}" class="cta cta-gold" x-on:click="open = false">Pesan sekarang</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="cta cta-outline">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="cta cta-gold" x-on:click="open = false">Daftar</a>
                    <a href="{{ route('login') }}" class="cta cta-outline" x-on:click="open = false">Masuk</a>
                @endauth
            </div>

            <p class="mt-8 text-[11px] uppercase tracking-[0.2em] text-muted">Katering rumahan khas Bogor</p>
        </div>
    </div>
</header>
