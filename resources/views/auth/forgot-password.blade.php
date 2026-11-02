@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
<p style="font-size:0.85rem; color:#8A7458; margin-bottom:20px;">
    Masukkan alamat email Anda. Kami akan mengirimkan tautan untuk mengatur ulang password.
</p>

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit">Kirim Tautan Reset</button>

    <div class="switch-link">
        <a href="{{ route('login') }}">Kembali ke halaman masuk</a>
    </div>
</form>
@endsection
