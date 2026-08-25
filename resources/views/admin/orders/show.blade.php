@extends('layouts.admin')

@section('title', 'Detail Order #' . $order->id . ' - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE DETAIL ORDER (ADMIN PANEL)
   ========================================= */

/* --- Layout Grid Utama --- */
.order-detail-grid {
    display: grid;
    grid-template-columns: 2fr 1fr; /* Kolom kiri lebih besar (2:1) */
    gap: 24px;
    align-items: start;
}

/* --- Card Detail --- */
.detail-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.03);
}

/* Bagian Judul Jasa */
.service-context {
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 24px;
    margin-bottom: 24px;
}

.service-context h2 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #0f172a;
    margin: 12px 0 0 0;
    line-height: 1.4;
}

.cat-badge {
    display: inline-block;
    background-color: #e0e7ff;
    color: #4338ca;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Bagian Konten/Brief */
.brief-section h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 12px 0;
}

.brief-content {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 24px;
    border-radius: 12px;
    color: #475569;
    font-size: 0.95rem;
    line-height: 1.7;
}

.notes-content {
    background-color: #fffbeb;
    border-color: #fde68a;
    color: #92400e;
}

/* --- Sidebar Panel Ringkasan --- */
.detail-sidebar .detail-card {
    padding: 24px;
}

.sidebar-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 24px 0;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 16px;
}

.summary-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.summary-label {
    font-size: 0.8rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.summary-price {
    font-size: 1.75rem;
    font-weight: 800;
    color: #10b981;
    line-height: 1;
}

.summary-value {
    font-size: 1rem;
    font-weight: 600;
}

.summary-divider {
    border: 0;
    border-top: 1px dashed #cbd5e1;
    margin: 24px 0;
}

.mt-3 { margin-top: 16px; }
.mt-4 { margin-top: 24px; }

/* --- Responsif (Tablet & HP) --- */
@media (max-width: 850px) {
    .order-detail-grid {
        grid-template-columns: 1fr; /* Berubah menjadi 1 kolom di layar kecil */
    }
    
    .detail-sidebar {
        order: -1; /* Trik agar panel harga/status pindah ke bagian atas di layar HP */
    }
}
</style>
<div class="admin-container">

    {{-- Header & Tombol Kembali --}}
    <div class="admin-page-header">
        <a href="{{ url('/admin/orders') }}" class="back-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Kelola Order
        </a>
        <h1>Detail Order <span style="color: #4f46e5;">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></h1>
        <p>Rincian lengkap transaksi, instruksi klien, dan status pengerjaan proyek.</p>
    </div>

    {{-- Layout Grid 2 Kolom --}}
    <div class="order-detail-grid">
        
        {{-- KOLOM KIRI: Detail Jasa & Brief Klien --}}
        <div class="detail-card">
            
            <div class="service-context">
                <span class="cat-badge">{{ $order->service->category->name ?? 'Kategori Umum' }}</span>
                <h2>{{ $order->service->title }}</h2>
            </div>

            <div class="brief-section">
                <h3>Kebutuhan Pembeli</h3>
                <div class="brief-content">
                    {!! nl2br(e($order->requirements)) !!}
                </div>
            </div>

            @if ($order->notes)
            <div class="brief-section mt-4">
                <h3>Catatan Tambahan</h3>
                <div class="brief-content notes-content">
                    {!! nl2br(e($order->notes)) !!}
                </div>
            </div>
            @endif

        </div>

        {{-- KOLOM KANAN: Panel Ringkasan (Meta) --}}
        <div class="detail-sidebar">
            <div class="detail-card">
                <h3 class="sidebar-title">Ringkasan Transaksi</h3>

                @php
                    $statusClass = match(strtolower($order->status)) {
                        'pending' => 'badge-warning',
                        'accepted', 'in_progress' => 'badge-info',
                        'complete', 'completed' => 'badge-success',
                        'cancelled', 'rejected' => 'badge-danger',
                        default => 'badge-secondary',
                    };
                @endphp

                <div class="summary-item">
                    <span class="summary-label">Status Order</span>
                    <div>
                        <span class="premium-badge {{ $statusClass }}">
                            <span class="badge-dot"></span>
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="summary-item mt-3">
                    <span class="summary-label">Total Harga</span>
                    <span class="summary-price">Rp {{ number_format($order->service->price ?? 0, 0, ',', '.') }}</span>
                </div>

                <div class="summary-item mt-3">
                    <span class="summary-label">Tenggat Waktu (Deadline)</span>
                    <span class="summary-value text-secondary">
                        🗓️ {{ \Carbon\Carbon::parse($order->deadline)->translatedFormat('d F Y') }}
                    </span>
                </div>

                <hr class="summary-divider">

                {{-- Info Pembeli --}}
                <div class="summary-item">
                    <span class="summary-label">Pembeli (Klien)</span>
                    <div class="user-profile-cell">
                        <div class="user-avatar" style="width: 34px; height: 34px; font-size: 0.9rem;">
                            {{ strtoupper(substr($order->buyer->username ?? 'A', 0, 1)) }}
                        </div>
                        <span class="user-name">{{ $order->buyer->username ?? '-' }}</span>
                    </div>
                </div>

                {{-- Info Penyedia Jasa --}}
                <div class="summary-item mt-3">
                    <span class="summary-label">Penyedia Jasa (Freelancer)</span>
                    <div class="user-profile-cell">
                        {{-- Menggunakan warna hijau untuk membedakan dengan pembeli --}}
                        <div class="user-avatar" style="width: 34px; height: 34px; font-size: 0.9rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            {{ strtoupper(substr($order->service->user->username ?? 'A', 0, 1)) }}
                        </div>
                        <span class="user-name">{{ $order->service->user->username ?? '-' }}</span>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection