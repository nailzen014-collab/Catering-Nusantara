@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')

<div class="container" style="padding-top:30px;padding-bottom:50px;">

    <h1 style="margin-bottom:24px;">Pesanan Saya</h1>

    @if (session('success'))
        <div style="background:#dff2df;padding:14px;margin-bottom:20px;border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($orders as $order)

        <div
            style="
                background:var(--card);
                border:1px solid var(--line);
                border-radius:14px;
                padding:22px;
                margin-bottom:18px;
            "
        >

            <div style="display:flex;justify-content:space-between;gap:20px;">
                <div>
                    <h2>Order #{{ $order->id }}</h2>
                    <div class="sub-label">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </div>
                </div>

                <strong>
                    {{ ucwords(str_replace('_', ' ', $order->status)) }}
                </strong>
            </div>

            <hr>

            <h3>Pesanan</h3>

            <ul>
                @foreach ($order->orderItems as $item)

                    <li>
                        {{ $item->qty }}x
                        {{ $item->menu->name }}

                        <span class="sub-label">
                            ({{ $item->menu->category->name }})
                        </span>

                        — Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </li>

                @endforeach
            </ul>

            <h3>Pengiriman</h3>

            <p>
                {{ $order->shipping_address }}
            </p>

            <h3>Pembayaran</h3>

            <p>
                {{ $order->paymentMethod->name }}
            </p>

            @if ($order->payment_proof)
                <a
                    href="{{ asset('storage/' . $order->payment_proof) }}"
                    target="_blank"
                >
                    Lihat Bukti Pembayaran
                </a>
            @endif

        </div>

    @empty

        <div class="empty-state">
            <strong>Belum ada pesanan</strong>

            <a href="{{ route('checkout') }}">
                Mulai pesan sekarang
            </a>
        </div>

    @endforelse

    {{ $orders->links() }}

</div>

@endsection