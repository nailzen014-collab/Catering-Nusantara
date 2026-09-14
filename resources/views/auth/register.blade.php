@extends('layouts.guest')

@section('title', 'Daftar Akun')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <label for="name">Nama Lengkap</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @error('name')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="phone">No. HP</label>
    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required>
    @error('phone')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="city_id">Kota</label>
    <select id="city_id" name="city_id" required
            style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; margin-bottom:16px; font-size:0.95rem;">
        <option value="">-- Pilih Kota --</option>
        @foreach ($cities as $city)
            <option value="{{ $city->id }}" @selected(old('city_id') == $city->id)>{{ $city->name }}</option>
        @endforeach
    </select>
    @error('city_id')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="password_confirmation">Konfirmasi Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>

    <button type="submit">Daftar</button>

    <div class="switch-link">
        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
    </div>
</form>
@endsection