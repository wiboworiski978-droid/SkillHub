@extends('layouts.app')

@section('title', $service->title . ' - SkillHub')

@section('content')

<div class="service-detail">

    <h1>{{ $service->title }}</h1>

    <p>
        {{ $service->description }}
    </p>

    <hr>

    <p>
        <strong>Kategori:</strong>
        {{ $service->category->name }}
    </p>

    <p>
        <strong>Pemilik:</strong>
        {{ $service->user->username }}
    </p>

    <p>
        <strong>Harga:</strong>
        Rp {{ number_format($service->price, 0, ',', '.') }}
    </p>

    <p>
        <strong>Estimasi pengerjaan:</strong>
        {{ $service->estimated_days }} hari
    </p>

    <p>
        <strong>Status:</strong>
        {{ $service->status }}
    </p>

    <br>

    @if ($service->status === 'active')
        <a href="#" class="btn">
            Pesan Jasa
        </a>
    @else
        <p>Jasa ini sedang tidak tersedia.</p>
    @endif

    <a href="/services" class="btn">
        Kembali
    </a>

</div>

@endsection