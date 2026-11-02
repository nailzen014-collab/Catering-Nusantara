@extends('layouts.guest')

@section('title', 'Konfirmasi Password')

@section('content')
<p style="font-size:0.85rem; color:#8A7458; margin-bottom:20px;">
    Ini adalah area aman. Silakan konfirmasi password Anda sebelum melanjutkan.
</p>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required autocomplete="current-password">

    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit">Konfirmasi</button>
</form>
@endsection
