@extends('layouts.app')

@section('title', 'Home - SkillHub')

@section('content')
<style>
    /* =========================================
    STYLE HALAMAN HOME (BERANDA)
    ========================================= */

.home-container {
    max-width: 1100px;
    margin: 0 auto 80px auto;
    padding: 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- 1. Hero Section --- */
.hero-section {
    background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%);
    border-radius: 24px;
    padding: 80px 20px;
    text-align: center;
    color: #ffffff;
    box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
    margin-bottom: 60px;
}

.hero-content {
    max-width: 650px;
    margin: 0 auto;
}

.hero-content h1 {
    font-size: 2.8rem;
    font-weight: 800;
    margin: 0 0 16px 0;
    letter-spacing: -0.02em;
    line-height: 1.2;
}

.hero-content p {
    font-size: 1.15rem;
    color: #e0e7ff;
    margin: 0 0 32px 0;
    line-height: 1.6;
}

/* Tombol Explore Jasa diubah menjadi warna Biru Profesional */
.hero-content .btn-explore-blue {
    background-color: #2563eb;
    color: #ffffff;
    padding: 12px 28px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    border: none;
}

.hero-content .btn-explore-blue:hover {
    background-color: #1d4ed8;
    transform: translateY(-2px);
}

/* --- 2. Services Section (Jasa Terbaru) --- */
.services-section {
    margin-bottom: 60px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    border-bottom: 2px solid #f3f4f6;
    padding-bottom: 12px;
}

.section-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.view-all {
    font-weight: 600;
    color: #4f46e5;
    text-decoration: none;
    transition: color 0.2s;
}

.view-all:hover {
    color: #312e81;
}

/* Grid & Card (Disempurnakan) */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

.service-card {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.1);
}

.service-image-placeholder {
    height: 180px;
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    position: relative;
    border-bottom: 1px solid #e5e7eb;
    overflow: hidden;
}

/* Fallback Art jika Thumbnail Kosong */
.service-fallback-art {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    color: #0284c7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    font-weight: 800;
    letter-spacing: 0.05em;
}

/* Gambar Thumbnail */
.mysrv-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.service-card:hover .mysrv-thumbnail {
    transform: scale(1.05);
}

/* Info Jasa */
.service-info {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.service-info h3 {
    font-size: 1.15rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 8px 0;
    line-height: 1.4;
}

.service-desc {
    color: #6b7280;
    font-size: 0.95rem;
    line-height: 1.5;
    margin: 0 0 20px 0;
    flex-grow: 1;
}

/* Meta Info (Pemilik & Harga) */
.service-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-top: 16px;
    border-top: 1px solid #f3f4f6;
}

.service-author {
    font-size: 0.85rem;
    color: #4b5563;
    font-weight: 500;
}

.service-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #10b981;
}

/* Tombol Block di Card */
.btn-block {
    display: block;
    width: 100%;
    text-align: center;
    box-sizing: border-box;
}

/* --- 3. Order Section (Call to Action Bawah) --- */
.order-section {
    margin-top: 20px;
}

.order-card {
    background-color: #f8fafc;
    border: 2px dashed #cbd5e1;
    border-radius: 16px;
    padding: 40px 20px;
    text-align: center;
}

.order-card h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 12px 0;
}

.order-card p {
    color: #64748b;
    margin: 0 auto 24px auto;
    max-width: 500px;
}

/* --- Responsif (Layar HP) --- */
@media (max-width: 640px) {
    .hero-section {
        padding: 50px 16px;
        border-radius: 16px;
    }

    .hero-content h1 {
        font-size: 2.2rem;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}
</style>

<div class="home-container">

    {{-- Hero Section --}}
    <section class="hero-section">
        <div class="hero-content">
            <h1>Selamat datang di SkillHub</h1>
            <p>Temukan jasa profesional dan skill terbaik yang kamu butuhkan untuk proyekmu.</p>
            {{-- Tombol Explore Jasa diubah menjadi biru (.btn-explore-blue) --}}
            <a href="{{ url('/services') }}" class="btn-explore-blue">
                Explore Jasa
            </a>
        </div>
    </section>

    {{-- Services Section --}}
    <section class="services-section">
        <div class="section-header">
            <h2>Jasa Terbaru</h2>
            <a href="{{ url('/services') }}" class="view-all">Lihat Semua &rarr;</a>
        </div>

        <div class="services-grid">
            @forelse ($services as $service)
                <div class="service-card">
                    {{-- Card Jasa yang disempurnakan (Dilengkapi fallback inisial jika thumbnail kosong) --}}
                    <div class="service-image-placeholder">
                        @if ($service->thumbnail)
                            <img
                                src="{{ asset('storage/' . $service->thumbnail) }}"
                                alt="{{ $service->title }}"
                                class="mysrv-thumbnail"
                            >
                        @else
                            <div class="service-fallback-art">
                                <span>{{ strtoupper(substr($service->title, 0, 2)) }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="service-info">
                        <h3>{{ $service->title }}</h3>
                        <p class="service-desc">
                            {{ Str::limit($service->description, 80) }}
                        </p>
                        
                        <div class="service-meta">
                            <span class="service-author">
                                👤 {{ $service->user->username ?? 'Anonim' }}
                            </span>
                            <span class="service-price">
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            </span>
                        </div>

                        <a href="{{ url('/services/' . $service->id) }}" class="btn btn-outline btn-block">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                    <p>Belum ada jasa yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Order Section (Hanya tampil jika user sudah login) --}}
    @auth
    <section class="order-section">
        <div class="order-card">
            <h2>Kelola Order Saya</h2>
            <p>Pantau status pesanan, lihat riwayat, dan kelola order yang sedang berjalan.</p>
            <a href="{{ url('/orders') }}" class="btn btn-primary">
                Lihat Order Saya
            </a>
        </div>
    </section>
    @endauth

</div>
@endsection