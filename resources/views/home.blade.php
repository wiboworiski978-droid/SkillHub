@extends('layouts.app')

@section('title', 'Home - SkillHub')

@section('content')

<div class="home-container">

    <section class="hero">

        <h1>
            Selamat datang di SkillHub
        </h1>

        <p>
            Temukan jasa dan skill yang kamu butuhkan.
        </p>

        <a href="/services" class="btn">
            Explore Jasa
        </a>

    </section>


    <section class="services-section">

        <h2>
            Jasa Terbaru
        </h2>

        @if ($services->count() > 0)

            <div class="services-grid">

                @foreach ($services as $service)

                    <div class="service-card">

                        <h3>
                            {{ $service->title }}
                        </h3>

                        <p>
                            {{ Str::limit($service->description, 100) }}
                        </p>

                        <p>
                            <strong>
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            </strong>
                        </p>

                        <p>
                            Kategori:
                            {{ $service->category->name }}
                        </p>

                        <p>
                            Pemilik:
                            {{ $service->user->username }}
                        </p>

                        <a
                            href="/services/{{ $service->id }}"
                            class="btn"
                        >
                            Lihat Detail
                        </a>

                    </div>

                @endforeach

            </div>

        @else

            <p>
                Belum ada jasa yang tersedia.
            </p>

        @endif

    </section>


    <section class="order-section">

        <h2>
            Order Saya
        </h2>

        <p>
            Lihat dan kelola order yang kamu buat.
        </p>

        <a href="/orders" class="btn">
            Lihat Order Saya
        </a>

    </section>

</div>

@endsection