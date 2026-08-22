@extends('layouts.app')

@section('title', 'Jasa Saya - SkillHub')

@section('content')

<div class="service-detail">

    <h1>Jasa Saya</h1>

    @if (session('success'))

    <div class="success-message">
        {{ session('success') }}
    </div>

@endif

    <a href="/services/create" class="btn">
        + Buat Jasa
    </a>

    <hr>

    @if ($services->isEmpty())

        <p>
            Kamu belum memiliki jasa.
        </p>

    @else

        @foreach ($services as $service)

            <div class="service-card">

                <h2>
                    {{ $service->title }}
                </h2>

                <p>
                    {{ $service->description }}
                </p>

                <p>
                    <strong>Kategori:</strong>
                    {{ $service->category->name }}
                </p>

                <p>
                    <strong>Harga:</strong>
                    Rp {{ number_format($service->price, 0, ',', '.') }}
                </p>

                <p>
                    <strong>Estimasi:</strong>
                    {{ $service->estimated_days }} hari
                </p>

                <p>
                    <strong>Status:</strong>
                    {{ $service->status }}
                </p>

                <a
                    href="/services/{{ $service->id }}"
                    class="btn"
                >
                    Detail
                </a>

            </div>

            <hr>

        @endforeach

    @endif

</div>

@endsection