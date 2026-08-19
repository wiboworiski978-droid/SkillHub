@extends('layouts.app')

@section('title', 'Home - SkillHub')

@section('content')

<div class="hero">

    <h1>
        Selamat datang, {{ session('username') }}!
    </h1>

    <p>
        Selamat datang di SkillHub.
        Temukan jasa dan skill yang kamu butuhkan.
    </p>

    <div class="hero-buttons">

        <a href="#" class="btn">
            Jelajahi Jasa
        </a>

        <a href="#" class="btn secondary">
            Profile
        </a>

    </div>

</div>

@endsection