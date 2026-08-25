@extends('layouts.admin')

@section('title', 'Kelola Order - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE ADMIN KELOLA DATA (PREMIUM TABLE)
   ========================================= */

.admin-container {
    max-width: 1100px;
    margin: 40px auto 80px auto;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- 1. Header Admin --- */
.admin-page-header {
    margin-bottom: 32px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #64748b;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 16px;
    transition: color 0.2s;
}

.back-link:hover { 
    color: #0f172a; 
}

.admin-page-header h1 {
    font-size: 2rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 8px 0;
    letter-spacing: -0.02em;
}

.admin-page-header p {
    color: #64748b;
    margin: 0;
    font-size: 1.05rem;
}

/* --- 2. Premium Table Card --- */
.premium-table-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
    overflow: hidden;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.premium-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px; /* Mencegah tabel hancur di layar kecil */
}

/* Header Tabel */
.premium-table th {
    background-color: #f8fafc;
    padding: 16px 24px;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}

/* Isi Tabel */
.premium-table td {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    transition: background-color 0.2s;
}

.premium-table tbody tr:hover td {
    background-color: #f8fafc;
}

.premium-table tbody tr:last-child td {
    border-bottom: none;
}

/* --- 3. Avatar & User Info --- */
.user-profile-cell {
    display: flex;
    align-items: center;
    gap: 16px;
}

.user-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    font-weight: 700;
    box-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.user-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 0.95rem;
}

.user-id {
    font-size: 0.8rem;
    color: #94a3b8;
}

/* --- 4. Badges dengan Dot Indicator --- */
.premium-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
}

.badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

/* Varian Role User */
.badge-admin { background-color: #e0e7ff; color: #3730a3; }
.badge-admin .badge-dot { background-color: #4f46e5; }
.badge-user { background-color: #f1f5f9; color: #475569; }
.badge-user .badge-dot { background-color: #94a3b8; }

/* Varian Status Umum / Jasa */
.badge-active { background-color: #dcfce7; color: #15803d; }
.badge-active .badge-dot { background-color: #22c55e; }
.badge-inactive { background-color: #f1f5f9; color: #64748b; }
.badge-inactive .badge-dot { background-color: #94a3b8; }

/* Varian Status Order (Lengkap) */
.badge-warning { background-color: #fef9c3; color: #a16207; }
.badge-warning .badge-dot { background-color: #eab308; }
.badge-info { background-color: #e0f2fe; color: #0284c7; }
.badge-info .badge-dot { background-color: #0ea5e9; }
.badge-success { background-color: #dcfce7; color: #15803d; }
.badge-success .badge-dot { background-color: #22c55e; }
.badge-danger { background-color: #fee2e2; color: #b91c1c; }
.badge-danger .badge-dot { background-color: #ef4444; }
.badge-secondary { background-color: #f1f5f9; color: #475569; }
.badge-secondary .badge-dot { background-color: #94a3b8; }

/* --- 5. Teks Utilitas --- */
.text-secondary { color: #475569; font-size: 0.95rem; }
.text-right { text-align: right !important; }
.text-muted-italic { color: #94a3b8; font-style: italic; font-size: 0.9rem; }
.d-inline { display: inline-block; margin: 0; }

/* --- 6. Tombol Aksi --- */
/* Tombol Hapus (Soft Red) */
.btn-action-delete {
    background-color: transparent;
    color: #ef4444;
    border: 1px solid #fecaca;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-action-delete:hover {
    background-color: #fef2f2;
    border-color: #ef4444;
}

/* Tombol Detail/View (Soft Blue) */
.btn-action-view {
    display: inline-block;
    background-color: #f8fafc;
    color: #4f46e5;
    border: 1px solid #e2e8f0;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-action-view:hover {
    background-color: #e0e7ff;
    border-color: #c7d2fe;
    color: #3730a3;
}

/* --- 7. Tampilan Kosong (Empty State) --- */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}
.empty-icon {
    font-size: 3rem;
    margin-bottom: 16px;
}
.empty-state h3 {
    margin: 0 0 8px 0;
    color: #0f172a;
    font-size: 1.25rem;
}
.empty-state p {
    color: #64748b;
    margin: 0;
}

/* --- 8. Responsif HP --- */
@media (max-width: 640px) {
    .premium-table-card { 
        border-radius: 0; 
        border-left: none; 
        border-right: none; 
    }
    .admin-page-header h1 { 
        font-size: 1.7rem; 
    }
}
</style>
<div class="admin-container">

    {{-- Header Admin Modern --}}
    <div class="admin-page-header">
        <div class="header-content">
            <a href="{{ url('/admin/dashboard') }}" class="back-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1>Kelola Order</h1>
            <p>Pantau seluruh aliran transaksi, proyek yang sedang berjalan, dan status pesanan.</p>
        </div>
    </div>

    {{-- Card Tabel Modern --}}
    <div class="premium-table-card">
        <div class="table-responsive">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>ID Order</th>
                        <th>Jasa & Harga</th>
                        <th>Pembeli</th>
                        <th>Penyedia Jasa</th>
                        <th>Batas Waktu</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            {{-- Kolom ID --}}
                            <td>
                                <strong class="text-secondary">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong>
                            </td>

                            {{-- Kolom Jasa & Harga (Digabung agar lebih rapi) --}}
                            <td>
                                <div class="user-details">
                                    <span class="user-name">{{ Str::limit($order->service->title ?? 'Jasa Tidak Ditemukan', 30) }}</span>
                                    <span style="color: #10b981; font-weight: 700; font-size: 0.85rem;">
                                        Rp {{ number_format($order->service->price ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                            </td>

                            {{-- Kolom Pembeli --}}
                            <td>
                                <strong>{{ $order->buyer->username ?? '-' }}</strong>
                            </td>

                            {{-- Kolom Penyedia Jasa --}}
                            <td>
                                <strong>{{ $order->service->user->username ?? '-' }}</strong>
                            </td>

                            {{-- Kolom Deadline --}}
                            <td>
                                <span class="text-secondary">
                                    {{ \Carbon\Carbon::parse($order->deadline)->format('d M Y') }}
                                </span>
                            </td>

                            {{-- Kolom Status (Badge Dinamis) --}}
                            <td>
                                @php
                                    $statusClass = match(strtolower($order->status)) {
                                        'pending' => 'badge-warning',
                                        'accepted', 'in_progress' => 'badge-info',
                                        'complete', 'completed' => 'badge-success',
                                        'cancelled', 'rejected' => 'badge-danger',
                                        default => 'badge-secondary',
                                    };
                                @endphp
                                <span class="premium-badge {{ $statusClass }}">
                                    <span class="badge-dot"></span>
                                    {{ strtoupper($order->status) }}
                                </span>
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="text-right">
                                <a href="{{ url('/admin/orders/' . $order->id) }}" class="btn-action-view">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">📦</div>
                                    <h3>Belum ada transaksi</h3>
                                    <p>Saat ini belum ada order yang masuk ke dalam platform.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection