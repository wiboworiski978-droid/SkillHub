@extends('layouts.app')

@section('title', 'Home - SkillHub')

@section('content')

<div class="hero">

    <h1>
        Selamat datang,  {{ Auth::user()?->username }}!
    </h1>

    <p>
        Selamat datang di SkillHub.
        Temukan jasa dan skill yang kamu butuhkan.
    </p>

    <div class="hero-buttons">

        <a href="/services" class="btn">
            Jelajahi Jasa
        </a>

        <a href="#" class="btn secondary">
            Profile
        </a>

    </div>

    <form method="POST" action="/logout">
    @csrf

    <button type="submit" class="btn">
        Logout
    </button>
</form>

</div>

@endsection