@extends('layouts.guest')

@section('title', 'Verifikasi Email')

@section('content')
<p style="font-size:0.85rem; color:#8A7458; margin-bottom:20px;">
    Terima kasih telah mendaftar. Sebelum memulai, verifikasi alamat email Anda melalui tautan yang kami kirimkan.
    Jika tidak menerima email, kami dapat mengirim ulang.
</p>

@if (session('status') == 'verification-link-sent')
    <div class="status-msg">
        Tautan verifikasi baru telah dikirim ke alamat email Anda.
    </div>
@endif

<div style="display:flex; flex-direction:column; gap:12px;">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Kirim Ulang Email Verifikasi</button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" style="background:#8A7458;">Keluar</button>
    </form>
</div>
@endsection
