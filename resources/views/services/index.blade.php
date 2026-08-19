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

        {{-- Lakukan perulangan data dari controller di sini --}}
        @foreach($services as $service)
            
            <div class="service-card">

                {{-- Idealnya, data di bawah ini juga dibuat dinamis mengikuti isi database --}}
                <h2>{{ $service->nama_jasa ?? 'Jasa Pembuatan Website' }}</h2>

                <p class="service-description">
                    {{ $service->deskripsi ?? 'Jasa pembuatan website menggunakan Laravel.' }}
                </p>

                <p class="service-price">
                    Rp{{ number_format($service->harga ?? 500000, 0, ',', '.') }}
                </p>

                <p>
                    Kategori: {{ $service->kategori ?? 'Web Development' }}
                </p>

                {{-- Error sebelumnya terjadi di baris ini karena $service belum didefinisikan --}}
                <a href="/services/{{ $service->id }}" class="btn">
                    Lihat Detail
                </a>

            </div>

        @endforeach

    </div>

</div>

@endsection