@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">

    {{-- HEADER --}}
    <div class="mx-auto max-w-7xl">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">
                    ADMIN DASHBOARD
                </p>

                <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">
                    Pesanan Masuk
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola pesanan pelanggan dan pantau status pengiriman.
                </p>
            </div>

            <div class="rounded-2xl bg-white px-3 py-3 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Total Pesanan
                </p>
                <p class="mt-1 text-2xl font-bold text-slate-900">
                    {{ $orders->total() }}
                </p>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            {{-- CARD HEADER --}}
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            Daftar Pesanan
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Informasi pelanggan, menu, pembayaran, dan status.
                        </p>
                    </div>
                </div>
            </div>

            {{-- DESKTOP TABLE --}}
            <div class="overflow-x-auto">
  <table class="w-full min-w-[900px] text-left text-xs">
        <thead>
            <tr class="border-b border-slate-200 bg-slate-50">
                <th class="px-3 py-4 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Order
                </th>

                <th class="px-3 py-4 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Customer
                </th>

                <th class="px-3 py-4 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Pesanan
                </th>

                <th class="px-3 py-4 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Pembayaran
                </th>

                <th class="px-3 py-4 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Kurir
                </th>

                <th class="px-3 py-4 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Status
                </th>

                <th class="px-3 py-4 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Aksi
                </th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-100 bg-white">

            @forelse ($orders as $order)

                @php
                    $status = match ($order->status) {
                        'pending' => [
                            'label' => 'Menunggu',
                            'class' => 'bg-amber-50 text-amber-700 border-amber-200'
                        ],
                        'waiting_verification' => [
                            'label' => 'Verifikasi',
                            'class' => 'bg-purple-50 text-purple-700 border-purple-200'
                        ],
                        'processing' => [
                            'label' => 'Diproses',
                            'class' => 'bg-blue-50 text-blue-700 border-blue-200'
                        ],
                        'delivered' => [
                            'label' => 'Dikirim',
                            'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200'
                        ],
                        'completed' => [
                            'label' => 'Selesai',
                            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'
                        ],
                        'cancelled' => [
                            'label' => 'Dibatalkan',
                            'class' => 'bg-red-50 text-red-700 border-red-200'
                        ],
                        default => [
                            'label' => ucfirst($order->status),
                            'class' => 'bg-slate-50 text-slate-700 border-slate-200'
                        ],
                    };
                @endphp

                <tr class="transition hover:bg-slate-50">

                    {{-- ORDER --}}
                    <td class="px-3 py-5 align-top">
                        <div class="font-bold text-slate-900">
                            #{{ $order->id }}
                        </div>

                        <div class="mt-1 text-xs text-slate-400">
                            {{ $order->created_at?->format('d M Y') }}
                        </div>
                    </td>


                    {{-- CUSTOMER --}}
                    <td class="max-w-[210px] px-3 py-5 align-top">

                        <div class="font-semibold text-slate-800">
                            {{ $order->customer->name ?? '-' }}
                        </div>

                        <div class="mt-1 text-xs text-slate-500">
                            {{ $order->customer->city->name ?? '-' }}
                        </div>

                        <div
                            class="mt-2 truncate text-xs text-slate-400"
                            title="{{ $order->delivery_address }}"
                        >
                            {{ $order->delivery_address ?? '-' }}
                        </div>

                    </td>


                    {{-- ITEMS --}}
                    <td class="min-w-[260px] px-3 py-5 align-top">

                        <div class="space-y-2">

                            @foreach ($order->orderItems as $item)

                                <div class="flex items-start gap-2">

                                    <span
                                        class="mt-0.5 min-w-[34px] rounded-md bg-indigo-50 px-2 py-1 text-center text-xs font-bold text-indigo-600"
                                    >
                                        {{ $item->qty }}x
                                    </span>

                                    <div class="min-w-0">
                                        <div class="truncate text-sm font-medium text-slate-800">
                                            {{ $item->menu->name ?? '-' }}
                                        </div>

                                        <div class="text-xs text-slate-400">
                                            {{ $item->menu->category->name ?? '-' }}
                                        </div>
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </td>


                    {{-- PAYMENT --}}
                    <td class="px-3 py-5 align-top">

                        <div class="text-sm font-medium text-slate-800">
                            {{ $order->paymentMethod->name ?? '-' }}
                        </div>

                        @if ($order->payment_proof)

                            <a
                                href="{{ asset('storage/' . $order->payment_proof) }}"
                                target="_blank"
                                class="mt-2 inline-flex items-center rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100"
                            >
                                Lihat Bukti
                            </a>

                        @else

                            <span class="mt-2 inline-block text-xs text-slate-400">
                                Tanpa bukti
                            </span>

                        @endif

                    </td>


                    {{-- COURIER --}}
                    <td class="px-3 py-5 align-top">

                        <div class="text-sm font-medium text-slate-800">
                            {{ $order->courier->name ?? 'Belum ada' }}
                        </div>

                        @if ($order->courier?->phone)
                            <div class="mt-1 text-xs text-slate-400">
                                {{ $order->courier->phone }}
                            </div>
                        @endif

                    </td>


                    {{-- STATUS --}}
                    <td class="px-3 py-5 align-top">

                        <span
                            class="inline-flex whitespace-nowrap rounded-full border px-3 py-1.5 text-xs font-semibold {{ $status['class'] }}"
                        >
                            {{ $status['label'] }}
                        </span>

                    </td>


                    {{-- ACTION --}}
                    <td class="px-3 py-5 text-right align-top">

                        <form
                            action="{{ route('orders.status', $order) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PATCH')

                            <select
                                name="status"
                                onchange="this.form.submit()"
                                class="w-[135px] rounded-lg border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            >

                                <option value="pending"
                                    @selected($order->status === 'pending')>
                                    Menunggu
                                </option>

                                <option value="waiting_verification"
                                    @selected($order->status === 'waiting_verification')>
                                    Verifikasi
                                </option>

                                <option value="processing"
                                    @selected($order->status === 'processing')>
                                    Diproses
                                </option>

                                <option value="delivered"
                                    @selected($order->status === 'delivered')>
                                    Dikirim
                                </option>

                                <option value="completed"
                                    @selected($order->status === 'completed')>
                                    Selesai
                                </option>

                                <option value="cancelled"
                                    @selected($order->status === 'cancelled')>
                                    Dibatalkan
                                </option>

                            </select>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">

                        <div class="text-sm font-medium text-slate-500">
                            Belum ada pesanan.
                        </div>

                        <div class="mt-1 text-xs text-slate-400">
                            Pesanan pelanggan akan muncul di sini.
                        </div>

                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>
</div>

            {{-- MOBILE --}}
            <div class="space-y-4 p-4 md:hidden">

                @forelse ($orders as $order)

                    @php
                        $statusClasses = match ($order->status) {
                            'pending' => 'bg-amber-50 text-amber-700',
                            'waiting_verification' => 'bg-purple-50 text-purple-700',
                            'processing' => 'bg-blue-50 text-blue-700',
                            'delivered' => 'bg-indigo-50 text-indigo-700',
                            'completed' => 'bg-emerald-50 text-emerald-700',
                            'cancelled' => 'bg-red-50 text-red-700',
                            default => 'bg-slate-50 text-slate-700',
                        };
                    @endphp

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                        <div class="flex items-start justify-between gap-4">

                            <div>
                                <p class="text-lg font-bold text-slate-900">
                                    #{{ $order->id }}
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $order->customer->name ?? '-' }}
                                </p>
                            </div>

                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>

                        </div>

                        <div class="my-4 border-t border-slate-100"></div>

                        <div class="space-y-3">

                            @foreach ($order->orderItems as $item)
                                <div class="flex justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">
                                            {{ $item->menu->name ?? '-' }}
                                        </p>

                                        <p class="text-xs text-slate-400">
                                            {{ $item->menu->category->name ?? '-' }}
                                        </p>
                                    </div>

                                    <span class="text-sm font-semibold text-indigo-600">
                                        {{ $item->qty }}x
                                    </span>
                                </div>
                            @endforeach

                        </div>

                        <div class="mt-4 rounded-xl bg-slate-50 p-3">
                            <p class="text-xs font-medium text-slate-400">
                                Alamat
                            </p>

                            <p class="mt-1 text-sm text-slate-700">
                                {{ $order->delivery_address ?? '-' }}
                            </p>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3">

                            <div>
                                <p class="text-xs text-slate-400">
                                    Pembayaran
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ $order->paymentMethod->name ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">
                                    Kurir
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ $order->courier->name ?? 'Belum ada' }}
                                </p>
                            </div>

                        </div>

                        @if ($order->payment_proof)
                            <a
                                href="{{ asset('storage/' . $order->payment_proof) }}"
                                target="_blank"
                                class="mt-4 block rounded-xl bg-emerald-50 px-4 py-3 text-center text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100"
                            >
                                Lihat Bukti Pembayaran
                            </a>
                        @endif

                        <form
                            action="{{ route('orders.status', $order) }}"
                            method="POST"
                            class="mt-4"
                        >
                            @csrf
                            @method('PATCH')

                            <select
                                name="status"
                                onchange="this.form.submit()"
                                class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="pending" @selected($order->status === 'pending')>
                                    Menunggu
                                </option>

                                <option value="waiting_verification" @selected($order->status === 'waiting_verification')>
                                    Verifikasi
                                </option>

                                <option value="processing" @selected($order->status === 'processing')>
                                    Diproses
                                </option>

                                <option value="delivered" @selected($order->status === 'delivered')>
                                    Dikirim
                                </option>

                                <option value="completed" @selected($order->status === 'completed')>
                                    Selesai
                                </option>

                                <option value="cancelled" @selected($order->status === 'cancelled')>
                                    Dibatalkan
                                </option>
                            </select>
                        </form>

                    </div>

                @empty

                    <div class="py-12 text-center text-sm text-slate-500">
                        Belum ada pesanan.
                    </div>

                @endforelse

            </div>

            {{-- PAGINATION --}}
            @if ($orders->hasPages())
                <div class="border-t border-slate-100 px-6 py-4">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection