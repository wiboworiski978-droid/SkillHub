@extends('layouts.app')

@section('title', 'Riwayat Order - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE UNTUK DAFTAR ORDER & RIWAYAT
   ========================================= */

/* --- Container & Header --- */
.orders-container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px 60px;
    font-family: 'Inter', system-ui, sans-serif;
}

.orders-header {
    text-align: center;
    margin-bottom: 40px;
}

.orders-header h1 {
    font-size: 2rem;
    color: #111827;
    margin-bottom: 8px;
    font-weight: 700;
}

.orders-header p {
    color: #6b7280;
    font-size: 1.05rem;
}

/* --- Layout Grid --- */
.orders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 24px;
}

/* --- Card Order Utama --- */
.order-list-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    overflow: hidden;
}

.order-list-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

/* --- Bagian Atas Card (ID & Status) --- */
.card-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background-color: #f9fafb;
    border-bottom: 1px solid #f3f4f6;
}

.order-id {
    font-size: 0.85rem;
    font-weight: 600;
    color: #6b7280;
}

/* --- Badge Status --- */
.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.05em;
}

.badge-warning { background-color: #fef3c7; color: #b45309; }
.badge-info { background-color: #e0f2fe; color: #0369a1; }
.badge-success { background-color: #d1fae5; color: #047857; }
.badge-danger { background-color: #fee2e2; color: #b91c1c; }
.badge-secondary { background-color: #f3f4f6; color: #4b5563; }

/* --- Bagian Tengah Card (Info Jasa) --- */
.card-body {
    padding: 20px;
    flex-grow: 1;
}

.service-title {
    font-size: 1.15rem;
    color: #111827;
    margin-bottom: 20px;
    line-height: 1.4;
    font-weight: 600;
}

/* --- List Detail Jasa (Meta) --- */
.order-meta-grid {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.meta-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.95rem;
}

.meta-label {
    color: #6b7280;
    font-size: 0.85rem;
}

.meta-value {
    color: #111827;
    font-weight: 500;
}

.font-bold { font-weight: 700; }
.text-success { color: #10b981; }
.text-danger { color: #ef4444; }

/* --- Bagian Bawah Card (Tombol) --- */
.card-footer {
    padding: 16px 20px;
    border-top: 1px solid #f3f4f6;
    background-color: #ffffff;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
    box-sizing: border-box;
}

.btn-block {
    display: block;
    width: 100%;
}

.btn-outline {
    background-color: transparent;
    color: #4f46e5;
    border: 1.5px solid #4f46e5;
}

.btn-outline:hover {
    background-color: #4f46e5;
    color: #ffffff;
}

/* --- Tampilan Kosong (Empty State) --- */
.empty-state {
    grid-column: 1 / -1; 
    text-align: center;
    padding: 60px 20px;
    background-color: #f9fafb;
    border-radius: 12px;
    border: 2px dashed #e5e7eb;
}

.empty-icon {
    font-size: 3.5rem;
    margin-bottom: 16px;
}

.empty-state h3 {
    font-size: 1.25rem;
    color: #374151;
    margin-bottom: 8px;
}

.empty-state p {
    color: #6b7280;
    max-width: 450px;
    margin: 0 auto;
    line-height: 1.6;
}

/* --- Pagination (Jika data sudah banyak) --- */
.pagination-wrapper {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}
</style>
<div class="orders-container">

    {{-- Header Section --}}
    <div class="orders-header">
        <h1>Riwayat Order</h1>
        <p>Arsip semua pesananmu yang sudah selesai atau dibatalkan.</p>
    </div>

    {{-- Pengecekan aman menggunakan @if (Menghindari error @forelse) --}}
    @if ($orders->isEmpty())
        
        <div class="empty-state">
            <div class="empty-icon">🗄️</div>
            <h3>Belum Ada Riwayat</h3>
            <p>Kamu belum memiliki riwayat order yang selesai atau dibatalkan. Pesanan yang sedang berjalan bisa dilihat di menu Order Saya.</p>
        </div>

    @else
        
        <div class="orders-grid">
            @foreach ($orders as $order)
                <div class="order-list-card">
                    
                    {{-- Card Header: ID Order & Badge Status --}}
                    <div class="card-top">
                        <span class="order-id">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        @php
                            $statusClass = match(strtolower($order->status)) {
                                'completed', 'complete' => 'badge-success',
                                'cancelled', 'rejected' => 'badge-danger',
                                default => 'badge-secondary',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>

                    {{-- Card Body: Info Jasa --}}
                    <div class="card-body">
                        <h2 class="service-title" title="{{ $order->service->title }}">
                            {{ Str::limit($order->service->title, 40) }}
                        </h2>
                        
                        <div class="order-meta-grid">
                            <div class="meta-item">
                                <span class="meta-label">Pemilik Jasa</span>
                                <span class="meta-value">👤 {{ $order->service->user->username }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Kategori</span>
                                <span class="meta-value">{{ $order->service->category->name }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Harga</span>
                                <span class="meta-value text-success font-bold">
                                    Rp {{ number_format($order->service->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Selesai pada</span>
                                <span class="meta-value text-danger">
                                    🗓️ {{ \Carbon\Carbon::parse($order->deadline)->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer: Tombol Aksi --}}
                    <div class="card-footer">
                        <a href="{{ url('/orders/' . $order->id) }}" class="btn btn-outline btn-block">
                            Lihat Detail
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

    @endif

    {{-- Pagination (Jika dibutuhkan) --}}
    @if(method_exists($orders, 'links'))
        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
    @endif

</div>
@endsection