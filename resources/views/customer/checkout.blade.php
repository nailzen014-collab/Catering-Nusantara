@extends('layouts.app')

@section('content')

<div class="checkout-page">

    {{-- HEADER --}}
    <div class="checkout-header">
        <h1>Checkout</h1>
        <p>Pilih menu, jumlah pesanan, dan metode pembayaran.</p>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <strong>Terjadi kesalahan:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif


    <form
        action="{{ route('checkout.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf


        {{-- =========================
             MENU
        ========================== --}}

        <section class="checkout-section">

            <div class="section-heading">
                <div>
                    <h2>Pilih Menu</h2>
                    <p>Pilih makanan yang ingin kamu pesan.</p>
                </div>

                <div class="menu-count">
                    {{ $menus->count() }} Menu
                </div>
            </div>


            <div
                class="menu-grid"
                id="menuGrid"
            >

                @foreach ($menus as $index => $menu)

                    <div
                        class="menu-card menu-item"
                        style="{{ $index >= 12 ? 'display: none;' : '' }}"
                    >

                        <div class="menu-top">

                            <span class="menu-category">
                                {{ $menu->category->name }}
                            </span>

                            <h3>
                                {{ $menu->name }}
                            </h3>

                            <div class="menu-price">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </div>

                        </div>


                        <div class="quantity-box">

                            <label>
                                Jumlah
                            </label>

                            <div class="quantity-control">

                                <button
                                    type="button"
                                    class="qty-btn minus"
                                >
                                    −
                                </button>

                                <input
                                    type="number"
                                    class="qty-input"
                                    name="qty[{{ $menu->id }}]"
                                    value="{{ old('qty.' . $menu->id, 0) }}"
                                    min="0"
                                    max="99"
                                >

                                <button
                                    type="button"
                                    class="qty-btn plus"
                                >
                                    +
                                </button>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- SHOW MORE / SHOW LESS --}}

            @if ($menus->count() > 12)

                <div class="menu-actions">

                    <button
                        type="button"
                        id="showMoreBtn"
                        class="menu-action-btn"
                    >
                        <span>Show More</span>
                        <span class="action-icon">↓</span>
                    </button>

                    <button
                        type="button"
                        id="showLessBtn"
                        class="menu-action-btn secondary"
                        style="display: none;"
                    >
                        <span>Show Less</span>
                        <span class="action-icon">↑</span>
                    </button>

                </div>

            @endif

        </section>



        {{-- =========================
             ALAMAT
        ========================== --}}

        <section class="checkout-section">

            <div class="section-heading">
                <div>
                    <h2>Alamat Pengiriman</h2>
                    <p>Pesanan akan dikirim ke alamat yang tersimpan.</p>
                </div>
            </div>


            <div class="address-card">

                <div class="address-icon">
                    📍
                </div>

                <div class="address-content">
<div class="address-name">
    {{ $customer?->name ?? Auth::user()->name }}
</div>

<div class="address-phone">
    {{ $customer?->phone ?? '-' }}
</div>

          <div>
  <div>
    <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">
        Alamat Pengiriman
    </label>

    <input
        type="text"
        name="delivery_address"
        id="delivery_address"
        value="{{ old('delivery_address', $customer->address) }}"
        required
        placeholder="Masukkan alamat pengiriman"
        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    >

    @error('delivery_address')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
                    <div class="address-city">
                        {{ $customer->city->name }}
                    </div>

                </div>

            </div>

        </section>



        {{-- =========================
             PEMBAYARAN
        ========================== --}}

        <section class="checkout-section">

            <div class="section-heading">
                <div>
                    <h2>Metode Pembayaran</h2>
                    <p>Pilih metode pembayaran yang tersedia.</p>
                </div>
            </div>


            <div class="payment-list">

                @foreach ($paymentMethods as $payment)

                    @php
                        $paymentName = strtolower($payment->name);
                    @endphp

                    <label class="payment-card">

                        <input
                            type="radio"
                            name="payment_method_id"
                            value="{{ $payment->id }}"
                            data-payment="{{ $paymentName }}"
                            {{ old('payment_method_id') == $payment->id ? 'checked' : '' }}
                        >

                        <div class="payment-radio"></div>

                        <div class="payment-content">

                            <strong>
                                {{ $payment->name }}
                            </strong>

                            @if (str_contains($paymentName, 'cod'))
                                <span>
                                    Bayar ketika pesanan diterima.
                                </span>
                            @elseif (str_contains($paymentName, 'transfer'))
                                <span>
                                    Transfer melalui rekening bank.
                                </span>
                            @elseif (str_contains($paymentName, 'qris'))
                                <span>
                                    Bayar menggunakan QRIS.
                                </span>
                            @endif

                        </div>

                    </label>

                @endforeach

            </div>



            {{-- TRANSFER BANK --}}

            <div
                id="transferInfo"
                class="payment-detail"
            >

                <div class="detail-icon">
                    🏦
                </div>

                <div>

                    <h3>Transfer Bank</h3>

                    <p>
                        Silakan transfer ke rekening berikut:
                    </p>

                    <div class="bank-account">

                        <span>Bank BCA</span>

                        <strong>
                            1234567890
                        </strong>

                        <small>
                            A/N Rasa Nusantara
                        </small>

                    </div>

                </div>

            </div>



            {{-- QRIS --}}

            <div
                id="qrisInfo"
                class="payment-detail qris-detail"
            >

                <div class="detail-icon">
                    📱
                </div>

                <div>

                    <h3>Bayar dengan QRIS</h3>

                    <p>
                        Scan QRIS berikut menggunakan aplikasi pembayaran kamu.
                    </p>

                    <div class="qris-image-box">

                        <img
                            src="{{ asset('images/csan-qr-a.jpg') }}"
                            alt="QRIS Rasa Nusantara"
                        >

                    </div>

                </div>

            </div>



            {{-- BUKTI PEMBAYARAN --}}

            <div
                id="proofBox"
                class="proof-box"
            >

                <label for="paymentProof">
                    Bukti Pembayaran
                </label>

                <p>
                    Upload bukti pembayaran setelah melakukan pembayaran.
                </p>

                <input
                    type="file"
                    name="payment_proof"
                    id="paymentProof"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small>
                    JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                </small>

            </div>

        </section>



        {{-- =========================
             SUBMIT
        ========================== --}}

        <div class="checkout-submit">

            <button
                type="submit"
                class="order-button"
            >
                <span>Buat Pesanan</span>
                <span>→</span>
            </button>

        </div>

    </form>

</div>



<style>

/* =====================================================
   GLOBAL
===================================================== */

.checkout-page {
    max-width: 1140px;
    margin: 0 auto;
    padding: 38px 24px 70px;
    color: #3e2b22;
}


/* =====================================================
   HEADER
===================================================== */

.checkout-header {
    margin-bottom: 32px;
}

.checkout-header h1 {
    margin: 0 0 8px;
    font-family: Georgia, serif;
    font-size: 36px;
    font-weight: 700;
    color: #3e2b22;
}

.checkout-header p {
    margin: 0;
    color: #806d61;
    font-size: 15px;
}


/* =====================================================
   ALERT
===================================================== */

.alert-error,
.alert-success {
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 25px;
    font-size: 14px;
}

.alert-error {
    background: #fff0f0;
    border: 1px solid #edcaca;
    color: #8a3030;
}

.alert-success {
    background: #eef8f0;
    border: 1px solid #c7e3cc;
    color: #356b3d;
}

.alert-error ul {
    margin: 8px 0 0;
    padding-left: 20px;
}


/* =====================================================
   SECTION
===================================================== */

.checkout-section {
    margin-bottom: 38px;
}

.section-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 18px;
}

.section-heading h2 {
    margin: 0 0 5px;
    font-family: Georgia, serif;
    font-size: 22px;
    color: #3e2b22;
}

.section-heading p {
    margin: 0;
    font-size: 14px;
    color: #806d61;
}

.menu-count {
    padding: 7px 12px;
    border-radius: 20px;
    background: #f5e9dc;
    color: #6a4938;
    font-size: 12px;
    font-weight: 600;
}


/* =====================================================
   MENU GRID
===================================================== */

.menu-grid {
    display: grid !important;
    grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
    gap: 16px !important;
    width: 100%;
}


/* =====================================================
   MENU CARD
===================================================== */

.menu-card {
    min-width: 0;
    min-height: 205px;

    display: flex;
    flex-direction: column;
    justify-content: space-between;

    box-sizing: border-box;

    padding: 20px;

    background: #ffffff;

    border: 1px solid #eadfd5;
    border-radius: 14px;

    box-shadow: 0 2px 8px rgba(66, 43, 30, 0.04);

    transition:
        transform .2s ease,
        box-shadow .2s ease,
        border-color .2s ease;
}

.menu-card:hover {
    transform: translateY(-3px);
    border-color: #d9c3b1;
    box-shadow: 0 8px 20px rgba(66, 43, 30, 0.09);
}

.menu-category {
    display: inline-block;

    margin-bottom: 9px;

    color: #927663;

    font-size: 11px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: .6px;
}

.menu-top h3 {
    margin: 0 0 12px;

    color: #3e2b22;

    font-size: 16px;
    line-height: 1.4;
}

.menu-price {
    color: #6a402d;

    font-size: 15px;
    font-weight: 700;
}


/* =====================================================
   QUANTITY
===================================================== */

.quantity-box {
    margin-top: 20px;
}

.quantity-box label {
    display: block;

    margin-bottom: 7px;

    color: #806d61;

    font-size: 12px;
    font-weight: 600;
}

.quantity-control {
    display: flex;

    width: 100%;
    height: 40px;

    overflow: hidden;

    border: 1px solid #daccc1;
    border-radius: 8px;

    background: #fff;
}

.qty-btn {
    width: 40px;

    border: none;

    background: #f8f1ea;
    color: #5a3828;

    font-size: 20px;
    line-height: 1;

    cursor: pointer;

    transition: .15s ease;
}

.qty-btn:hover {
    background: #eee0d3;
}

.qty-input {
    flex: 1;

    min-width: 0;

    border: none;
    outline: none;

    text-align: center;

    color: #3e2b22;

    font-size: 14px;
    font-weight: 600;
}

.qty-input::-webkit-inner-spin-button,
.qty-input::-webkit-outer-spin-button {
    margin: 0;
}


/* =====================================================
   SHOW MORE / SHOW LESS
===================================================== */

.menu-actions {
    display: flex;
    justify-content: flex-end;

    margin-top: 18px;
}

.menu-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    min-width: 125px;
    height: 40px;

    padding: 0 15px;

    border: 1px solid #d7c1b0;
    border-radius: 8px;

    background: #ffffff;
    color: #5a3828;

    font-family: inherit;
    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    box-shadow: 0 2px 5px rgba(66, 43, 30, 0.04);

    transition:
        background .2s ease,
        color .2s ease,
        border-color .2s ease,
        transform .2s ease;
}

.menu-action-btn:hover {
    background: #5a3828;
    border-color: #5a3828;
    color: #ffffff;

    transform: translateY(-1px);
}

.menu-action-btn.secondary {
    background: #f8f1ea;
    color: #6a4938;
}

.menu-action-btn.secondary:hover {
    background: #eadaca;
    border-color: #d0b8a5;
    color: #4d3022;
}

.action-icon {
    font-size: 15px;
    line-height: 1;
}


/* =====================================================
   ADDRESS
===================================================== */

.address-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;

    padding: 20px;

    border: 1px solid #eadfd5;
    border-radius: 14px;

    background: #ffffff;

    box-shadow: 0 2px 8px rgba(66, 43, 30, 0.04);
}

.address-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 42px;
    height: 42px;

    flex-shrink: 0;

    border-radius: 10px;

    background: #f5e9dc;

    font-size: 20px;
}

.address-content {
    line-height: 1.6;
}

.address-name {
    font-size: 15px;
    font-weight: 700;
    color: #3e2b22;
}

.address-phone {
    margin-bottom: 7px;

    font-size: 13px;
    color: #806d61;
}

.address-text {
    font-size: 14px;
    color: #4e4038;
}

.address-city {
    font-size: 13px;
    color: #806d61;
}


/* =====================================================
   PAYMENT
===================================================== */

.payment-list {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.payment-card {
    position: relative;

    display: flex;
    align-items: center;

    gap: 12px;

    min-height: 72px;

    padding: 15px;

    box-sizing: border-box;

    border: 1px solid #e4d8cf;
    border-radius: 11px;

    background: #ffffff;

    cursor: pointer;

    transition: .2s ease;
}

.payment-card:hover {
    border-color: #cdb4a1;
    background: #fffcf9;
}

.payment-card input {
    position: absolute;
    opacity: 0;
}

.payment-radio {
    width: 18px;
    height: 18px;

    flex-shrink: 0;

    border: 2px solid #c9b7a9;
    border-radius: 50%;

    position: relative;
}

.payment-card input:checked + .payment-radio {
    border-color: #5a3828;
}

.payment-card input:checked + .payment-radio::after {
    content: "";

    position: absolute;

    width: 8px;
    height: 8px;

    top: 3px;
    left: 3px;

    border-radius: 50%;

    background: #5a3828;
}

.payment-card:has(input:checked) {
    border-color: #9d7961;
    background: #fcf7f2;
}

.payment-content {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.payment-content strong {
    color: #4a3226;
    font-size: 14px;
}

.payment-content span {
    color: #8a776b;
    font-size: 11px;
}


/* =====================================================
   PAYMENT DETAIL
===================================================== */

.payment-detail {
    display: none;
    align-items: flex-start;
    gap: 14px;

    margin-top: 15px;
    padding: 18px;

    border: 1px solid #e7d8cc;
    border-radius: 12px;

    background: #faf5ef;
}

.detail-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 40px;
    height: 40px;

    flex-shrink: 0;

    border-radius: 9px;

    background: #eee0d3;

    font-size: 18px;
}

.payment-detail h3 {
    margin: 0 0 5px;

    font-size: 15px;
    color: #4a3226;
}

.payment-detail p {
    margin: 0 0 12px;

    color: #806d61;
    font-size: 13px;
}

.bank-account {
    display: flex;
    flex-direction: column;
    gap: 2px;

    padding: 12px 15px;

    border-radius: 8px;

    background: #ffffff;
}

.bank-account span {
    color: #806d61;
    font-size: 12px;
}

.bank-account strong {
    color: #4a3226;
    font-size: 17px;
    letter-spacing: 1px;
}

.bank-account small {
    color: #806d61;
}


/* =====================================================
   QRIS
===================================================== */

.qris-image-box {
    display: inline-flex;

    padding: 12px;

    background: #ffffff;

    border: 1px solid #e1d4c9;
    border-radius: 10px;
}

.qris-image-box img {
    display: block;

    width: 220px;
    max-width: 100%;
    height: auto;
}


/* =====================================================
   PAYMENT PROOF
===================================================== */

.proof-box {
    display: none;

    margin-top: 15px;
    padding: 18px;

    border: 1px dashed #cbb6a5;
    border-radius: 12px;

    background: #fffaf5;
}

.proof-box label {
    display: block;

    margin-bottom: 5px;

    color: #4a3226;

    font-size: 14px;
    font-weight: 700;
}

.proof-box p {
    margin: 0 0 12px;

    color: #806d61;
    font-size: 12px;
}

.proof-box input {
    width: 100%;

    box-sizing: border-box;

    padding: 10px;

    border: 1px solid #d8c9bd;
    border-radius: 8px;

    background: #ffffff;

    font-family: inherit;
    font-size: 13px;
}

.proof-box small {
    display: block;

    margin-top: 7px;

    color: #958176;
    font-size: 11px;
}


/* =====================================================
   SUBMIT
===================================================== */

.checkout-submit {
    display: flex;
    justify-content: flex-end;

    padding-top: 5px;

    border-top: 1px solid #e5d8ce;
}

.order-button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 18px;

    min-width: 190px;
    height: 48px;

    padding: 0 22px;

    border: none;
    border-radius: 10px;

    background: #5a3828;
    color: #ffffff;

    font-family: inherit;
    font-size: 14px;
    font-weight: 700;

    cursor: pointer;

    transition: .2s ease;
}

.order-button:hover {
    background: #43291e;
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(66, 43, 30, 0.15);
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 900px) {

    .menu-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }

    .payment-list {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 600px) {

    .checkout-page {
        padding: 25px 16px 50px;
    }

    .checkout-header h1 {
        font-size: 30px;
    }

    .menu-grid {
        grid-template-columns: 1fr !important;
    }

    .section-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .menu-actions {
        justify-content: stretch;
    }

    .menu-action-btn {
        width: 100%;
    }

    .address-card {
        padding: 16px;
    }

    .checkout-submit {
        justify-content: stretch;
    }

    .order-button {
        width: 100%;
    }

}

</style>



<script>

/* =====================================================
   SHOW MORE / SHOW LESS
===================================================== */

const showMoreBtn = document.getElementById('showMoreBtn');
const showLessBtn = document.getElementById('showLessBtn');

const menuItems = document.querySelectorAll('.menu-item');

let visibleCount = 12;
const increment = 12;


showMoreBtn?.addEventListener('click', function () {

    const nextCount = Math.min(
        visibleCount + increment,
        menuItems.length
    );

    for (let i = visibleCount; i < nextCount; i++) {

        if (menuItems[i]) {
            menuItems[i].style.display = 'flex';
        }

    }

    visibleCount = nextCount;

    showLessBtn.style.display = 'inline-flex';

    if (visibleCount >= menuItems.length) {
        showMoreBtn.style.display = 'none';
    }

});


showLessBtn?.addEventListener('click', function () {

    for (let i = 12; i < menuItems.length; i++) {

        if (menuItems[i]) {
            menuItems[i].style.display = 'none';
        }

    }

    visibleCount = 12;

    showMoreBtn.style.display = 'inline-flex';
    showLessBtn.style.display = 'none';

    document
        .querySelector('.checkout-section')
        ?.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

});


/* =====================================================
   QUANTITY BUTTON
===================================================== */

document.querySelectorAll('.menu-card').forEach(card => {

    const minus = card.querySelector('.minus');
    const plus = card.querySelector('.plus');
    const input = card.querySelector('.qty-input');


    minus?.addEventListener('click', function () {

        let value = parseInt(input.value) || 0;

        if (value > 0) {
            value--;
        }

        input.value = value;

    });


    plus?.addEventListener('click', function () {

        let value = parseInt(input.value) || 0;

        if (value < 99) {
            value++;
        }

        input.value = value;

    });

});


/* =====================================================
   PAYMENT
===================================================== */

const paymentRadios = document.querySelectorAll(
    'input[name="payment_method_id"]'
);

const transferInfo = document.getElementById('transferInfo');
const qrisInfo = document.getElementById('qrisInfo');
const proofBox = document.getElementById('proofBox');
const paymentProof = document.getElementById('paymentProof');


function updatePayment() {

    transferInfo.style.display = 'none';
    qrisInfo.style.display = 'none';
    proofBox.style.display = 'none';

    paymentProof.required = false;


    const selected = document.querySelector(
        'input[name="payment_method_id"]:checked'
    );


    if (!selected) {
        return;
    }


    const type = selected.dataset.payment;


    if (type.includes('transfer')) {

        transferInfo.style.display = 'flex';

        proofBox.style.display = 'block';

        paymentProof.required = true;

    }


    if (type.includes('qris')) {

        qrisInfo.style.display = 'flex';

        proofBox.style.display = 'block';

        paymentProof.required = true;

    }

}


paymentRadios.forEach(radio => {

    radio.addEventListener(
        'change',
        updatePayment
    );

});


updatePayment();

</script>

@endsection