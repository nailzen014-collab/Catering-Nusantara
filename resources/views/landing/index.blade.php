@extends('layouts.app')

@section('title', 'Katering Rumahan Khas Bogor')
@section('description', 'Nasi box, prasmanan, snack box, dan tumpeng mini dimasak dengan resep rumahan khas Bogor untuk pernikahan, acara kantor, dan keluarga.')

@section('content')

    @php
        $services = [
            [
                'name' => 'Nasi Box',
                'tag' => 'Rapat & acara kantor',
                'image' => 'images/landing/nasi-box.jpg',
                'description' => 'Nasi hangat dengan lauk pilihan, dikemas rapi dan siap dibagikan.',
                'price' => 'Rp 25.000',
                'unit' => 'per box',
            ],
            [
                'name' => 'Prasmanan',
                'tag' => 'Pernikahan & syukuran',
                'image' => 'images/landing/hero.jpg',
                'description' => 'Hidangan berbagi dengan prasmanan, porsi disesuaikan jumlah tamu.',
                'price' => 'Sesuai menu',
                'unit' => 'hubungi kami',
            ],
            [
                'name' => 'Snack Box',
                'tag' => 'Tamu undangan',
                'image' => 'images/landing/snack-box.jpg',
                'description' => 'Aneka kue dan camilan rumahan dalam kemasan praktis.',
                'price' => 'Rp 20.000',
                'unit' => 'per box',
            ],
            [
                'name' => 'Tumpeng Mini',
                'tag' => 'Syukuran & perayaan',
                'image' => 'images/landing/tumpeng.jpg',
                'description' => 'Tumpeng berukuran kecil dengan tampilan rapi untuk meja perayaan.',
                'price' => 'Rp 150.000',
                'unit' => 'per tumpeng',
            ],
        ];

        $testimonials = [
            [
                'name' => 'Ibu Sari',
                'role' => 'Acara pernikahan',
                'text' => 'Rasa masakannya benar-benar seperti buatan rumah. Tamu-tamu banyak yang puas dan sempat bertanya kateringnya dari mana.',
            ],
            [
                'name' => 'Pak Andi',
                'role' => 'Acara kantor',
                'text' => 'Pengiriman tepat waktu dan pilihan menunya bervariasi. Sudah beberapa kali pesan untuk acara rutin kantor kami.',
            ],
            [
                'name' => 'Ibu Rina',
                'role' => 'Acara keluarga',
                'text' => 'Tumpeng mininya cantik dan enak, pas untuk syukuran keluarga. Komunikasinya juga enak, tidak ribet.',
            ],
        ];
    @endphp

    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute -right-32 top-16 hidden h-[420px] w-[420px] rounded-full border border-ink/5 lg:block"></div>

        <div class="relative mx-auto grid w-full max-w-shell gap-12 px-5 pb-14 pt-10 sm:px-8 lg:grid-cols-12 lg:items-end lg:gap-10 lg:pb-20 lg:pt-16">
            <div class="reveal lg:col-span-7">
                <p class="eyebrow">Katering rumahan &middot; Bogor</p>

                <h1 class="mt-5 font-display text-[clamp(2.5rem,6.2vw,5.2rem)] font-semibold leading-[0.96] tracking-[-0.015em] text-ink">
                    Masakan rumahan,<br>
                    untuk momen yang
                    <em class="text-clay">layak dirayakan.</em>
                </h1>

                <p class="mt-6 max-w-prose text-[15px] leading-relaxed text-ink/70 sm:text-base">
                    Nasi box, prasmanan, snack box, dan tumpeng mini dimasak segar setiap hari
                    dengan resep keluarga khas Bogor — untuk pernikahan, acara kantor, dan
                    kumpul keluarga.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="{{ route('checkout') }}" class="cta cta-gold">
                        Pesan sekarang
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                    <a href="#menu" class="cta cta-outline">Lihat menu</a>
                </div>

                <dl class="mt-12 grid max-w-lg grid-cols-3 gap-4 border-t border-ink/15 pt-6">
                    <div>
                        <dt class="text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Layanan</dt>
                        <dd class="mt-1 font-display text-xl text-ink">5 jenis</dd>
                    </div>
                    <div class="border-l border-ink/15 pl-4">
                        <dt class="text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Dapur</dt>
                        <dd class="mt-1 font-display text-xl text-ink">Halal</dd>
                    </div>
                    <div class="border-l border-ink/15 pl-4">
                        <dt class="text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Jangkauan</dt>
                        <dd class="mt-1 font-display text-xl text-ink">Bogor</dd>
                    </div>
                </dl>
            </div>

            <div class="reveal lg:col-span-5">
                <figure class="relative">
                    <div class="absolute -left-3 -top-3 h-full w-full border border-turmeric/60" aria-hidden="true"></div>
                    <img src="{{ asset('images/landing/hero.jpg') }}" alt="Hidangan Rasa Nusantara"
                        class="relative aspect-[4/5] w-full object-cover" width="640" height="800">
                    <img src="{{ asset('images/landing/nasi-box.jpg') }}" alt="Nasi box Rasa Nusantara"
                        class="absolute -bottom-8 -left-8 hidden w-32 border-4 border-cream object-cover sm:block lg:w-40"
                        width="320" height="240" loading="lazy">
                    <figcaption class="mt-4 flex items-baseline justify-between gap-4 text-[11px] uppercase tracking-[0.16em] text-muted">
                        <span>Dapur Rasa Nusantara</span>
                        <span>Bogor, Jawa Barat</span>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    {{-- Layanan band --}}
    <div class="border-y border-ink/15 bg-paper">
        <div class="mx-auto flex w-full max-w-shell flex-wrap items-center justify-between gap-x-8 gap-y-2 px-5 py-4 text-[11px] font-semibold uppercase tracking-[0.2em] text-ink/60 sm:px-8">
            <span>Nasi Box</span>
            <span class="hidden h-1 w-1 rounded-full bg-clay/60 sm:block" aria-hidden="true"></span>
            <span>Prasmanan</span>
            <span class="hidden h-1 w-1 rounded-full bg-clay/60 sm:block" aria-hidden="true"></span>
            <span>Snack Box</span>
            <span class="hidden h-1 w-1 rounded-full bg-clay/60 sm:block" aria-hidden="true"></span>
            <span>Tumpeng Mini</span>
            <span class="hidden h-1 w-1 rounded-full bg-clay/60 sm:block" aria-hidden="true"></span>
            <span>Kue &amp; Minuman</span>
        </div>
    </div>

    {{-- Paket --}}
    <section id="paket" class="scroll-mt-24">
        <div class="mx-auto w-full max-w-shell px-5 py-16 sm:px-8 lg:py-24">
            <div class="flex flex-wrap items-end justify-between gap-4 border-b border-ink/15 pb-4">
                <div class="flex items-baseline gap-4">
                    <span class="font-display text-sm italic text-clay">01</span>
                    <h2 class="font-display text-3xl font-semibold text-ink sm:text-4xl">Paket &amp; layanan</h2>
                </div>
                <p class="max-w-xs text-sm leading-relaxed text-ink/55">
                    Semua paket bisa disesuaikan dengan jumlah tamu dan kebutuhan acara.
                </p>
            </div>

            <ul class="divide-y divide-ink/10">
                @foreach ($services as $service)
                    <li class="reveal">
                        <a href="{{ route('checkout') }}"
                            class="group grid grid-cols-[72px_1fr_auto] items-center gap-5 py-6 sm:grid-cols-[104px_1fr_auto] sm:gap-7">
                            <div class="overflow-hidden bg-ink/5">
                                <img src="{{ asset($service['image']) }}" alt="{{ $service['name'] }}"
                                    class="h-[72px] w-[72px] object-cover transition-transform duration-500 group-hover:scale-105 sm:h-24 sm:w-24"
                                    width="208" height="208" loading="lazy">
                            </div>

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-baseline gap-x-3 gap-y-1">
                                    <h3 class="font-display text-xl font-semibold text-ink sm:text-[1.4rem]">{{ $service['name'] }}</h3>
                                    <span class="text-[10px] font-semibold uppercase tracking-[0.16em] text-muted">{{ $service['tag'] }}</span>
                                </div>
                                <p class="mt-1 max-w-md text-sm leading-relaxed text-ink/60">{{ $service['description'] }}</p>
                            </div>

                            <div class="text-right">
                                <p class="font-display text-base text-ink sm:text-lg">{{ $service['price'] }}</p>
                                <span class="text-[11px] text-muted">{{ $service['unit'] }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Menu --}}
    <section id="menu" class="scroll-mt-24 border-y border-ink/10 bg-paper">
        <div class="mx-auto w-full max-w-shell px-5 py-16 sm:px-8 lg:py-24" x-data="{ cat: 'Semua' }">
            <div class="flex flex-wrap items-end justify-between gap-4 border-b border-ink/15 pb-4">
                <div class="flex items-baseline gap-4">
                    <span class="font-display text-sm italic text-clay">02</span>
                    <h2 class="font-display text-3xl font-semibold text-ink sm:text-4xl">Menu pilihan</h2>
                </div>
                <p class="max-w-xs text-sm leading-relaxed text-ink/55">
                    Sebagian menu yang tersedia hari ini. Menu lengkap ada di halaman pemesanan.
                </p>
            </div>

            @if ($menus->isNotEmpty())
                <div class="mt-6 flex flex-wrap gap-2" role="tablist" aria-label="Filter kategori menu">
                    <button type="button" x-on:click="cat = 'Semua'"
                        :class="cat === 'Semua' ? 'border-ink bg-ink text-cream' : 'border-ink/20 text-ink/70 hover:border-ink/50'"
                        class="rounded-full border px-4 py-1.5 text-xs font-semibold tracking-wide transition-colors"
                        :aria-pressed="cat === 'Semua' ? 'true' : 'false'">
                        Semua
                    </button>

                    @foreach ($categories as $category)
                        <button type="button" x-on:click="cat = @js($category)"
                            :class="cat === @js($category) ? 'border-ink bg-ink text-cream' : 'border-ink/20 text-ink/70 hover:border-ink/50'"
                            class="rounded-full border px-4 py-1.5 text-xs font-semibold tracking-wide transition-colors"
                            :aria-pressed="cat === @js($category) ? 'true' : 'false'">
                            {{ $category }}
                        </button>
                    @endforeach
                </div>

                <div class="mt-8 grid gap-x-14 gap-y-1 md:grid-cols-2">
                    @foreach ($menus as $menu)
                        @php $categoryName = $menu->category?->name ?? 'Lainnya'; @endphp
                        <div x-show="cat === 'Semua' || cat === @js($categoryName)"
                            class="flex items-baseline gap-3 border-b border-ink/10 py-3">
                            <span class="font-display text-[15px] leading-snug text-ink">{{ $menu->name }}</span>
                            <span class="leader" aria-hidden="true"></span>
                            <span class="shrink-0 text-sm tabular-nums text-ink/70">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mt-8 text-sm text-ink/60">Menu belum tersedia. Silakan cek kembali nanti.</p>
            @endif

            <div class="mt-10 flex flex-wrap items-center justify-between gap-4">
                <p class="text-xs text-muted">Harga dapat berubah sesuai jumlah pesanan dan lokasi pengiriman.</p>
                <a href="{{ route('checkout') }}" class="cta cta-outline">Pesan menu lengkap</a>
            </div>
        </div>
    </section>

    {{-- Dapur --}}
    <section id="tentang" class="scroll-mt-24">
        <div class="mx-auto grid w-full max-w-shell gap-12 px-5 py-16 sm:px-8 lg:grid-cols-12 lg:items-center lg:gap-16 lg:py-24">
            <figure class="reveal relative lg:col-span-6">
                <img src="{{ asset('images/landing/kitchen.jpg') }}" alt="Dapur Rasa Nusantara"
                    class="aspect-[4/3] w-full object-cover" width="960" height="720" loading="lazy">
                <img src="{{ asset('images/landing/halal.jpg') }}" alt="Sertifikasi halal"
                    class="absolute -bottom-6 right-5 w-24 rotate-[-2deg] border-4 border-cream object-cover sm:w-28"
                    width="224" height="224" loading="lazy">
            </figure>

            <div class="reveal lg:col-span-6">
                <p class="eyebrow">03 &mdash; Dapur kami</p>
                <h2 class="mt-4 font-display text-[clamp(1.9rem,3.4vw,2.8rem)] font-semibold leading-[1.08] text-ink">
                    Dimasak seperti di rumah,<br class="hidden sm:block">
                    ditangani seperti acara besar.
                </h2>

                <ul class="mt-8 divide-y divide-ink/10 border-t border-ink/10">
                    <li class="grid grid-cols-[2.5rem_1fr] gap-4 py-5">
                        <span class="font-display text-sm italic text-clay">01</span>
                        <div>
                            <h3 class="font-display text-lg text-ink">Kapasitas produksi besar</h3>
                            <p class="mt-1 text-sm leading-relaxed text-ink/60">Mampu melayani ratusan porsi per hari untuk acara besar maupun pesanan rutin.</p>
                        </div>
                    </li>
                    <li class="grid grid-cols-[2.5rem_1fr] gap-4 py-5">
                        <span class="font-display text-sm italic text-clay">02</span>
                        <div>
                            <h3 class="font-display text-lg text-ink">Bahan segar, dapur bersih</h3>
                            <p class="mt-1 text-sm leading-relaxed text-ink/60">Bahan dipilih setiap hari dan diolah di dapur dengan standar kebersihan yang ketat.</p>
                        </div>
                    </li>
                    <li class="grid grid-cols-[2.5rem_1fr] gap-4 py-5">
                        <span class="font-display text-sm italic text-clay">03</span>
                        <div>
                            <h3 class="font-display text-lg text-ink">Dimasak koki berpengalaman</h3>
                            <p class="mt-1 text-sm leading-relaxed text-ink/60">Resep rumahan yang dijaga konsistensinya oleh tim dapur yang sudah terbiasa menangani acara.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Testimoni --}}
    <section id="testimoni" class="scroll-mt-24 bg-ink text-cream">
        <div class="mx-auto w-full max-w-shell px-5 py-16 sm:px-8 lg:py-24" x-data>
            <div class="flex flex-wrap items-end justify-between gap-6 border-b border-cream/15 pb-4">
                <div class="flex items-baseline gap-4">
                    <span class="font-display text-sm italic text-turmeric">04</span>
                    <h2 class="font-display text-3xl font-semibold text-cream sm:text-4xl">Kata mereka</h2>
                </div>

                <div class="flex gap-2">
                    <button type="button" aria-label="Testimoni sebelumnya"
                        x-on:click="$refs.track.scrollBy({ left: -360, behavior: 'smooth' })"
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-cream/25 text-cream transition-colors hover:border-turmeric hover:text-turmeric">
                        <span aria-hidden="true">&larr;</span>
                    </button>
                    <button type="button" aria-label="Testimoni berikutnya"
                        x-on:click="$refs.track.scrollBy({ left: 360, behavior: 'smooth' })"
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-cream/25 text-cream transition-colors hover:border-turmeric hover:text-turmeric">
                        <span aria-hidden="true">&rarr;</span>
                    </button>
                </div>
            </div>

            <div x-ref="track" class="no-scrollbar mt-8 flex snap-x snap-mandatory gap-6 overflow-x-auto pb-2">
                @foreach ($testimonials as $testimonial)
                    <figure class="min-w-[85%] snap-start border-t border-cream/20 pt-6 sm:min-w-[58%] lg:min-w-[calc(33.333%-1rem)]">
                        <blockquote class="font-display text-lg italic leading-relaxed text-cream/90">
                            &ldquo;{{ $testimonial['text'] }}&rdquo;
                        </blockquote>
                        <figcaption class="mt-6">
                            <div class="text-sm font-semibold text-cream">{{ $testimonial['name'] }}</div>
                            <div class="mt-0.5 text-[11px] uppercase tracking-[0.16em] text-cream/45">{{ $testimonial['role'] }}</div>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA / Kontak --}}
    <footer id="kontak" class="scroll-mt-24 bg-ink text-cream">
        <div class="mx-auto w-full max-w-shell px-5 pb-10 pt-4 sm:px-8">
            <div class="grid gap-8 border-t border-cream/15 py-12 lg:grid-cols-2 lg:items-end">
                <div>
                    <p class="eyebrow text-turmeric">Punya acara?</p>
                    <h2 class="mt-3 font-display text-[clamp(2rem,4.4vw,3.4rem)] font-semibold leading-[1.02] text-cream">
                        Mari kita siapkan mejanya.
                    </h2>
                    <p class="mt-4 max-w-md text-sm leading-relaxed text-cream/60">
                        Ceritakan tanggal, jumlah tamu, dan menu yang diinginkan. Kami bantu susun
                        paket yang pas.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3 lg:justify-end">
                    <a href="https://wa.me/6285694595270" target="_blank" rel="noopener noreferrer" class="cta cta-gold">
                        WhatsApp
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                    <a href="{{ route('checkout') }}" class="cta cta-outline-light">Pesan sekarang</a>
                </div>
            </div>

            <div class="grid gap-8 border-t border-cream/15 pt-8 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <div class="font-display text-xl italic text-cream">Rasa Nusantara</div>
                    <p class="mt-3 max-w-[22ch] text-sm leading-relaxed text-cream/55">
                        Cita rasa rumahan khas Bogor untuk setiap momen istimewa.
                    </p>
                </div>

                <div>
                    <h3 class="text-[10px] font-semibold uppercase tracking-[0.2em] text-cream/40">Jelajahi</h3>
                    <ul class="mt-3 space-y-2 text-sm text-cream/70">
                        <li><a href="{{ route('landing') }}" class="hover:text-turmeric">Beranda</a></li>
                        <li><a href="#menu" class="hover:text-turmeric">Menu pilihan</a></li>
                        <li><a href="#tentang" class="hover:text-turmeric">Dapur kami</a></li>
                        <li><a href="#testimoni" class="hover:text-turmeric">Testimoni</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-[10px] font-semibold uppercase tracking-[0.2em] text-cream/40">Kontak</h3>
                    <ul class="mt-3 space-y-2 text-sm text-cream/70">
                        <li><a href="https://wa.me/6285694595270" class="hover:text-turmeric">0856-9459-5270</a></li>
                        <li><a href="mailto:hello@rasanusantara.test" class="hover:text-turmeric">hello@rasanusantara.test</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-[10px] font-semibold uppercase tracking-[0.2em] text-cream/40">Lokasi</h3>
                    <p class="mt-3 text-sm leading-relaxed text-cream/70">
                        Bogor, Jawa Barat<br>
                        Melayani pernikahan, acara kantor, dan keluarga.
                    </p>
                </div>
            </div>

            <div class="mt-10 flex flex-wrap items-center justify-between gap-3 border-t border-cream/10 pt-5 text-[11px] text-cream/35">
                <span>&copy; {{ date('Y') }} Rasa Nusantara. Seluruh hak cipta dilindungi.</span>
                <span>Dimasak di Bogor.</span>
            </div>
        </div>
    </footer>

@endsection
