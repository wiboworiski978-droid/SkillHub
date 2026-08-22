@extends('layouts.app')

@section('title', 'Detail Order Masuk - SkillHub')

@section('content')
<style>
    /* --- Order Action Panel (Khusus Freelancer/Seller) --- */
.order-action-panel {
    padding: 24px 32px;
    background-color: #f9fafb;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.status-description {
    flex-grow: 1;
    font-size: 0.95rem;
    color: #374151;
}

.status-description p {
    margin: 0;
    line-height: 1.5;
}

.action-buttons-group {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Variant Warna Tombol Baru */
.btn-success {
    background-color: #10b981;
    color: #ffffff;
}

.btn-success:hover {
    background-color: #059669;
}

.d-inline {
    display: inline-block;
}

/* Responsif untuk Layar HP */
@media (max-width: 640px) {
    .order-action-panel {
        flex-direction: column;
        align-items: stretch;
    }

    .action-buttons-group {
        flex-direction: column;
        width: 100%;
    }

    .action-buttons-group form,
    .action-buttons-group .btn {
        width: 100%;
    }
}
</style>
<div class="order-detail-container">

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success">
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- Header Navigasi --}}
    <div class="back-navigation">
        <a href="{{ url('/orders/incoming') }}" class="back-link">
            &larr; Kembali ke Order Masuk
        </a>
    </div>

    <div class="order-card">
        {{-- Bagian 1: Header & Status Badge --}}
        <div class="order-card-header">
            <div class="header-title">
                <h1>Detail Order Masuk</h1>
                <span class="order-id">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            
            @php
                $statusClass = match(strtolower($order->status)) {
                    'pending' => 'badge-warning',
                    'accepted', 'in_progress' => 'badge-info',
                    'complete', 'completed' => 'badge-success',
                    'cancelled', 'rejected' => 'badge-danger',
                    default => 'badge-secondary',
                };
            @endphp
            <span class="badge {{ $statusClass }}">
                {{ strtoupper($order->status) }}
            </span>
        </div>

        {{-- Bagian 2: Ringkasan Informasi Jasa & Klien --}}
        <div class="order-section">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Jasa</span>
                    <strong class="info-value">{{ $order->service->title }}</strong>
                </div>
                <div class="info-item">
                    <span class="info-label">Kategori</span>
                    <strong class="info-value">{{ $order->service->category->name }}</strong>
                </div>
                <div class="info-item">
                    <span class="info-label">Pembeli / Klien</span>
                    <strong class="info-value">👤 {{ $order->buyer->username }}</strong>
                </div>
                <div class="info-item">
                    <span class="info-label">Pendapatan (Harga)</span>
                    <strong class="info-value text-success">
                        Rp {{ number_format($order->service->price, 0, ',', '.') }}
                    </strong>
                </div>
                <div class="info-item">
                    <span class="info-label">Tenggat Waktu</span>
                    <strong class="info-value text-danger">
                        🗓️ {{ \Carbon\Carbon::parse($order->deadline)->translatedFormat('d F Y') }}
                    </strong>
                </div>
            </div>
        </div>

        {{-- Bagian 3: Kebutuhan Klien (Brief) --}}
        <div class="order-section brief-section">
            <h3>Kebutuhan Klien</h3>
            <div class="brief-box">
                {!! nl2br(e($order->requirements)) !!}
            </div>

            @if ($order->notes)
                <h3 class="mt-4">Catatan Tambahan</h3>
                <div class="brief-box notes-box">
                    {!! nl2br(e($order->notes)) !!}
                </div>
            @endif
        </div>

        {{-- Bagian 4: Panel Informasi Status & Aksi --}}
        <div class="order-action-panel">
            <div class="status-description">
                @if ($order->status === 'pending')
                    <p>💡 <strong>Order Baru:</strong> Silakan periksa kebutuhan klien di atas sebelum menerima atau menolak pesanan ini.</p>
                @elseif ($order->status === 'accepted')
                    <p>✅ <strong>Order Diterima:</strong> Tekan tombol "Mulai Pengerjaan" saat kamu siap mengerjakan proyek ini.</p>
                @elseif ($order->status === 'in_progress')
                    <p>⏳ <strong>Sedang Dikerjakan:</strong> Pastikan hasil pekerjaan dikirim tepat waktu sebelum deadline.</p>
                @elseif (in_array($order->status, ['complete', 'completed']))
                    <p>🎉 <strong>Selesai:</strong> Order ini telah berhasil diselesaikan.</p>
                @elseif ($order->status === 'rejected')
                    <p>❌ <strong>Ditolak:</strong> Kamu telah menolak order ini.</p>
                @elseif ($order->status === 'cancelled')
                    <p>⚠️ <strong>Dibatalkan:</strong> Order ini telah dibatalkan oleh pembeli.</p>
                @endif
            </div>

            <div class="action-buttons-group">
                {{-- Tombol Konfirmasi Pending --}}
                @if ($order->status === 'pending')
                    <form method="POST" action="{{ url('/orders/incoming/' . $order->id . '/status') }}" class="d-inline">
                        @csrf
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit" class="btn btn-success">
                            Terima Order
                        </button>
                    </form>

                    <form method="POST" action="{{ url('/orders/incoming/' . $order->id . '/status') }}" class="d-inline" onsubmit="return confirm('Yakin ingin menolak order ini?')">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-danger">
                            Tolak Order
                        </button>
                    </form>
                @endif

                {{-- Tombol Mulai Pengerjaan --}}
                @if ($order->status === 'accepted')
                    <form method="POST" action="{{ url('/orders/incoming/' . $order->id . '/start') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            🚀 Mulai Pengerjaan
                        </button>
                    </form>
                @endif

                {{-- Tombol Selesaikan Order --}}
                @if ($order->status === 'in_progress')
                    <form method="POST" action="{{ url('/orders/incoming/' . $order->id . '/complete') }}" onsubmit="return confirm('Apakah pekerjaan sudah selesai dan dikirim ke klien?')">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            ✅ Selesaikan Order
                        </button>
                    </form>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection