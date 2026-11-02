@extends('layouts.app')

@section('title', 'Beranda')

@section('extra-style')
    .landing-page {
        background:
            radial-gradient(circle at 12% 8%, rgba(201, 163, 91, 0.10), transparent 38%),
            radial-gradient(circle at 88% 42%, rgba(201, 163, 91, 0.06), transparent 34%),
            #0e2619;
        color: #f6efe1;
    }

    .landing-page .lp-container {
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
    }

    .landing-page section {
        scroll-margin-top: 90px;
    }

    .lp-hero {
        padding: 34px 0 24px;
    }

    .lp-hero-card {
        position: relative;
        min-height: 560px;
        border-radius: 26px;
        overflow: hidden;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        box-shadow: 0 30px 70px rgba(0, 0, 0, 0.28);
    }

    .lp-hero-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(
            90deg,
            rgba(8, 22, 15, 0.95) 0%,
            rgba(8, 22, 15, 0.78) 38%,
            rgba(8, 22, 15, 0.22) 70%,
            rgba(8, 22, 15, 0.04) 100%
        );
    }

    .lp-hero-content {
        position: relative;
        z-index: 1;
        max-width: 540px;
        padding: 64px 58px;
    }

    .lp-eyebrow {
        margin: 0 0 14px;
        color: #c9a35b;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.22em;
        text-transform: uppercase;
    }

    .lp-hero-content h1 {
        margin: 0 0 18px;
        font-family: var(--font-display);
        font-size: clamp(2.7rem, 5vw, 4.3rem);
        line-height: 1.03;
        font-weight: 600;
        color: #f6efe1;
    }

    .lp-hero-content h1 em {
        color: #e7d2a8;
        font-style: italic;
    }

    .lp-hero-content p {
        margin: 0 0 28px;
        max-width: 430px;
        color: #cfc3ae;
        font-size: 1rem;
        line-height: 1.75;
    }

    .lp-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .lp-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 13px 25px;
        border-radius: 999px;
        border: 1px solid transparent;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 700;
        transition: 0.2s ease;
    }

    .lp-btn-gold {
        background: #c9a35b;
        color: #12251a;
    }

    .lp-btn-gold:hover {
        background: #ddba74;
        transform: translateY(-1px);
    }

    .lp-btn-ghost {
        border-color: rgba(246, 239, 225, 0.35);
        color: #f6efe1;
    }

    .lp-btn-ghost:hover {
        border-color: #c9a35b;
        color: #e7d2a8;
    }

    .lp-btn-outline {
        border-color: rgba(201, 163, 91, 0.7);
        color: #e7d2a8;
    }

    .lp-btn-outline:hover {
        background: rgba(201, 163, 91, 0.12);
    }

    .lp-section {
        padding: 72px 0;
    }

    .lp-split {
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        gap: 60px;
        align-items: center;
    }

    .lp-intro h2,
    .lp-menu-head h2,
    .lp-kitchen-text h2 {
        margin: 0 0 20px;
        font-family: var(--font-display);
        font-style: italic;
        font-size: clamp(2.1rem, 3.6vw, 3.1rem);
        font-weight: 600;
        color: #f3ead8;
        line-height: 1.1;
    }

    .lp-intro p {
        margin: 0 0 26px;
        max-width: 420px;
        color: #c8bca8;
        line-height: 1.8;
    }

    .lp-product-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .lp-product {
        display: grid;
        grid-template-columns: 1fr 118px;
        gap: 20px;
        align-items: center;
        padding: 16px 18px;
        border-radius: 16px;
        background: #f3ecdd;
        color: #1e3627;
        box-shadow: 0 14px 36px rgba(0, 0, 0, 0.16);
    }

    .lp-product h3 {
        margin: 0 0 6px;
        font-family: var(--font-display);
        font-size: 1.08rem;
        color: #1e3627;
    }

    .lp-product p {
        margin: 0;
        font-size: 0.84rem;
        line-height: 1.6;
        color: #5d6b5f;
    }

    .lp-product strong {
        display: block;
        margin-top: 8px;
        color: #8a672d;
        font-size: 0.82rem;
    }

    .lp-product img {
        width: 118px;
        height: 92px;
        object-fit: cover;
        border-radius: 12px;
        display: block;
    }

    .lp-menu-section {
        padding: 16px 0 72px;
    }

    .lp-menu-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 26px;
    }

    .lp-menu-head p {
        margin: 0;
        max-width: 380px;
        color: #a99c86;
        font-size: 0.9rem;
        line-height: 1.7;
    }

    .lp-menu-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .lp-menu-card {
        padding: 22px;
        border: 1px solid rgba(201, 163, 91, 0.22);
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.035);
    }

    .lp-menu-card .cat {
        display: block;
        margin-bottom: 10px;
        color: #c9a35b;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
    }

    .lp-menu-card h3 {
        margin: 0 0 12px;
        font-family: var(--font-display);
        font-size: 1.08rem;
        line-height: 1.4;
        color: #f3ead8;
    }

    .lp-menu-card .price {
        color: #c9a35b;
        font-weight: 700;
        font-size: 0.94rem;
    }

    .lp-quality {
        padding: 24px 0 72px;
    }

    .lp-quality-card {
        position: relative;
        min-height: 430px;
        border-radius: 24px;
        overflow: hidden;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.26);
    }

    .lp-quality-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(
            270deg,
            rgba(8, 22, 15, 0.96) 0%,
            rgba(8, 22, 15, 0.68) 44%,
            rgba(8, 22, 15, 0.08) 100%
        );
    }

    .lp-quality-content {
        position: relative;
        z-index: 1;
        max-width: 500px;
        padding: 52px 58px;
        text-align: right;
    }

    .lp-quality-content h2 {
        margin: 0 0 18px;
        font-family: var(--font-display);
        font-style: italic;
        font-size: clamp(2.1rem, 3.8vw, 3.2rem);
        line-height: 1.08;
        color: #c9a35b;
    }

    .lp-quality-content p {
        margin: 0;
        color: #e4d9c6;
        line-height: 1.8;
        font-size: 0.95rem;
    }

    .lp-kitchen {
        padding: 16px 0 78px;
    }

    .lp-split-reverse {
        grid-template-columns: 1fr 1fr;
    }

    .lp-kitchen-text {
        text-align: center;
    }

    .lp-kitchen-text h3 {
        margin: 24px 0 8px;
        font-family: var(--font-display);
        font-size: 1.16rem;
        color: #c9a35b;
    }

    .lp-kitchen-text p {
        margin: 0 auto;
        max-width: 420px;
        color: #c8bca8;
        font-size: 0.9rem;
        line-height: 1.75;
    }

    .lp-kitchen-visual {
        position: relative;
        padding: 14px;
    }

    .lp-kitchen-visual::before {
        content: "";
        position: absolute;
        inset: 0;
        border: 1px solid rgba(201, 163, 91, 0.38);
        border-radius: 22px;
        transform: translate(12px, 12px);
    }

    .lp-kitchen-visual img {
        position: relative;
        display: block;
        width: 100%;
        height: 470px;
        object-fit: cover;
        border-radius: 18px;
    }

    .lp-testimonials {
        padding: 20px 0 84px;
    }

    .lp-testi-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .lp-testi-card {
        padding: 28px 24px;
        border-radius: 16px;
        background: #f3ecdd;
        color: #1e3627;
        text-align: center;
    }

    .lp-testi-card p {
        margin: 0 0 18px;
        color: #425245;
        font-size: 0.9rem;
        font-style: italic;
        line-height: 1.75;
    }

    .lp-testi-card .name {
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 600;
        color: #1e3627;
    }

    .lp-testi-card .role {
        margin-top: 3px;
        color: #7c877c;
        font-size: 0.76rem;
    }

    .lp-footer {
        padding: 58px 0 36px;
        border-top: 1px solid rgba(201, 163, 91, 0.18);
        background: #0a1d13;
    }

    .lp-footer-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
        gap: 36px;
    }

    .lp-footer .brand {
        margin: 0 0 12px;
        font-family: var(--font-display);
        font-style: italic;
        font-size: 1.6rem;
        color: #f3ead8;
    }

    .lp-footer h4 {
        margin: 0 0 14px;
        font-family: var(--font-display);
        font-size: 1rem;
        color: #c9a35b;
    }

    .lp-footer p,
    .lp-footer a,
    .lp-footer li {
        color: #bcb09b;
        font-size: 0.85rem;
        line-height: 1.9;
    }

    .lp-footer a {
        text-decoration: none;
    }

    .lp-footer a:hover {
        color: #f3ead8;
    }

    .lp-footer ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .lp-footer .lp-copy {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid rgba(201, 163, 91, 0.12);
        color: #8f8575;
        font-size: 0.78rem;
    }

    @media (max-width: 900px) {
        .lp-split,
        .lp-split-reverse,
        .lp-footer-grid {
            grid-template-columns: 1fr;
            gap: 34px;
        }

        .lp-menu-grid,
        .lp-testi-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .lp-hero-card {
            min-height: auto;
        }

        .lp-hero-content {
            padding: 46px 30px;
        }

        .lp-quality-card {
            justify-content: flex-start;
        }

        .lp-quality-content {
            padding: 46px 30px;
            text-align: left;
        }

        .lp-quality-card::before {
            background: linear-gradient(
                90deg,
                rgba(8, 22, 15, 0.95) 0%,
                rgba(8, 22, 15, 0.72) 55%,
                rgba(8, 22, 15, 0.18) 100%
            );
        }

        .lp-kitchen-visual img {
            height: 380px;
        }
    }

    @media (max-width: 600px) {
        .landing-page .lp-container {
            width: calc(100% - 30px);
        }

        .lp-menu-grid,
        .lp-testi-grid {
            grid-template-columns: 1fr;
        }

        .lp-hero-content {
            padding: 38px 22px;
        }

        .lp-product {
            grid-template-columns: 1fr;
        }

        .lp-product img {
            width: 100%;
            height: 160px;
            order: -1;
        }

        .lp-menu-head {
            align-items: flex-start;
            flex-direction: column;
        }
    }
@endsection

@section('content')

    @php
        $products = [
            [
                'name' => 'Nasi Box',
                'image' => 'images/landing/nasi-box.jpg',
                'description' => 'Nasi box lengkap dengan lauk pilihan, cocok untuk rapat dan acara kantor.',
                'price' => 'Mulai dari Rp 25.000',
            ],
            [
                'name' => 'Tumpeng Mini',
                'image' => 'images/landing/tumpeng.jpg',
                'description' => 'Tumpeng mini untuk syukuran dan perayaan dengan tampilan cantik.',
                'price' => 'Mulai dari Rp 150.000',
            ],
            [
                'name' => 'Snack Box',
                'image' => 'images/landing/snack-box.jpg',
                'description' => 'Snack box berisi aneka kue dan camilan untuk tamu undangan.',
                'price' => 'Mulai dari Rp 20.000',
            ],
        ];

        $testimonials = [
            [
                'name' => 'Ibu Sari',
                'role' => 'Acara Pernikahan',
                'text' => 'Rasa masakannya benar-benar seperti buatan rumah. Tamu-tamu banyak yang puas.',
            ],
            [
                'name' => 'Pak Andi',
                'role' => 'Acara Kantor',
                'text' => 'Pengiriman tepat waktu dan menu bervariasi, cocok untuk acara rutin kantor kami.',
            ],
            [
                'name' => 'Ibu Rina',
                'role' => 'Acara Keluarga',
                'text' => 'Tumpeng mininya cantik dan enak, pas untuk acara syukuran keluarga.',
            ],
        ];
    @endphp

    <div class="landing-page">

        <section class="lp-hero">
            <div class="lp-container">
                <div class="lp-hero-card" style="background-image: url('{{ asset('images/landing/hero.jpg') }}');">
                    <div class="lp-hero-content">
                        <p class="lp-eyebrow">Katering Rumahan Khas Bogor</p>
                        <h1>Terpercaya untuk<br><em>Setiap Momen</em></h1>
                        <p>
                            Nasi box, prasmanan, snack box, dan tumpeng mini dimasak dengan
                            resep rumahan khas Bogor untuk pernikahan, acara kantor, dan keluarga.
                        </p>
                        <div class="lp-hero-actions">
                            <a href="{{ route('checkout') }}" class="lp-btn lp-btn-gold">Pesan Sekarang</a>
                            <a href="#produk" class="lp-btn lp-btn-ghost">Info Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="produk" class="lp-section">
            <div class="lp-container lp-split">
                <div class="lp-intro">
                    <h2>Produk Kami</h2>
                    <p>
                        Pilih hidangan yang paling sesuai untuk acara Anda. Semua menu
                        dimasak segar setiap hari dengan bahan pilihan.
                    </p>
                    <a href="{{ route('checkout') }}" class="lp-btn lp-btn-outline">Lihat Menu</a>
                </div>

                <div class="lp-product-list">
                    @foreach ($products as $product)
                        <div class="lp-product">
                            <div>
                                <h3>{{ $product['name'] }}</h3>
                                <p>{{ $product['description'] }}</p>
                                <strong>{{ $product['price'] }}</strong>
                            </div>
                            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="menu" class="lp-menu-section">
            <div class="lp-container">
                <div class="lp-menu-head">
                    <h2>Menu Pilihan</h2>
                    <p>Sebagian menu favorit yang tersedia untuk dipesan hari ini.</p>
                </div>

                <div class="lp-menu-grid">
                    @forelse ($menus as $menu)
                        <div class="lp-menu-card">
                            <span class="cat">{{ $menu->category->name }}</span>
                            <h3>{{ $menu->name }}</h3>
                            <div class="price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                        </div>
                    @empty
                        <div class="lp-menu-card">
                            <span class="cat">Menu</span>
                            <h3>Menu belum tersedia</h3>
                            <div class="price">Silakan cek kembali nanti.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="lp-quality">
            <div class="lp-container">
                <div class="lp-quality-card" style="background-image: url('{{ asset('images/landing/halal.jpg') }}');">
                    <div class="lp-quality-content">
                        <h2>Kualitas Terjamin<br>dan Halal</h2>
                        <p>
                            Kami menjaga kualitas dari bahan baku hingga proses masak. Dapur
                            kami bersih, bahan dipilih segar, dan setiap hidangan disiapkan
                            dengan standar kebersihan yang tinggi.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="lp-kitchen">
            <div class="lp-container lp-split lp-split-reverse">
                <div class="lp-kitchen-text">
                    <h2>Kapasitas Dapur Kami</h2>

                    <h3>Kapasitas Produksi Besar</h3>
                    <p>Mampu melayani hingga ratusan porsi per hari untuk acara besar.</p>

                    <h3>Peralatan Modern</h3>
                    <p>Didukung peralatan masak modern dan tim dapur yang berpengalaman.</p>

                    <h3>Dimasak oleh Koki Profesional</h3>
                    <p>Setiap menu dimasak oleh koki yang berpengalaman di bidang katering.</p>
                </div>

                <div class="lp-kitchen-visual">
                    <img src="{{ asset('images/landing/kitchen.jpg') }}" alt="Dapur Rasa Nusantara" loading="lazy">
                </div>
            </div>
        </section>

        <section id="testimoni" class="lp-testimonials">
            <div class="lp-container">
                <div class="lp-testi-grid">
                    @foreach ($testimonials as $testimonial)
                        <div class="lp-testi-card">
                            <p>"{{ $testimonial['text'] }}"</p>
                            <div class="name">{{ $testimonial['name'] }}</div>
                            <div class="role">{{ $testimonial['role'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <footer id="kontak" class="lp-footer">
            <div class="lp-container">
                <div class="lp-footer-grid">
                    <div>
                        <div class="brand">Rasa Nusantara</div>
                        <p>Cita rasa rumahan khas Bogor untuk setiap momen istimewa.</p>
                    </div>

                    <div>
                        <h4>Menu</h4>
                        <ul>
                            <li><a href="{{ route('landing') }}">Beranda</a></li>
                            <li><a href="#menu">Menu Pilihan</a></li>
                            <li><a href="#tentang">Tentang Kami</a></li>
                            <li><a href="#testimoni">Testimoni</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4>Kontak</h4>
                        <p>
                            WhatsApp<br>
                            <a href="https://wa.me/6281234567890">0812-3456-7890</a>
                        </p>
                        <p>
                            Email<br>
                            <a href="mailto:hello@rasanusantara.test">hello@rasanusantara.test</a>
                        </p>
                    </div>

                    <div>
                        <h4>Lokasi</h4>
                        <p>
                            Bogor, Jawa Barat<br>
                            Melayani pernikahan, acara kantor, dan keluarga.
                        </p>
                    </div>
                </div>

                <div class="lp-copy">
                    &copy; {{ date('Y') }} Rasa Nusantara. Seluruh hak cipta dilindungi.
                </div>
            </div>
        </footer>

    </div>

@endsection
