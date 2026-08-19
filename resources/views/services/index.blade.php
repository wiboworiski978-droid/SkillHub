 @extends('layouts.app')

@section('title', 'Explore Jasa - SkillHub')

@section('content')

<div class="services-container">

    <div class="services-header">
        <h1>Explore Jasa</h1>

        <p>
            Temukan jasa yang sesuai dengan kebutuhanmu.
        </p>
    </div>

    <div class="service-grid">

        {{-- Data jasa nanti ditampilkan di sini --}}

        <div class="service-card">

            <h2>Jasa Pembuatan Website</h2>

            <p class="service-description">
                Jasa pembuatan website menggunakan Laravel.
            </p>

            <p class="service-price">
                Rp500.000
            </p>

            <p>
                Kategori: Web Development
            </p>

            <a href="#" class="btn">
                Lihat Detail
            </a>

        </div>

    </div>

</div>

@endsection