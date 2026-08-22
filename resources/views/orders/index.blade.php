@extends('layouts.app')

@section('title', 'Order Saya - SkillHub')

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
}

.orders-header p {
    color: #6b7280;
    font-size: 1.05rem;
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
}

.meta-value {
    color: #111827;
    font-weight: 500;
}

.font-bold {
    font-weight: 700;
}

/* --- Card Footer --- */
.card-footer {
    padding: 16px 20px;
    border-top: 1px solid #f3f4f6;
    background-color: #ffffff;
}

/* --- Empty State Enhancements --- */
.empty-icon {
    font-size: 3rem;
    margin-bottom: 16px;
}

.mt-3 {
    margin-top: 16px;
}
</style>
<div class="orders-container">

    {{-- Header Section --}}
    <div class="orders-header">
        <h1>Order Saya</h1>
        <p>Pantau status, riwayat, dan detail pemesanan jasamu di sini.</p>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert alert-success">
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- Daftar Order --}}
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
                            <span class="meta-label">Harga</span>
                            <span class="meta-value text-success font-bold">
                                Rp {{ number_format($order->service->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Deadline</span>
                            <span class="meta-value text-danger">
                                🗓️ {{ \Carbon\Carbon::parse($order->deadline)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card Footer: Tombol Aksi --}}
                <div class="card-footer">
                    <a href="{{ url('/orders/' . $order->id) }}" class="btn btn-outline btn-block">
                        Lihat Detail Order
                    </a>
                </div>

            </div>
        @empty
            {{-- Tampilan Jika Belum Ada Order --}}
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h3>Belum Ada Order</h3>
                <p>Kamu belum memiliki riwayat pemesanan. Yuk, cari jasa yang kamu butuhkan!</p>
                <a href="{{ url('/services') }}" class="btn btn-primary mt-3">
                    Explore Jasa Sekarang
                </a>
            </div>
        @endforelse
    </div>

    {{-- Pagination (Jika Datanya Banyak) --}}
    @if(method_exists($orders, 'links'))
        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
    @endif

</div>
@endsection