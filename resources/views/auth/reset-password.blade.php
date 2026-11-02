@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<form method="POST" action="{{ route('password.store') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">

    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="password">Password Baru</label>
    <input id="password" type="password" name="password" required autocomplete="new-password">

    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="password_confirmation">Konfirmasi Password Baru</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">

    <button type="submit">Simpan Password</button>

    <div class="switch-link">
        <a href="{{ route('login') }}">Kembali ke halaman masuk</a>
    </div>
</form>
@endsection
