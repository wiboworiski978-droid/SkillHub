@extends('layouts.app')

@section('title', 'Order Masuk - SkillHub')

@section('content')
<style>
    /* --- Orders Container & Header --- */
.orders-container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px 60px;
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

/* --- Alert Messages --- */
.alert {
    padding: 16px 20px;
    border-radius: 8px;
    margin-bottom: 24px;
    font-size: 0.95rem;
}

.alert-success {
    background-color: #ecfdf5;
    border: 1px solid #10b981;
    color: #047857;
}

/* --- Orders Grid --- */
.orders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 24px;
}

/* --- Order List Card --- */
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

/* --- Card Top (ID & Status) --- */
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

/* --- Status Badges --- */
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

/* --- Card Body --- */
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

/* --- Order Meta Info --- */
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

/* Teks Spesifik */
.font-bold { font-weight: 700; }
.text-success { color: #10b981; }
.text-danger { color: #ef4444; }

/* --- Card Footer & Buttons --- */
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
}

.btn-block {
    display: block;
    width: 100%;
}

.btn-primary {
    background-color: #4f46e5;
    color: #ffffff;
}

.btn-primary:hover {
    background-color: #4338ca;
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

/* --- Empty State --- */
.empty-state {
    grid-column: 1 / -1; /* Membuat empty state membentang penuh di tengah grid */
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
    max-width: 400px;
    margin: 0 auto;
    line-height: 1.6;
}

.mt-3 {
    margin-top: 16px;
}

/* --- Pagination (Opsional) --- */
.pagination-wrapper {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}
</style>
<div class="orders-container">

    {{-- Header Section --}}
    <div class="orders-header">
        <h1>Order Masuk</h1>
        <p>Kelola pesanan dari klien untuk jasa yang kamu tawarkan.</p>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert alert-success">
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- Daftar Order Masuk --}}
    <div class="orders-grid">
        @forelse ($orders as $order)
            <div class="order-list-card">
                
                {{-- Card Header: ID Order & Badge Status --}}
                <div class="card-top">
                    <span class="order-id">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                    @php
                        $statusClass = match(strtolower($order->status)) {
                            'pending' => 'badge-warning',
                            'accepted', 'in_progress' => 'badge-info',
                            'completed' => 'badge-success',
                            'cancelled', 'rejected' => 'badge-danger',
                            default => 'badge-secondary',
                        };
                    @endphp
                    <span class="badge {{ $statusClass }}">
                        {{ strtoupper($order->status) }}
                    </span>
                </div>

                {{-- Card Body: Info Jasa & Pembeli --}}
                <div class="card-body">
                    <h2 class="service-title" title="{{ $order->service->title }}">
                        {{ Str::limit($order->service->title, 40) }}
                    </h2>
                    
                    <div class="order-meta-grid">
                        <div class="meta-item">
                            <span class="meta-label">Pembeli / Klien</span>
                            <strong class="meta-value">👤 {{ $order->buyer->username }}</strong>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Harga Kesepakatan</span>
                            <span class="meta-value text-success font-bold">
                                Rp {{ number_format($order->service->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Tenggat Waktu</span>
                            <span class="meta-value text-danger">
                                🗓️ {{ \Carbon\Carbon::parse($order->deadline)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card Footer: Tombol Aksi --}}
                <div class="card-footer">
                    {{-- Menggunakan tombol berwarna utama (Primary) karena ini butuh aksi/tanggapan --}}
                    <a href="{{ url('/orders/incoming/' . $order->id) }}" class="btn btn-primary btn-block">
                        Kelola Order
                    </a>
                </div>

            </div>
        @empty
            {{-- Tampilan Jika Belum Ada Order Masuk --}}
            <div class="empty-state">
                <div class="empty-icon">📥</div>
                <h3>Belum Ada Order Masuk</h3>
                <p>Saat ini belum ada pesanan baru untuk jasamu. Tetap semangat, perbaiki portofolio, dan promosikan jasamu!</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(method_exists($orders, 'links'))
        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
    @endif

</div>
@endsection