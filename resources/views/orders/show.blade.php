@extends('layouts.app')

@section('title', 'Detail Order - SkillHub')

@section('content')
<style>
/* --- Order Detail Container --- */
.order-detail-container {
    max-width: 800px;
    margin: 40px auto 80px;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
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

/* --- Order Card Main --- */
.order-card {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

/* --- Header Card --- */
.order-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 32px;
    background-color: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.header-title h1 {
    font-size: 1.5rem;
    color: #111827;
    margin-bottom: 4px;
    margin-top: 0;
}

.order-id {
    font-size: 0.9rem;
    color: #6b7280;
    font-weight: 500;
}

/* --- Status Badges --- */
.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}
.badge-warning { background-color: #fef3c7; color: #b45309; }
.badge-info { background-color: #e0f2fe; color: #0369a1; }
.badge-success { background-color: #d1fae5; color: #047857; }
.badge-danger { background-color: #fee2e2; color: #b91c1c; }
.badge-secondary { background-color: #f3f4f6; color: #4b5563; }

/* --- Sections & Grid --- */
.order-section {
    padding: 32px;
    border-bottom: 1px solid #f3f4f6;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 24px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.info-label {
    font-size: 0.85rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
}

.info-value {
    font-size: 1.05rem;
    color: #111827;
}

/* Teks Spesifik */
.text-success { color: #10b981; }
.text-danger { color: #ef4444; }
.mt-4 { margin-top: 24px; }

/* --- Brief / Kebutuhan Box --- */
.brief-section h3 {
    font-size: 1.1rem;
    color: #374151;
    margin-bottom: 12px;
    margin-top: 0;
}

.brief-box {
    background-color: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    color: #4b5563;
    line-height: 1.7;
    font-size: 0.95rem;
}

.notes-box {
    background-color: #fffbeb;
    border-color: #fde68a;
}

/* --- Footer & Tombol Aksi --- */
.order-card-footer {
    padding: 24px 32px;
    background-color: #f9fafb;
    display: flex;
    justify-content: flex-end;
    gap: 16px;
    align-items: center;
}

.d-inline {
    display: inline-block;
    margin: 0;
}

/* --- Responsif --- */
@media (max-width: 600px) {
    .order-card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    
    .order-card-footer {
        flex-direction: column-reverse;
    }
    
    .order-card-footer .btn,
    .order-card-footer form {
        width: 100%;
        text-align: center;
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
    <div style="margin-bottom: 24px;">
        <a href="{{ url('/orders') }}" style="color: #6b7280; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
            &larr; Kembali ke Daftar Order
        </a>
    </div>

    <div class="order-card">
        {{-- Bagian 1: Header Order & Status --}}
        <div class="order-card-header">
            <div class="header-title">
                <h1>Detail Order</h1>
                <span class="order-id">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            
            @php
                $statusClass = match(strtolower($order->status)) {
                    'pending' => 'badge-warning',
                    'accepted', 'in_progress' => 'badge-info',
                    'complete' => 'badge-success',
                    'cancelled', 'rejected' => 'badge-danger',
                    default => 'badge-secondary',
                };
            @endphp
            <span class="badge {{ $statusClass }}">
                {{ strtoupper($order->status) }}
            </span>
        </div>

        {{-- Bagian 2: Info Jasa & Harga --}}
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
                    <span class="info-label">Pemilik Jasa</span>
                    <strong class="info-value">👤 {{ $order->service->user->username }}</strong>
                </div>
                <div class="info-item">
                    <span class="info-label">Harga Kesepakatan</span>
                    <strong class="info-value text-success">
                        Rp {{ number_format($order->service->price, 0, ',', '.') }}
                    </strong>
                </div>
                <div class="info-item">
                    <span class="info-label">Deadline / Tenggat Waktu</span>
                    <strong class="info-value text-danger">
                        🗓️ {{ \Carbon\Carbon::parse($order->deadline)->translatedFormat('d F Y') }}
                    </strong>
                </div>
            </div>
        </div>

        {{-- Bagian 3: Brief / Kebutuhan Klien --}}
        <div class="order-section brief-section">
            <h3>Kebutuhan Proyek</h3>
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

        {{-- Bagian 4: Hasil Jasa (Tampil jika order selesai & ada file) --}}
        @if ($order->status === 'complete' && $order->result_file)
            <div class="order-section brief-section">
                <h3>Hasil Jasa</h3>
                <div class="brief-box" style="background-color: #f0fdf4; border-color: #bbf7d0;">
                    <p style="margin-top: 0; color: #166534; margin-bottom: 16px;">
                        Penyedia jasa telah menyelesaikan pekerjaan dan mengirimkan file hasil jasa. Silakan unduh melalui tombol di bawah ini:
                    </p>
                    <a
                        href="{{ asset('storage/' . $order->result_file) }}"
                        target="_blank"
                        class="btn btn-success"
                        style="display: inline-block; background-color: #10b981; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;"
                    >
                        ↓ Download Hasil Pekerjaan
                    </a>
                </div>
            </div>
        @endif

        {{-- Bagian 5: Area Aksi (Footer Tombol) --}}
        <div class="order-card-footer">
            <a href="{{ url('/orders') }}" class="btn btn-outline" style="color: #4b5563; text-decoration: none; font-weight: 600; padding: 10px 16px;">
                Kembali
            </a>

            @if (in_array(strtolower($order->status), ['pending', 'accepted', 'in_progress']))
                <form 
                    method="POST" 
                    action="{{ url('/orders/' . $order->id . '/cancel') }}" 
                    class="d-inline"
                    onsubmit="return confirm('Apakah kamu yakin ingin membatalkan order ini? Tindakan ini tidak bisa dibatalkan.')"
                >
                    @csrf
                    <button type="submit" class="btn btn-danger" style="background-color: #ef4444; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        Batalkan Order
                    </button>
                </form>
            @endif
        </div>

    </div>
</div>
@endsection