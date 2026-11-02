@extends('layouts.app')

@section('title', 'Profil')

@section('header')
    <h1>Profil</h1>
@endsection

@section('content')
<div class="container" style="padding-top:32px; padding-bottom:56px; max-width:820px;">

    <div style="background:var(--card); border:1px solid var(--line); border-radius:14px; padding:24px; margin-bottom:20px;">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div style="background:var(--card); border:1px solid var(--line); border-radius:14px; padding:24px; margin-bottom:20px;">
        @include('profile.partials.update-password-form')
    </div>

    <div style="background:var(--card); border:1px solid var(--line); border-radius:14px; padding:24px;">
        @include('profile.partials.delete-user-form')
    </div>

</div>
@endsection
