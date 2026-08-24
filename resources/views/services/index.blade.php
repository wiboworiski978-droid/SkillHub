@extends('layouts.app')

@section('title', 'Explore Jasa - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE HALAMAN EXPLORE JASA
   ========================================= */

/* --- Container Utama --- */
.explore-container {
    max-width: 1100px;
    margin: 0 auto 80px auto;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- Header & Search Bar --- */
.explore-header {
    background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%);
    padding: 60px 20px;
    text-align: center;
    color: #ffffff;
    margin-bottom: 40px;
    border-radius: 0 0 24px 24px; /* Lengkungan manis di bawah */
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.header-content {
    max-width: 600px;
    margin: 0 auto;
}

.explore-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 12px 0;
    letter-spacing: -0.02em;
}

.explore-header p {
    font-size: 1.1rem;
    color: #e0e7ff;
    margin: 0 0 32px 0;
}

/* Form Pencarian */
.search-form {
    display: flex;
    gap: 8px;
    background-color: #ffffff;
    padding: 8px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.search-form input[type="text"] {
    flex-grow: 1;
    border: none;
    padding: 12px 16px;
    font-size: 1rem;
    border-radius: 8px;
    outline: none;
    background-color: transparent;
    color: #111827;
}

.search-form input[type="text"]::placeholder {
    color: #9ca3af;
}

.search-form .btn {
    padding: 12px 24px;
    white-space: nowrap;
}

/* --- Explore Body & Grid --- */
.explore-body {
    padding: 0 20px;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

/* --- Service Card --- */
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

/* Area Gambar Card */
.service-image-placeholder {
    height: 180px;
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    position: relative;
    border-bottom: 1px solid #e5e7eb;
}

/* Badge Kategori */
.category-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    background-color: rgba(17, 24, 39, 0.8);
    color: #ffffff;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    backdrop-filter: blur(4px);
}

/* Konten Text Card */
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

.service-description {
    color: #6b7280;
    font-size: 0.95rem;
    line-height: 1.5;
    margin: 0 0 20px 0;
    flex-grow: 1;
}

/* Harga */
.service-meta {
    margin-bottom: 16px;
    padding-top: 16px;
    border-top: 1px solid #f3f4f6;
}

.service-price {
    font-size: 1.2rem;
    font-weight: 700;
    color: #10b981; /* Warna Hijau Emerald */
    display: block;
}

/* Tombol Block (Penuhi Lebar) */
.btn-block {
    display: block;
    width: 100%;
    text-align: center;
    box-sizing: border-box;
}

/* --- Empty State --- */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background-color: #f9fafb;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    color: #6b7280;
    font-size: 1.05rem;
}

/* --- Pagination (Opsional) --- */
.pagination-wrapper {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}

/* --- Responsif (HP) --- */
@media (max-width: 640px) {
    .explore-header {
        padding: 40px 16px;
        border-radius: 0 0 16px 16px;
    }
    
    .explore-header h1 {
        font-size: 2rem;
    }

    .search-form {
        flex-direction: column;
        background-color: transparent;
        box-shadow: none;
        padding: 0;
    }

    .search-form input[type="text"] {
        background-color: #ffffff;
    }
    
    .search-form .btn {
        width: 100%;
    }
}
</style>
<div class="explore-container">

    {{-- Header & Search Bar --}}
    <div class="explore-header">
        <div class="header-content">
            <h1>Explore Jasa</h1>
            <p>Temukan talenta dan jasa profesional yang sesuai dengan kebutuhanmu.</p>
            
            {{-- Form Pencarian (Opsional tapi sangat disarankan untuk UX) --}}
            <form action="{{ url('/services') }}" method="GET" class="search-form">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari jasa (misal: Pembuatan Website)..." 
                    value="{{ request('search') }}"
                >
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
    </div>

    {{-- Daftar Jasa --}}
    <div class="explore-body">
        <div class="services-grid">
            {{-- Menggunakan @forelse untuk menangani kondisi jika data kosong --}}
            @forelse($services as $service)
                <div class="service-card">
                    
                    {{-- Placeholder Gambar dengan Badge Kategori --}}
                    <div class="service-image-placeholder">
                        {{-- Adaptif: Mengambil relasi category->name (seperti di Home) atau field kategori --}}
                        <span class="category-badge">
                            {{ $service->category->name ?? $service->kategori ?? 'Umum' }}
                        </span>
                    </div>

                    <div class="service-info">
                        {{-- Adaptif: Menggunakan title atau nama_jasa --}}
                        <h3>{{ $service->title ?? $service->nama_jasa ?? 'Nama Jasa Tidak Tersedia' }}</h3>

                        <p class="service-description">
                            {{ Str::limit($service->description ?? $service->deskripsi ?? 'Tidak ada deskripsi.', 100) }}
                        </p>

                        <div class="service-meta">
                            <span class="service-price">
                                Rp {{ number_format($service->price ?? $service->harga ?? 0, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Tombol Lihat Detail --}}
                        <a href="{{ url('/services/' . $service->id) }}" class="btn btn-outline btn-block">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                {{-- Tampilan jika tabel kosong atau hasil pencarian tidak ditemukan --}}
                <div class="empty-state">
                    <p>Maaf, belum ada jasa yang tersedia atau sesuai dengan pencarianmu.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination (Akan muncul jika kamu menggunakan ->paginate() di Controller) --}}
        @if(method_exists($services, 'links'))
            <div class="pagination-wrapper">
                {{ $services->links() }}
            </div>
        @endif
    </div>

</div>
@endsection