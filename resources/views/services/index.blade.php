@extends('layouts.app')

@section('title', 'Explore Jasa - SkillHub')

@section('content')
<style>
    /* --- Explore Container --- */
.explore-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px 60px;
}

/* --- Explore Header & Search Bar --- */
.explore-header {
    background-color: #ffffff;
    border-radius: 16px;
    padding: 40px 20px;
    margin-bottom: 40px;
    margin-top: 24px;
    text-align: center;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid #f3f4f6;
}

.explore-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 12px;
}

.explore-header p {
    color: #6b7280;
    margin-bottom: 24px;
    font-size: 1.05rem;
}

/* --- Form Pencarian --- */
.search-form {
    display: flex;
    max-width: 600px;
    margin: 0 auto;
    gap: 12px;
}

.search-form input[type="text"] {
    flex-grow: 1;
    padding: 12px 20px;
    border: 1.5px solid #d1d5db;
    border-radius: 8px;
    font-size: 1rem;
    outline: none;
    transition: all 0.2s;
}

.search-form input[type="text"]:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
}

.search-form .btn-primary {
    background-color: #4f46e5;
    color: white;
    padding: 12px 32px;
}

/* --- Pagination (Opsional) --- */
.pagination-wrapper {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}

/* Jika kamu menggunakan Tailwind/Bootstrap bawaan pagination Laravel, 
   kamu bisa menyesuaikan warnanya di sini jika perlu */

/* --- Catatan Tambahan --- */
/* Class seperti .services-grid, .service-card, .btn, dan .empty-state 
   sudah ada di CSS Home sebelumnya, jadi kamu tidak perlu menulis ulang 
   jika berada dalam file style.css yang sama! */
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