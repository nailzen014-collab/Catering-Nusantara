@extends('layouts.app')

@section('title', 'Beranda')

@section('extra-style')
    .hero {
        background: var(--ink);
        color: var(--cream);
        padding: 90px 0 70px;
    }
    .hero .container {
        display: flex;
        align-items: center;
        gap: 48px;
        flex-wrap: wrap;
    }
    .hero-text { flex: 1; min-width: 280px; }
    .hero-text h1 { font-size: 2.4rem; line-height: 1.15; color: var(--cream); margin-bottom: 16px; }
    .hero-text p { color: #D9C7A6; font-size: 1.05rem; max-width: 420px; margin-bottom: 28px; }
    .hero-text .cta-btn {
        display: inline-block;
        background: var(--clay);
        color: #fff;
        padding: 13px 30px;
        border-radius: 6px 20px 6px 20px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
    }
    .hero-visual { flex: 1; min-width: 220px; text-align: center; font-size: 7rem; line-height: 1; }

    .section-inner { padding: 64px 0; }
    .section-inner h2 { color: var(--clay-dark); font-size: 1.5rem; margin-bottom: 32px; }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }
    .menu-card {
        background: var(--card);
        border-radius: 4px 18px 4px 18px;
        padding: 22px;
        border: 1px solid var(--line);
    }
    .menu-card .ribbon.category { background: var(--turmeric); border-radius: 0 10px 10px 0; }
    .menu-card h3 { margin: 10px 0 4px; font-size: 1.05rem; font-family: var(--font-display); }
    .menu-card .price { color: var(--clay-dark); font-weight: 700; font-family: var(--font-display); }

    .testi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
    }
    .testi-card {
        background: var(--card);
        border-radius: 18px 4px 18px 4px;
        padding: 24px;
        border: 1px solid var(--line);
    }
    .testi-card p { font-style: italic; color: #5A4632; margin-bottom: 14px; }
    .testi-card .name { font-weight: 700; color: var(--clay-dark); font-family: var(--font-display); }
    .testi-card .role { font-size: 0.85rem; color: #8A7458; }

    .cta-section {
        background: var(--clay);
        color: #fff;
        text-align: center;
        padding: 70px 20px;
    }
    .cta-section h2 { color: #fff; margin-bottom: 12px; }
    .cta-section .cta-btn {
        display: inline-block;
        margin-top: 12px;
        background: var(--ink);
        color: var(--cream);
        padding: 14px 34px;
        border-radius: 6px 20px 6px 20px;
        text-decoration: none;
        font-weight: 700;
    }
@endsection

@section('content')

    {{-- HERO --}}
    <div class="hero">
        <div class="container">
            <div class="hero-text">
                <h1>Masakan rumahan, untuk momen yang layak dirayakan</h1>
                <p>Nasi box, prasmanan, snack box, dan tumpeng mini — dimasak dengan resep rumahan khas Bogor.</p>
              <a href="{{ route('checkout') }}" class="cta-btn">
    Pesan Sekarang
</a>
            </div>
            <div class="hero-visual">🍛</div>
        </div>
    </div>

    {{-- PROFIL --}}
    <section class="section-inner">
        <div class="container" style="max-width:700px; text-align:center;">
            <h2>Tentang Kami</h2>
            <p style="line-height:1.8; color:#5A4632;">
                Rasa Nusantara melayani kebutuhan katering untuk pernikahan, acara kantor, dan acara keluarga
                dengan cita rasa masakan rumahan yang hangat dan autentik. Kami percaya setiap acara istimewa
                layak mendapat hidangan terbaik.
            </p>
        </div>
    </section>

    {{-- MENU UNGGULAN (dari database, eager loading) --}}
    <section class="section-inner" style="background: var(--card);">
        <div class="container">
            <h2>Menu Unggulan</h2>
            <div class="menu-grid">
                @forelse ($menus as $menu)
                    <div class="menu-card">
                        <span class="ribbon category">{{ $menu->category->name }}</span>
                        <h3>{{ $menu->name }}</h3>
                        <div class="price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                    </div>
                @empty
                    <div class="empty-state">
                        <strong>Menu belum tersedia</strong>
                        Data menu akan tampil di sini setelah database diisi.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- TESTIMONI (data statis/dummy — tidak ada tabel testimonials di skema) --}}
    <section class="section-inner">
        <div class="container">
            <h2>Apa Kata Pelanggan</h2>
            <div class="testi-grid">
                @php
                    $testimonials = [
                        ['name' => 'Ibu Sari', 'role' => 'Acara Pernikahan', 'text' => 'Rasa masakannya benar-benar seperti buatan rumah, tamu-tamu banyak yang puas.'],
                        ['name' => 'Pak Andi', 'role' => 'Acara Kantor', 'text' => 'Pengiriman tepat waktu dan menu bervariasi, cocok untuk acara rutin kantor kami.'],
                        ['name' => 'Ibu Rina', 'role' => 'Acara Keluarga', 'text' => 'Tumpeng mininya cantik dan enak, pas untuk acara syukuran keluarga.'],
                    ];
                @endphp
                @foreach ($testimonials as $t)
                    <div class="testi-card">
                        <p>"{{ $t['text'] }}"</p>
                        <div class="name">{{ $t['name'] }}</div>
                        <div class="role">{{ $t['role'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA PENUTUP --}}
    <div class="cta-section">
        <h2>Siap pesan untuk acara kamu?</h2>
        <p>Konsultasikan kebutuhan katering kamu langsung lewat WhatsApp.</p>
        <a href="{{ route('checkout') }}" class="cta-btn">
    Pesan Sekarang
</a>
    </div>

@endsection