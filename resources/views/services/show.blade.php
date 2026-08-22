@extends('layouts.app')

@section('title', $service->title . ' - SkillHub')

@section('content')
<style>
    /* --- Detail Container & Layout --- */
.detail-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px 20px 60px;
}

.back-navigation {
    margin-bottom: 24px;
}

.back-link {
    color: #4b5563;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    transition: color 0.2s;
}

.back-link:hover {
    color: #4f46e5;
}

.detail-layout {
    display: grid;
    grid-template-columns: 2fr 1fr; /* Kiri lebih lebar (2 bagian), Kanan 1 bagian */
    gap: 32px;
    align-items: start; /* Penting agar sidebar bisa sticky */
}

/* --- Kolom Kiri: Detail Main --- */
.detail-header h1 {
    font-size: 2.2rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 12px;
    line-height: 1.3;
}

.detail-badges {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
}

.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.badge-category {
    background-color: #e0e7ff;
    color: #4338ca;
}

.badge-active {
    background-color: #d1fae5;
    color: #047857;
}

.badge-inactive {
    background-color: #f3f4f6;
    color: #6b7280;
}

.detail-image {
    width: 100%;
    height: 350px;
    background-color: #e5e7eb;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 1.2rem;
    margin-bottom: 32px;
}

.detail-description h2 {
    font-size: 1.5rem;
    color: #111827;
    margin-bottom: 16px;
}

.detail-description p {
    font-size: 1.05rem;
    color: #4b5563;
    line-height: 1.7;
}

/* --- Kolom Kanan: Sidebar & Action Card --- */
.detail-sidebar {
    position: sticky;
    top: 24px; /* Card akan ikut turun (menempel di atas) saat di-scroll */
}

.action-card {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 28px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
}

.price-section {
    margin-bottom: 20px;
}

.price-label {
    font-size: 0.9rem;
    color: #6b7280;
    font-weight: 500;
}

.price-amount {
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin-top: 4px;
}

.card-divider {
    border: 0;
    border-top: 1px solid #f3f4f6;
    margin: 20px 0;
}

.service-meta-list {
    list-style: none;
    padding: 0;
    margin: 0 0 28px 0;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.service-meta-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.meta-icon {
    font-size: 1.5rem;
    line-height: 1;
}

.meta-info {
    display: flex;
    flex-direction: column;
}

.meta-info strong {
    font-size: 0.9rem;
    color: #374151;
}

.meta-info span {
    font-size: 0.95rem;
    color: #6b7280;
}

/* Tombol Disabled */
.btn-disabled {
    background-color: #e5e7eb;
    color: #9ca3af;
    cursor: not-allowed;
    border: none;
}

/* --- Responsif untuk Layar Kecil (Mobile) --- */
@media (max-width: 768px) {
    .detail-layout {
        grid-template-columns: 1fr; /* Berubah jadi 1 kolom ke bawah di HP */
    }
    
    .detail-sidebar {
        position: static; /* Matikan efek sticky di HP */
        order: -1; /* (Opsional) Membawa Action Card ke atas gambar pada tampilan HP */
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
                <span>Gambar Jasa</span>
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