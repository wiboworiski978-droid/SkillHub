@extends('layouts.app')

@section('title', $service->title . ' - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE HALAMAN DETAIL JASA (SHOW)
   ========================================= */

/* --- Container Utama --- */
.detail-container {
    max-width: 1100px;
    margin: 40px auto 80px auto;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- Navigasi Kembali --- */
.back-navigation {
    margin-bottom: 24px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    color: #6b7280;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 500;
    transition: color 0.2s ease;
}

.back-link:hover {
    color: #4f46e5;
}

/* --- Layout 2 Kolom --- */
.detail-layout {
    display: grid;
    grid-template-columns: 1fr 360px; /* Kiri flexibel, Kanan fixed 360px */
    gap: 40px;
    align-items: start; /* Penting agar sidebar tidak memanjang ke bawah otomatis */
}

/* =========================================
   BAGIAN KIRI (KONTEN UTAMA)
   ========================================= */
.detail-main {
    display: flex;
    flex-direction: column;
}

/* --- Header Detail (Judul & Badges) --- */
.detail-header h1 {
    font-size: 2.25rem;
    font-weight: 800;
    color: #111827;
    margin: 0 0 16px 0;
    line-height: 1.3;
}

.detail-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
}

.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}

.badge-category { background-color: #e0e7ff; color: #4338ca; }
.badge-active { background-color: #d1fae5; color: #047857; }
.badge-inactive { background-color: #f3f4f6; color: #6b7280; }

/* --- Gambar / Thumbnail Jasa --- */
.detail-image {
    width: 100%;
    aspect-ratio: 16 / 9; /* Proporsi gambar Widescreen otomatis */
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 32px;
    border: 1px solid #e5e7eb;
}

.service-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* --- Deskripsi Jasa --- */
.detail-description {
    color: #374151;
    font-size: 1.05rem;
    line-height: 1.8;
}

.detail-description h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 16px 0;
    padding-bottom: 12px;
    border-bottom: 2px solid #f3f4f6;
}

.detail-description p {
    margin: 0;
}


/* =========================================
   BAGIAN KANAN (SIDEBAR & CARD AKSI)
   ========================================= */
.detail-sidebar {
    position: sticky;
    top: 100px; /* Menempel di layar saat di-scroll ke bawah */
}

.action-card {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
}

/* --- Area Harga --- */
.price-section {
    text-align: center;
}

.price-label {
    display: block;
    color: #6b7280;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 8px;
}

.price-amount {
    font-size: 2rem;
    font-weight: 800;
    color: #10b981; /* Warna hijau menonjol */
    margin: 0;
}

/* --- Garis Putus-putus --- */
.card-divider {
    border: 0;
    border-top: 2px dashed #e5e7eb;
    margin: 24px 0;
}

/* --- Meta Info (Estimasi & Pemilik) --- */
.service-meta-list {
    list-style: none;
    padding: 0;
    margin: 0 0 32px 0;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.service-meta-list li {
    display: flex;
    align-items: center;
    gap: 16px;
}

.meta-icon {
    font-size: 1.5rem;
    background-color: #f9fafb;
    padding: 12px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.meta-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.meta-info strong {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
}

.meta-info span {
    font-size: 1rem;
    color: #111827;
    font-weight: 600;
}

/* --- Tombol Aksi Pembelian --- */
.action-buttons .btn-block {
    width: 100%;
    display: block;
    text-align: center;
    padding: 14px 24px;
    font-size: 1.05rem;
    border-radius: 12px;
    box-sizing: border-box;
}

.btn-disabled {
    background-color: #f3f4f6;
    color: #9ca3af;
    cursor: not-allowed;
    border: 1px solid #e5e7eb;
    font-weight: 600;
}


/* =========================================
   RESPONSIF (UNTUK LAYAR HP & TABLET)
   ========================================= */
@media (max-width: 850px) {
    .detail-layout {
        grid-template-columns: 1fr; /* Berubah menjadi 1 kolom bersusun */
        gap: 32px;
    }

    .detail-sidebar {
        position: static; /* Menonaktifkan efek sticky di HP */
        order: -1; /* Trik: Membawa card harga ke atas sebelum deskripsi saat di HP */
    }

    .detail-header h1 {
        font-size: 1.75rem;
    }
}
</style>
<div class="detail-container">

    {{-- Navigasi Kembali --}}
    <div class="back-navigation">
        <a href="{{ url('/services') }}" class="back-link">
            &larr; Kembali ke Explore
        </a>
    </div>

    <div class="detail-layout">
        
        {{-- Kolom Kiri: Informasi Utama --}}
        <div class="detail-main">
            <div class="detail-header">
                <h1>{{ $service->title }}</h1>
                <div class="detail-badges">
                    <span class="badge badge-category">
                        {{ $service->category->name ?? 'Umum' }}
                    </span>
                    @if ($service->status === 'active')
                        <span class="badge badge-active">Tersedia</span>
                    @else
                        <span class="badge badge-inactive">Tidak Tersedia</span>
                    @endif
                </div>
            </div>

            {{-- Placeholder untuk Gambar/Thumbnail Jasa --}}
            <div class="detail-image">
                @if ($service->thumbnail)
                <img
                    src="{{ asset('storage/' . $service->thumbnail) }}"
                    alt="{{ $service->title }}"
                    class="service-thumbnail"
                >
                @endif
            </div>

            <div class="detail-description">
                <h2>Deskripsi Jasa</h2>
                {{-- Menggunakan nl2br agar enter/paragraf dari database terbaca --}}
                <p>{!! nl2br(e($service->description)) !!}</p>
            </div>
        </div>

        {{-- Kolom Kanan: Card Aksi & Ringkasan --}}
        <div class="detail-sidebar">
            <div class="action-card">
                <div class="price-section">
                    <span class="price-label">Harga Layanan</span>
                    <h2 class="price-amount">
                        Rp {{ number_format($service->price, 0, ',', '.') }}
                    </h2>
                </div>

                <hr class="card-divider">

                <ul class="service-meta-list">
                    <li>
                        <span class="meta-icon">⏱️</span>
                        <div class="meta-info">
                            <strong>Estimasi Pengerjaan</strong>
                            <span>{{ $service->estimated_days }} hari</span>
                        </div>
                    </li>
                    <li>
                        <span class="meta-icon">👤</span>
                        <div class="meta-info">
                            <strong>Pemilik Jasa</strong>
                            <span>{{ $service->user->username ?? 'Anonim' }}</span>
                        </div>
                    </li>
                </ul>

                <div class="action-buttons">
                    @if ($service->status === 'active')
                        <a href="{{ url('/services/' . $service->id . '/order') }}" class="btn btn-primary btn-block">
                            Pesan Jasa Sekarang
                        </a>
                    @else
                        <button class="btn btn-disabled btn-block" disabled>
                            Jasa Sedang Ditutup
                        </button>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection