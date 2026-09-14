# Product Requirements Document (PRD)
## Sistem Katering Nusantara V2 — Advanced Nested Eager Loading

| Atribut | Keterangan |
|---|---|
| Nama Proyek | Sistem Katering Nusantara V2 |
| Tipe Proyek | Tugas Praktikum / LKPD — Laravel Backend |
| Fokus Materi | Relasi Database Multi-Level, Query Optimization, N+1 Problem, Nested Eager Loading |
| Target Pengguna | Admin Katering (internal dashboard, single-role) |
| Status Dokumen | Final — v1.0 |

---

## 1. Latar Belakang

Usaha katering "Rasa Nusantara" telah berkembang dan kini beroperasi di banyak kota dengan sistem pengiriman mandiri. Admin membutuhkan **satu dashboard tabel** yang menampilkan informasi pesanan secara lengkap: identitas pelanggan beserta kotanya, kurir pengantar, metode pembayaran, serta rincian menu yang dipesan beserta kategorinya.

**Referensi Bisnis Nyata:** Konteks dan konten proyek ini diselaraskan dengan situs *Catering Nusantara* (Bogor) — [cateringnusantara.vercel.app](https://cateringnusantara.vercel.app/) — usaha katering masakan rumahan yang melayani **Nasi Box, Prasmanan, Snack Box, dan Tumpeng Mini** untuk acara pernikahan, kantor, dan keluarga, dengan pemesanan melalui WhatsApp. Referensi ini dipakai untuk dua hal:
1. **Konten & data dummy** — nama kategori menu, jenis paket, dan gaya penamaan menu pada seeder dibuat realistis mengikuti jenis layanan situs tersebut (lihat §5.1).
2. **Identitas visual dashboard** — palet warna hangat (coklat keemasan `#B0713F`) dan nuansa "masakan rumahan nusantara" dijadikan acuan gaya tampilan tabel admin (lihat §6.1).

> Catatan: Situs tersebut adalah *landing page pemasaran* (customer-facing) dan **tidak** memiliki sistem admin/database pesanan yang bisa diintegrasikan langsung. Sistem katering pada proyek ini (7 tabel, order, eager loading) dibangun terpisah sebagai backend admin — situs tersebut hanya dijadikan referensi konten & desain, bukan sumber integrasi teknis.

Karena data pesanan melibatkan relasi hingga **3 tingkat kedalaman** (order → customer → city, dan order → order_items → menu → category), risiko utama proyek ini adalah **N+1 Query Problem** akibat Lazy Loading yang tidak terkontrol, yang berpotensi membuat server down saat data berskala besar.

## 2. Tujuan Produk

1. Membangun skema database relasional kompleks (7 tabel) yang merepresentasikan alur bisnis katering secara realistis.
2. Menyediakan dashboard admin yang menampilkan data pesanan secara lengkap dan akurat dalam satu tabel.
3. Mendemonstrasikan secara terukur dampak buruk Lazy Loading (N+1 Query) dibanding solusi **Nested Eager Loading**.
4. Menegakkan praktik query yang aman melalui `Model::preventLazyLoading()`.

## 3. Ruang Lingkup (Scope)

**Termasuk dalam scope:**
- Migration & Model untuk 7 tabel beserta relasinya.
- Factory & Seeder dengan volume data sesuai ketentuan LKPD.
- Satu halaman dashboard admin (read-only, tanpa CRUD, tanpa autentikasi) menampilkan tabel pesanan.
- Implementasi & pembuktian solusi Nested Eager Loading menggunakan Laravel Debugbar.
- Dokumentasi README.md sesuai format yang ditentukan.

**Di luar scope:**
- Fitur CRUD (create/update/delete) untuk pesanan, menu, pelanggan, dll.
- Autentikasi/otorisasi admin.
- Payment gateway / integrasi pembayaran nyata.
- Tracking pengiriman real-time.
- Desain UI mendalam (styling minimal, fokus pada fungsi & optimasi query).

> ### ⚠️ Penegasan: Aplikasi Ini 100% Read-Only
> Tidak ada satupun form tambah/edit/hapus di seluruh sistem ini — baik untuk **admin** (dashboard order) maupun **customer** (landing page §12). Semua data (cities, categories, menus, customers, orders, dst.) hanya bisa masuk lewat **Seeder** (`php artisan db:seed`). Tidak ada halaman "Tambah Menu", "Edit Order", "Hapus Customer", dsb.
>
> **Alur data end-to-end proyek ini:**
> ```
> Customer (landing page)                 Admin (dashboard)
>   └─ lihat menu (read-only)                └─ lihat order (read-only)
>   └─ klik CTA → chat WA manual              └─ TIDAK bisa ubah/hapus apapun
>          │                                         ▲
>          └──────── proses order manual ────────────┘
>                (di luar sistem/database)
>
> Satu-satunya jalur data masuk ke database:
>   developer/admin → php artisan db:seed → tabel terisi
> ```
> Alasan: fokus proyek ini adalah **efisiensi query (N+1 → Eager Loading)**, bukan manajemen data (CRUD). Jika dikembangkan lebih lanjut di luar LKPD, fitur CRUD bisa ditambahkan sebagai iterasi berikutnya — tapi itu di luar cakupan dokumen ini.

## 4. Jebakan Performa (Constraint Kritis)

> Data saling terkait hingga 3 tingkat kedalaman. Memanggil relasi dengan Lazy Loading di dalam loop akan menghasilkan ratusan–ribuan query dan berisiko membuat server down. Solusi wajib: **Nested Eager Loading**.

**🚫 Lazy Loading DILARANG pada versi final.** Dashboard versi naif di Tahap 3 (§9) hanya dibuat sekali sebagai bukti pembanding (screenshot "before"), lalu **wajib** diganti total dengan Nested Eager Loading sebelum submission. Tidak ada toleransi query relasi yang dipanggil tanpa eager load di kode final — ditegakkan otomatis oleh `Model::preventLazyLoading()` yang akan melempar exception jika dilanggar.

Target performa: jumlah query pada halaman dashboard **harus di bawah 10 query**, terlepas dari jumlah order yang ditampilkan per halaman (pagination).

---

## 5. Skema Database

### 5.1 Daftar Tabel & Kolom

| Tabel | Kolom Utama | Keterangan |
|---|---|---|
| `cities` | id, name | Master data kota |
| `categories` | id, name | Kategori menu — disarankan mengikuti jenis layanan nyata: **Nasi Box, Prasmanan, Snack Box, Tumpeng Mini**, Pembuka, Utama, Penutup, Minuman, dst. (total 10 kategori) |
| `payment_methods` | id, name | Metode pembayaran |
| `couriers` | id, name, phone | Data kurir |
| `customers` | id, name, phone, city_id | Pelanggan |
| `menus` | id, name, price, category_id | Daftar menu |
| `orders` | id, customer_id, payment_method_id, courier_id, status | Transaksi utama |
| `order_items` | id, order_id, menu_id, qty, subtotal | Detail item per order |

### 5.2 Relasi Antar Model

| Model | Relasi | Ke Model | Tipe |
|---|---|---|---|
| Customer | belongsTo | City | Many-to-One |
| Menu | belongsTo | Category | Many-to-One |
| Order | belongsTo | Customer | Many-to-One |
| Order | belongsTo | PaymentMethod | Many-to-One |
| Order | belongsTo | Courier | Many-to-One |
| OrderItem | belongsTo | Order | Many-to-One |
| OrderItem | belongsTo | Menu | Many-to-One |
| Order | hasMany | OrderItem | One-to-Many (implisit, untuk query balik) |

### 5.3 Diagram Relasi (ERD Sederhana)

```
City (1) ──< (N) Customer
Category (1) ──< (N) Menu
Customer (1) ──< (N) Order
PaymentMethod (1) ──< (N) Order
Courier (1) ──< (N) Order
Order (1) ──< (N) OrderItem >── (N) 1 Menu
```

### 5.4 Kebutuhan Volume Data (Seeder)

| Entitas | Jumlah |
|---|---|
| Cities | 50 |
| Categories | 10 |
| Payment Methods | 3 |
| Couriers | 10 |
| Menus | 150 |
| Customers | 200 |
| Orders | 150 |
| Order Items | 3–5 per Order (acak, via loop di seeder) |

**Urutan eksekusi seeder wajib mengikuti dependensi FK:**
`Cities → Categories → PaymentMethods → Couriers → Customers → Menus → Orders → OrderItems`

---

## 6. Functional Requirements

| ID | Requirement | Prioritas |
|---|---|---|
| FR-01 | Sistem menyediakan migration untuk 7 tabel dengan foreign key yang benar | Must |
| FR-02 | Sistem menyediakan model Eloquent dengan relasi sesuai skema (§5.2) | Must |
| FR-03 | Sistem memiliki factory untuk seluruh entitas yang menghasilkan data dummy realistis | Must |
| FR-04 | Sistem memiliki `DatabaseSeeder` yang mengeksekusi seeder sesuai urutan dependensi | Must |
| FR-05 | Dashboard menampilkan kolom **ID Order** | Must |
| FR-06 | Dashboard menampilkan kolom **Pelanggan** berformat: `Nama Pelanggan — Nama Kota` | Must |
| FR-07 | Dashboard menampilkan kolom **Pesanan** berisi daftar (looping) `qty x Nama Menu (Kategori)` per order | Must |
| FR-08 | Dashboard menampilkan kolom **Pengiriman & Pembayaran** berformat: `Nama Kurir - Metode Bayar` | Must |
| FR-09 | Data order ditampilkan dengan pagination (15 data per halaman) | Must |
| FR-10 | Controller menggunakan Nested Eager Loading (`with(['customer.city', 'orderItems.menu.category', 'paymentMethod', 'courier'])`) | Must |
| FR-11 | `Model::preventLazyLoading()` diaktifkan di `AppServiceProvider` saat non-production — **wajib, tidak boleh dinonaktifkan/dikomentari saat submission** | Must |

## 6.1 Identitas Visual Dashboard (Referensi: cateringnusantara.vercel.app)

Tampilan dashboard admin tidak wajib meniru pixel-perfect situs pemasaran tersebut, tetapi **disarankan** memakai nuansa visual yang konsisten dengan brand:

| Elemen | Acuan |
|---|---|
| Warna aksen utama | `#B0713F` (coklat keemasan) |
| Warna latar | Netral terang (putih/krem) agar tabel data tetap mudah dibaca |
| Nuansa | Hangat, rumahan, khas nusantara — hindari tema korporat yang dingin/biru-abu generik |
| Komponen tabel | Rounded card/table dengan padding cukup, badge warna untuk kolom **status** order dan **kategori** menu |

> Jika ingin mencocokkan lebih presisi (tipografi, komponen kartu, dsb.), unggah screenshot halaman "Profil" situs tersebut agar bisa diturunkan jadi style guide yang lebih detail.

## 7. Non-Functional Requirements

| ID | Requirement |
|---|---|
| NFR-01 | Jumlah query pada halaman dashboard harus **< 10 query** (dibuktikan via Laravel Debugbar) setelah optimasi |
| NFR-02 | Aplikasi tidak boleh menghasilkan error lazy-loading-violation setelah optimasi diterapkan |
| NFR-03 | Struktur kode mengikuti konvensi standar Laravel (PSR-12, naming convention Eloquent) |
| NFR-04 | Halaman dashboard tetap dapat memuat 150 order + relasinya tanpa timeout |

## 8. Acceptance Criteria

- [ ] 7 migration berhasil dijalankan tanpa error (`php artisan migrate:fresh`).
- [ ] `php artisan db:seed` menghasilkan jumlah data sesuai §5.4 tanpa error FK constraint.
- [ ] Dashboard menampilkan seluruh kolom sesuai FR-05 s.d. FR-08 dengan data yang benar.
- [ ] Screenshot Debugbar **sebelum** optimasi menunjukkan query dalam jumlah besar (ratusan–ribuan, akibat lazy loading).
- [ ] Screenshot Debugbar **sesudah** optimasi menunjukkan query **di bawah 10**.
- [ ] `Model::preventLazyLoading()` aktif dan terbukti memicu exception jika ada relasi yang diakses tanpa eager load.
- [ ] README.md sudah diperbarui sesuai format yang ditentukan (§10).
- [ ] Link repository dan screenshot telah dikumpulkan di classroom.

---

## 9. Alur Pengerjaan (Development Flow)

Alur berikut mengikuti urutan instruksi LKPD secara ketat — setiap tahap adalah prasyarat tahap berikutnya.

```
┌─────────────────────────────────────────────────────────────────┐
│ TAHAP 0 — Setup Proyek                                          │
│ • composer create-project laravel/laravel katering-nusantara    │
│ • Konfigurasi .env & koneksi database                           │
│ • Install Laravel Debugbar (composer require barryvdh/laravel-  │
│   debugbar --dev)                                                │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ TAHAP 1 — Skema Database (Model & Migration)                    │
│ • php artisan make:model City -m  (ulangi utk 7 entitas)        │
│ • Definisikan kolom & foreign key di tiap migration             │
│ • Definisikan relasi belongsTo/hasMany di tiap Model             │
│ • php artisan migrate                                            │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ TAHAP 2 — Factory & Seeder                                      │
│ • php artisan make:factory {Model}Factory (utk 8 model)         │
│ • Definisikan atribut dummy realistis per factory                │
│ • Tulis DatabaseSeeder dgn urutan: City→Category→PaymentMethod   │
│   →Courier→Customer→Menu→Order→(loop)OrderItem                  │
│ • php artisan migrate:fresh --seed                               │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ TAHAP 3 — Dashboard Versi Naif (Sengaja Lazy Loading)            │
│ • Buat OrderController@index → Order::paginate(15)               │
│ • Buat view blade dgn foreach order → foreach orderItems         │
│   (akses relasi langsung tanpa eager load)                       │
│ • Buka Debugbar → catat/screenshot jumlah query (ratusan+)       │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ TAHAP 4 — Optimasi: Nested Eager Loading                        │
│ • Ubah query controller menjadi:                                 │
│   Order::with(['customer.city',                                  │
│                 'orderItems.menu.category',                      │
│                 'paymentMethod', 'courier'])->paginate(15)       │
│ • Aktifkan Model::preventLazyLoading(!app()->isProduction())    │
│   di AppServiceProvider::boot()                                  │
│ • Refresh dashboard → screenshot Debugbar (query < 10)           │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ TAHAP 5 — Dokumentasi & Submission                                │
│ • Update README.md sesuai format (§10)                          │
│ • Sertakan 2 screenshot bukti (before/after)                    │
│ • Push ke repository GitHub                                      │
│ • Kumpulkan link repo + screenshot di classroom                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 10. Format README.md (Wajib)

```markdown
# Sistem Katering Nusantara (Advanced Eager Loading)
**Nama:** [Nama Kalian] | **Kelas:** [Kelas]

## Deskripsi
Simulasi sistem katering dengan 7 tabel berelasi kompleks. Proyek ini
mendemonstrasikan penyelesaian ekstrim dari N+1 Query Problem menggunakan
Nested Eager Loading.

## Bukti Optimasi
- **Screenshot Lazy Loading (Error/Ratusan Query):** [Masukkan Gambar]
- **Screenshot Eager Loading (Berhasil ditekan di bawah 10 Query):** [Masukkan Gambar]
```

---

## 11. Struktur Folder Proyek (Laravel)

Struktur folder minimal yang **wajib ada/dimodifikasi** untuk proyek ini (di luar struktur default Laravel yang tidak relevan diringkas):

```
katering-nusantara/
├── app/
│   ├── Models/
│   │   ├── City.php
│   │   ├── Category.php
│   │   ├── PaymentMethod.php
│   │   ├── Courier.php
│   │   ├── Customer.php
│   │   ├── Menu.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   ├── Http/
│   │   └── Controllers/
│   │       └── OrderController.php        # index() dgn nested eager loading
│   └── Providers/
│       └── AppServiceProvider.php         # preventLazyLoading()
│
├── database/
│   ├── migrations/
│   │   ├── xxxx_xx_xx_create_cities_table.php
│   │   ├── xxxx_xx_xx_create_categories_table.php
│   │   ├── xxxx_xx_xx_create_payment_methods_table.php
│   │   ├── xxxx_xx_xx_create_couriers_table.php
│   │   ├── xxxx_xx_xx_create_customers_table.php      # FK: city_id
│   │   ├── xxxx_xx_xx_create_menus_table.php          # FK: category_id
│   │   ├── xxxx_xx_xx_create_orders_table.php         # FK: customer_id, payment_method_id, courier_id
│   │   └── xxxx_xx_xx_create_order_items_table.php    # FK: order_id, menu_id
│   ├── factories/
│   │   ├── CityFactory.php
│   │   ├── CategoryFactory.php
│   │   ├── PaymentMethodFactory.php
│   │   ├── CourierFactory.php
│   │   ├── CustomerFactory.php
│   │   ├── MenuFactory.php
│   │   ├── OrderFactory.php
│   │   └── OrderItemFactory.php
│   └── seeders/
│       └── DatabaseSeeder.php             # urutan eksekusi sesuai dependensi FK
│
├── resources/
│   └── views/
│       └── orders/
│           └── index.blade.php            # tabel dashboard admin
│
├── routes/
│   └── web.php                            # route GET /orders (dashboard)
│
├── .env
├── composer.json                          # termasuk barryvdh/laravel-debugbar (dev)
└── README.md                              # format sesuai §10
```

### 11.1 Ringkasan Jumlah Controller

| Scope | Controller | Total |
|---|---|---|
| **Wajib (LKPD)** | `OrderController` | **1 controller** |
| Opsional (§12) | + `LandingController` | 2 controller |
| Opsional (§13) | + `CustomerOrderController` + `Auth\*` (Login/Register) | 3–4 controller |

> Kesimpulan: kalau **hanya mengerjakan LKPD**, cukup **1 controller**. Controller tambahan (`LandingController`, `CustomerOrderController`, `Auth\*`) hanya muncul jika §12 dan/atau §13 (opsional/portofolio) ikut dikerjakan — dan tetap dipisah per tanggung jawab (single responsibility), tidak digabung ke `OrderController`.

---

## 12. (Opsional) Landing Page Customer — Scope Tambahan Portofolio

> ⚠️ **Bukan bagian dari tugas LKPD.** Fitur ini murni tambahan inisiatif pribadi untuk nilai plus/portofolio, tidak dinilai dalam rubrik LKPD dan tidak boleh mengorbankan waktu pengerjaan poin wajib (§1–§11). Kerjakan setelah seluruh Acceptance Criteria (§8) terpenuhi.

### 12.1 Tujuan
Menyediakan halaman publik (customer-facing) yang meniru gaya situs referensi [cateringnusantara.vercel.app](https://cateringnusantara.vercel.app/) — sebagai pelengkap dashboard admin, sekaligus etalase kemampuan full-stack (bukan cuma backend) untuk portofolio.

### 12.2 Functional Requirements Tambahan

| ID | Requirement | Prioritas |
|---|---|---|
| FR-EX-01 | Route `GET /` menampilkan landing page publik (tanpa login) | Should |
| FR-EX-02 | Section **Hero** — banner + tagline usaha katering | Should |
| FR-EX-03 | Section **Profil** — deskripsi singkat usaha (statis/hardcoded, boleh dari config) | Should |
| FR-EX-04 | Section **Menu Unggulan** — menampilkan beberapa `Menu` beserta `Category`-nya, diambil dari database (bukan statis) | Should |
| FR-EX-05 | Section **Kontak/CTA** — tombol "Pesan via WhatsApp" (link `https://wa.me/...`, nomor dummy) | Should |
| FR-EX-06 | Landing page **tidak menampilkan data pesanan/order** (privasi) — hanya data master menu yang publik | Must |

### 12.3 Struktur Teknis

| Komponen | Nama |
|---|---|
| Controller | `App\Http\Controllers\LandingController` (terpisah dari `OrderController`) |
| Method | `index()` — query `Menu::with('category')->take(6)->get()` untuk menu unggulan (tetap eager loading walau cuma 1 level, demi konsistensi coding style proyek) |
| Route | `Route::get('/', [LandingController::class, 'index'])->name('landing');` |
| View | `resources/views/landing/index.blade.php` |
| Partial (opsional) | `resources/views/landing/partials/hero.blade.php`, `profil.blade.php`, `menu.blade.php`, `cta.blade.php` |

### 12.4 Identitas Visual
Mengikuti §6.1 — warna aksen `#B0713F`, nuansa hangat/rumahan/nusantara, konsisten dengan situs referensi.

### 12.5 Update Struktur Folder

```
app/
└── Http/
    └── Controllers/
        ├── OrderController.php      # wajib (LKPD)
        └── LandingController.php    # tambahan (opsional)

resources/
└── views/
    ├── orders/
    │   └── index.blade.php          # wajib (LKPD)
    └── landing/
        ├── index.blade.php          # tambahan (opsional)
        └── partials/
            ├── hero.blade.php
            ├── profil.blade.php
            ├── menu.blade.php
            └── cta.blade.php

routes/
└── web.php   # + Route::get('/', [LandingController::class, 'index'])
```

### 12.6 Catatan Penting
- Karena ini **tambahan**, jangan sampai mengubah/merusak controller, route, atau view milik `OrderController` yang menjadi inti penilaian LKPD.
- Tetap terapkan praktik eager loading yang baik di `LandingController` meski risiko N+1-nya kecil (hanya 1 level relasi) — supaya konsisten dan jadi nilai plus di code review/portofolio.
- Boleh ditambahkan ke README.md sebagai bagian terpisah, misal: `## Fitur Tambahan (Opsional)`, agar penilai LKPD tahu ini di luar rubrik wajib.

## 13. (Opsional) Login Berbasis Role (Admin & Customer) — Scope Tambahan Portofolio

> ⚠️ **Bukan bagian dari tugas LKPD.** Sama seperti §12, ini murni tambahan portofolio. Kerjakan setelah seluruh Acceptance Criteria wajib (§8) terpenuhi.
>
> **Update scope:** awalnya direncanakan hanya customer yang login. Diputuskan **admin juga login**, dibedakan lewat kolom `role` pada tabel `users` — bukan tabel/guard terpisah.

### 13.1 Tujuan
- **Admin** login untuk mengakses dashboard order (§6) — sebelumnya dashboard bersifat publik tanpa proteksi.
- **Customer** login dan melihat **riwayat pesanannya sendiri saja** (data scoped per akun) — melengkapi landing page (§12) yang sebelumnya read-only publik tanpa login.
- Satu tabel `users`, dibedakan lewat kolom `role` (`admin` | `customer`), supaya sistem auth tetap satu jalur (memakai guard `web` bawaan Laravel), tidak perlu multi-guard yang lebih rumit.

### 13.2 Struktur Akun (Rekomendasi)

**Perubahan skema:**

| Tabel | Perubahan |
|---|---|
| `users` | **+kolom baru:** `role` — `enum('admin', 'customer')`, default `'customer'` |
| `customers` | **+kolom baru:** `user_id` (nullable, foreign key ke `users.id`, unique) — **hanya diisi untuk user ber-role `customer`** |

**Relasi tambahan:**

| Model | Relasi | Ke Model | Tipe |
|---|---|---|---|
| Customer | belongsTo (nullable) | User | Many-to-One (tapi 1 user = 1 customer) |
| User | hasOne | Customer | One-to-One (hanya terisi jika role = customer) |

> Kenapa nullable & unique: nullable karena (a) customer hasil seeder tidak otomatis punya akun, dan (b) user ber-role `admin` memang tidak pernah punya baris `customers`. Unique karena satu akun customer cuma boleh terhubung ke satu baris `customers`.
>
> Akun **admin** dibuat manual lewat seeder/tinker (bukan lewat form register publik) — lihat §13.4.

### 13.3 Functional Requirements Tambahan

| ID | Requirement | Prioritas |
|---|---|---|
| FR-EX-07 | Customer bisa **register** (buat akun baru dengan `role = customer`, otomatis membuat/mengaitkan baris `customers`) | Should |
| FR-EX-08 | Admin & Customer bisa **login/logout** lewat form yang sama, diarahkan (redirect) ke halaman berbeda sesuai `role` setelah login | Should |
| FR-EX-09 | Setelah login, **admin** diarahkan ke dashboard order (§6) — semua data order | Must |
| FR-EX-10 | Setelah login, **customer** diarahkan ke halaman **"Pesanan Saya"** — hanya order miliknya sendiri | Must |
| FR-EX-11 | Customer **tidak bisa** mengakses route dashboard admin (`/orders`), meskipun sudah login (dicegah middleware role, bukan cuma disembunyikan di navigasi) | Must |
| FR-EX-12 | Customer **tidak bisa** melihat, mengakses, atau menebak order milik customer lain (termasuk lewat URL manipulation / IDOR) | Must |
| FR-EX-13 | Query di dashboard admin maupun "Pesanan Saya" tetap wajib **Nested Eager Loading** — konsisten dengan §4 & §6 | Must |
| FR-EX-14 | Baik admin maupun customer **tidak bisa** membuat, mengubah, atau menghapus order (tetap read-only, sesuai §3) | Must |

### 13.4 Struktur Teknis

| Komponen | Nama |
|---|---|
| Migration | Tambah kolom `role` ke `users` (edit migration bawaan atau migration terpisah `add_role_to_users_table.php`) |
| Migration | `add_user_id_to_customers_table.php` |
| Seeder tambahan | `UserSeeder` — buat 1 akun admin (`role: admin`) secara eksplisit, tidak lewat form register |
| Controller | `App\Http\Controllers\Auth\*` (bawaan Laravel/Breeze untuk register-login-logout) |
| Controller | `OrderController` — **ditambah middleware** `auth` + `role:admin` (sebelumnya publik) |
| Controller | `App\Http\Controllers\CustomerOrderController` — method `index()` khusus "Pesanan Saya" |
| Middleware | `EnsureUserHasRole` (alias `role`) — cek `$request->user()->role` sebelum lanjut ke controller |
| Query kunci (admin) | `Order::with(['customer.city', 'orderItems.menu.category', 'paymentMethod', 'courier'])->paginate(15)` |
| Query kunci (customer) | `Order::where('customer_id', Auth::user()->customer->id)->with(['orderItems.menu.category', 'paymentMethod', 'courier'])->paginate(15)` |
| Route | `GET /login`, `POST /login`, `GET /register`, `POST /register`, `POST /logout` |
| Route | `GET /orders` → middleware `['auth','role:admin']` |
| Route | `GET /pesanan-saya` → middleware `['auth','role:customer']` |
| View | `resources/views/auth/login.blade.php`, `register.blade.php`, `resources/views/customer/orders/index.blade.php` |

### 13.5 Keamanan Wajib Diperhatikan
- **Otorisasi berbasis role wajib di level middleware/route**, bukan cuma disembunyikan di UI/navigasi — admin dan customer harus benar-benar diblokir dari route yang bukan miliknya (dicegat sebelum masuk controller).
- **Scoping wajib di level query** (`where('customer_id', ...)`) untuk customer — mencegah *Insecure Direct Object Reference* (IDOR), yaitu customer A mengganti ID di URL lalu melihat order customer B.
- Password di-hash otomatis lewat `Hash::make()` / bawaan Laravel — jangan pernah simpan plain text.
- Form **register publik** hanya boleh membuat akun dengan `role = customer` (hardcode di controller, jangan terima `role` dari input user) — supaya orang luar tidak bisa daftar sebagai admin sendiri.
- Registrasi customer baru sebaiknya cek dulu apakah nomor HP sudah ada di `customers` (dari data seeder) untuk dikaitkan (`user_id` diisi), atau buat baris `customers` baru jika belum ada.

### 13.6 Update Struktur Folder

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── OrderController.php          # wajib (LKPD) — kini +middleware role:admin
│   │   ├── LandingController.php        # tambahan (§12)
│   │   ├── CustomerOrderController.php  # tambahan (§13) — "Pesanan Saya"
│   │   └── Auth/                        # tambahan (§13) — login/register bawaan Laravel
│   └── Middleware/
│       └── EnsureUserHasRole.php        # tambahan (§13) — cek role admin/customer
│
database/
└── migrations/
    ├── xxxx_xx_xx_add_role_to_users_table.php          # tambahan (§13)
    └── xxxx_xx_xx_add_user_id_to_customers_table.php   # tambahan (§13)

database/
└── seeders/
    └── UserSeeder.php                   # tambahan (§13) — buat akun admin awal

resources/
└── views/
    ├── orders/index.blade.php               # wajib (LKPD)
    ├── landing/...                          # tambahan (§12)
    ├── auth/
    │   ├── login.blade.php                  # tambahan (§13)
    │   └── register.blade.php               # tambahan (§13)
    └── customer/
        └── orders/
            └── index.blade.php              # tambahan (§13) — "Pesanan Saya"
```

### 13.7 Catatan
- **Perubahan penting dari rencana awal:** dashboard admin (`OrderController`) yang sebelumnya publik tanpa login, sekarang **wajib login + role admin** jika §13 dikerjakan. Ini menggantikan asumsi lama di §3 ("Autentikasi/otorisasi admin" di luar scope) — asumsi itu **tetap berlaku untuk bagian LKPD wajib**, tapi tidak lagi berlaku begitu §13 (opsional) ditambahkan.
- Tidak menambah kemampuan CRUD apapun (§3 tetap berlaku: 100% read-only) — login berbasis role di sini hanya **mengatur siapa yang boleh melihat data apa**, bukan menambah aksi tulis/ubah/hapus.
- Akun admin **tidak dibuat lewat form register publik** (§13.5) — hanya lewat seeder/tinker, supaya tidak sembarang orang bisa daftar jadi admin.

## 14. Definition of Done (DoD)

Proyek dinyatakan **selesai (wajib/LKPD)** jika seluruh poin berikut terpenuhi:

1. Semua *Acceptance Criteria* (§8) tercentang.
2. Kode ter-push ke repository GitHub dengan riwayat commit yang jelas (minimal terpisah antara tahap naif dan tahap optimasi, agar terlihat progresnya).
3. README.md final berisi bukti before/after query count.
4. Dashboard dapat diakses dan menampilkan data tanpa error di lingkungan lokal (`php artisan serve`).

**Selesai (opsional/portofolio)** jika ditambahkan:

5. Landing page (`GET /`) tampil dengan section Hero, Profil, Menu Unggulan (dari DB), dan CTA WhatsApp sesuai §12.
6. `LandingController` terpisah dari `OrderController` dan tidak mengubah alur kerja fitur wajib.
7. Customer bisa register, login, dan mengakses "Pesanan Saya" yang hanya menampilkan order miliknya sendiri; admin login dan mengakses dashboard `/orders` dengan role terpisah (§13).
8. Query di dashboard admin maupun "Pesanan Saya" tetap Nested Eager Loading, dan scoping/otorisasi (`customer_id`, middleware `role`) diterapkan di level query & route — teruji tidak bisa diakses lintas role atau lintas akun customer lain.