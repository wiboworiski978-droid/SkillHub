@extends('layouts.app')

@section('title', 'Home - SkillHub')

@section('content')
<style>
    /* --- Home Container --- */
.home-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px 40px;
}

/* --- Hero Section --- */
.hero-section {
    background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    border-radius: 16px;
    padding: 60px 20px;
    text-align: center;
    color: white;
    margin-top: 24px;
    margin-bottom: 48px;
    box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
}

.hero-content h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 16px;
}

.hero-content p {
    font-size: 1.1rem;
    color: #e0e7ff;
    margin-bottom: 32px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* --- Buttons --- */
.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
}

.btn-primary {
    background-color: #ffffff;
    color: #4f46e5;
}

.btn-primary:hover {
    background-color: #f3f4f6;
    transform: translateY(-2px);
}

.btn-outline {
    background-color: transparent;
    color: #4f46e5;
    border: 2px solid #4f46e5;
}

.btn-outline:hover {
    background-color: #4f46e5;
    color: #ffffff;
}

.btn-block {
    display: block;
    width: 100%;
}

/* --- Services Section --- */
.services-section {
    margin-bottom: 60px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.section-header h2 {
    font-size: 1.5rem;
    color: #111827;
}

.view-all {
    color: #4f46e5;
    text-decoration: none;
    font-weight: 600;
}

.view-all:hover {
    text-decoration: underline;
}

/* Grid Layout untuk Card */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

/* Service Card Design */
.service-card {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex;
    flex-direction: column;
}

.service-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.service-image-placeholder {
    height: 160px;
    background-color: #e5e7eb;
    position: relative;
    display: flex;
    align-items: flex-start;
    padding: 12px;
}

/* Label Kategori di atas gambar */
.category-badge {
    background-color: rgba(17, 24, 39, 0.7);
    color: white;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.service-info {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.service-info h3 {
    font-size: 1.15rem;
    color: #111827;
    margin-bottom: 8px;
}

.service-desc {
    color: #6b7280;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 16px;
    flex-grow: 1;
}

/* Meta Data (Author & Harga) */
.service-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-top: 16px;
    border-top: 1px solid #f3f4f6;
}

.service-author {
    font-size: 0.85rem;
    color: #4b5563;
    font-weight: 500;
}

.service-price {
    font-weight: 700;
    color: #10b981; /* Warna hijau untuk harga */
    font-size: 1rem;
}

/* --- Empty State --- */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    background-color: #f9fafb;
    border-radius: 12px;
    color: #6b7280;
    border: 1px dashed #d1d5db;
}

/* --- Order Section --- */
.order-card {
    background-color: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 40px;
    text-align: center;
}

.order-card h2 {
    color: #111827;
    margin-bottom: 8px;
}

.order-card p {
    color: #6b7280;
    margin-bottom: 24px;
}

.order-card .btn-primary {
    background-color: #4f46e5;
    color: white;
}

.order-card .btn-primary:hover {
    background-color: #4338ca;
}
</style>
<div class="home-container">

    {{-- Hero Section --}}
    <section class="hero-section">
        <div class="hero-content">
            <h1>Selamat datang di SkillHub</h1>
            <p>Temukan jasa profesional dan skill terbaik yang kamu butuhkan untuk proyekmu.</p>
            {{-- Gunakan route helper. Asumsi nama route: 'services.index' --}}
            <a href="{{ url('/services') }}" class="btn btn-primary">
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
            {{-- Menggunakan @forelse lebih rapi daripada @if + @foreach --}}
            @forelse ($services as $service)
                <div class="service-card">
                    {{-- Opsional: Tempat untuk gambar thumbnail jasa --}}
                    <div class="service-image-placeholder">
                        <span class="category-badge">{{ $service->category->name ?? 'Umum' }}</span>
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

                        {{-- Asumsi nama route: 'services.show' --}}
                        <a href="{{ url('/services/' . $service->id) }}" class="btn btn-outline btn-block">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
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