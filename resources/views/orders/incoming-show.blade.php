@extends('layouts.app')

@section('title', 'Detail Order Masuk - SkillHub')

@section('content')
<style>
    /* =========================================
       STYLE HALAMAN DETAIL ORDER MASUK
       ========================================= */

    .order-detail-container {
        max-width: 900px;
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
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .back-link:hover {
        color: #4f46e5;
    }

    /* --- Card Utama --- */
    .order-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* --- Bagian 1: Header & Status --- */
    .order-card-header {
        background-color: #f9fafb;
        padding: 24px 32px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-title {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .header-title h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .order-id {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 600;
        letter-spacing: 0.05em;
    }

    /* Warna-warni Badge Status */
    .badge {
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-warning { background-color: #fef3c7; color: #d97706; }
    .badge-info { background-color: #e0f2fe; color: #0284c7; }
    .badge-success { background-color: #d1fae5; color: #059669; }
    .badge-danger { background-color: #fee2e2; color: #dc2626; }
    .badge-secondary { background-color: #f3f4f6; color: #4b5563; }

    /* --- Bagian 2: Ringkasan Informasi (Grid) --- */
    .order-section {
        padding: 32px;
        border-bottom: 1px solid #e5e7eb;
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
        font-size: 0.8rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .info-value {
        font-size: 1.05rem;
        color: #111827;
    }

    /* --- Bagian 3: Brief / Kebutuhan Klien --- */
    .brief-section h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 16px 0;
    }

    .brief-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        font-size: 0.95rem;
        color: #334155;
        line-height: 1.6;
    }

    .notes-box {
        background-color: #fffbeb;
        border-color: #fde68a;
        color: #92400e;
    }

    .mt-4 {
        margin-top: 24px;
    }

    /* --- Bagian 4: Panel Aksi & Status Panel --- */
    .order-action-panel {
        background-color: #f9fafb;
        padding: 32px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .status-description {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        padding: 16px 20px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .status-description p {
        margin: 0;
        font-size: 0.95rem;
        color: #4b5563;
        line-height: 1.5;
    }

    /* Tombol Aksi */
    .action-buttons-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .d-inline {
        display: inline-block;
        margin: 0;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-success { background-color: #10b981; color: #ffffff; }
    .btn-success:hover { background-color: #059669; }

    .btn-danger { background-color: #ef4444; color: #ffffff; }
    .btn-danger:hover { background-color: #dc2626; }

    .btn-primary { background-color: #4f46e5; color: #ffffff; }
    .btn-primary:hover { background-color: #4338ca; }

    /* Form Upload Hasil Jasa */
    .upload-box {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        width: 100%;
        box-sizing: border-box;
    }

    .upload-box h3 {
        margin-top: 0;
        margin-bottom: 12px;
        font-size: 1.1rem;
        color: #1e293b;
    }

    .upload-input-file {
        display: block;
        width: 100%;
        padding: 10px;
        border: 1.5px dashed #cbd5e1;
        border-radius: 8px;
        background-color: #f8fafc;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    /* --- Responsif (Layar HP) --- */
    @media (max-width: 640px) {
        .order-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .action-buttons-group {
            flex-direction: column;
            width: 100%;
        }
        
        .action-buttons-group form {
            width: 100%;
        }
        
        .action-buttons-group .btn {
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
                    <p>⏳ <strong>Sedang Dikerjakan:</strong> Silakan unggah hasil pekerjaan pada form di bawah ini jika proyek telah selesai.</p>
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

                {{-- Form Upload & Selesaikan Order --}}
                @if ($order->status === 'in_progress')
                    <div class="upload-box">
                        <h3>Upload Hasil Jasa</h3>
                        <form
                            method="POST"
                            action="{{ url('/orders/incoming/' . $order->id . '/complete') }}"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            <input
                                type="file"
                                name="result_file"
                                class="upload-input-file"
                                required
                            >
                            <small style="display: block; color: #64748b; margin-bottom: 16px;">
                                Format bebas (ZIP, RAR, PDF, JPG, dll). Maksimal 10 MB.
                            </small>

                            <button type="submit" class="btn btn-success">
                                ✅ Upload & Selesaikan Order
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        {{-- Bagian 5: File Hasil Jasa --}}
@if (in_array($order->status, ['complete', 'completed']) && $order->result_file)

    <div class="order-section">
        <div class="brief-section">

            <h3>📁 File Hasil Jasa</h3>

            <div class="brief-box">

                <p>
                    <strong>File hasil:</strong>
                    {{ basename($order->result_file) }}
                </p>

                <a
                    href="{{ asset('storage/' . $order->result_file) }}"
                    download
                    class="btn btn-success"
                >
                     Download File
                </a>

            </div>

        </div>
    </div>

@endif

    </div>
</div>
@endsection