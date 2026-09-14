@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror

    <label style="display:flex; align-items:center; gap:6px; font-weight:400;">
        <input type="checkbox" name="remember" style="width:auto; margin:0;">
        Ingat saya
    </label>

    <button type="submit" style="margin-top:8px;">Login</button>

    <div class="switch-link">
        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </div>
</form>
@endsection