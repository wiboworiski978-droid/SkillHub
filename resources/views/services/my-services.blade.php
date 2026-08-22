@extends('layouts.app')

@section('title', 'Jasa Saya - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE KHUSUS HALAMAN "JASA SAYA"
   ========================================= */

/* --- Container Utama --- */
.mysrv-wrapper {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- Alert Sukses --- */
.mysrv-alert {
    background-color: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
    padding: 16px 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 500;
}
.alert-icon { font-weight: bold; }

/* --- Header Section --- */
.mysrv-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #f3f4f6;
    padding-bottom: 24px;
    margin-bottom: 30px;
}

.header-titles h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 8px 0;
}

.header-titles p {
    color: #6b7280;
    margin: 0;
    font-size: 1rem;
}

/* --- Tombol Global --- */
.mysrv-btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    box-sizing: border-box;
}

.mysrv-btn-primary {
    background-color: #4f46e5;
    color: #ffffff;
}
.mysrv-btn-primary:hover { background-color: #4338ca; }

.mysrv-btn-outline {
    background-color: transparent;
    color: #4f46e5;
    border: 1.5px solid #4f46e5;
}
.mysrv-btn-outline:hover {
    background-color: #4f46e5;
    color: #ffffff;
}
.w-100 { width: 100%; }
.mt-4 { margin-top: 24px; }

/* --- Grid System --- */
.mysrv-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

/* --- Service Card (Sangat Rapi & Presisi) --- */
.mysrv-card {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s, box-shadow 0.2s;
}

.mysrv-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.08);
}

/* --- Area Gambar Card --- */
.card-image-area {
    height: 160px;
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    position: relative;
}

.badge-category {
    position: absolute;
    top: 16px;
    left: 16px;
    background-color: rgba(17, 24, 39, 0.75);
    color: #fff;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-status {
    position: absolute;
    top: 16px;
    right: 16px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.status-active { background-color: #10b981; color: white; }
.status-inactive { background-color: #6b7280; color: white; }

/* --- Area Konten Card --- */
.card-content {
    padding: 24px 24px 16px 24px;
    flex-grow: 1; /* Memastikan konten merenggang agar footer selalu di bawah */
    display: flex;
    flex-direction: column;
}

.card-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 12px 0;
    line-height: 1.4;
}

.card-desc {
    color: #6b7280;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0 0 20px 0;
    flex-grow: 1; /* Mendorong harga ke bawah jika deskripsi pendek */
}

/* --- Stats (Harga & Hari) --- */
.card-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-top: 1px solid #f3f4f6;
    padding-top: 16px;
}

.stat-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.align-right { text-align: right; }

.stat-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #9ca3af;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.stat-value {
    font-weight: 700;
    color: #374151;
    font-size: 1rem;
}
.text-green { color: #10b981; }

/* --- Footer Card --- */
.card-footer {
    padding: 0 24px 24px 24px;
}

/* --- Empty State --- */
.mysrv-empty {
    text-align: center;
    background-color: #f9fafb;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 60px 20px;
    margin-top: 20px;
}
.empty-icon {
    font-size: 3.5rem;
    margin-bottom: 16px;
}
.mysrv-empty h3 {
    font-size: 1.25rem;
    color: #111827;
    margin: 0 0 8px 0;
}
.mysrv-empty p {
    color: #6b7280;
    max-width: 450px;
    margin: 0 auto;
    line-height: 1.5;
}

/* --- Responsif (HP) --- */
@media (max-width: 640px) {
    .mysrv-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }
    .header-action, .mysrv-btn {
        width: 100%;
    }
}
</style>
<div class="mysrv-wrapper">

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="mysrv-alert">
            <span class="alert-icon">✓</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header Section --}}
    <div class="mysrv-header">
        <div class="header-titles">
            <h1>Jasa Saya</h1>
            <p>Kelola etalase jasamu dan mulai terima pesanan.</p>
        </div>
        <div class="header-action">
            <a href="{{ url('/services/create') }}" class="mysrv-btn mysrv-btn-primary">
                + Buat Jasa Baru
            </a>
        </div>
    </div>

    {{-- Daftar Jasa --}}
    @if ($services->isEmpty())
        
        <div class="mysrv-empty">
            <div class="empty-icon">💼</div>
            <h3>Belum Ada Jasa</h3>
            <p>Kamu belum menawarkan jasa apapun. Ayo mulai buat etalase jasamu agar klien bisa mulai memesan!</p>
            <a href="{{ url('/services/create') }}" class="mysrv-btn mysrv-btn-primary mt-4">
                + Buat Jasa Pertamamu
            </a>
        </div>

    @else
        
        <div class="mysrv-grid">
            @foreach ($services as $service)
                <div class="mysrv-card">
                    
                    {{-- Area Gambar & Badge --}}
                    <div class="card-image-area">
                        <div class="badge-category">{{ $service->category->name }}</div>
                        
                        @if (strtolower($service->status) === 'active')
                            <div class="badge-status status-active">Aktif</div>
                        @else
                            <div class="badge-status status-inactive">Nonaktif</div>
                        @endif
                    </div>

                    {{-- Area Konten Utama --}}
                    <div class="card-content">
                        <h3 class="card-title">{{ $service->title }}</h3>
                        <p class="card-desc">
                            {{ Str::limit($service->description, 80) }}
                        </p>

                        <div class="card-stats">
                            <div class="stat-item">
                                <span class="stat-label">Harga</span>
                                <span class="stat-value text-green">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="stat-item align-right">
                                <span class="stat-label">Pengerjaan</span>
                                <span class="stat-value">{{ $service->estimated_days }} Hari</span>
                            </div>
                        </div>
                    </div>

                    {{-- Area Tombol Bawah --}}
                    <div class="card-footer">
                        <a href="{{ url('/services/' . $service->id) }}" class="mysrv-btn mysrv-btn-outline w-100">
                            Lihat Detail
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

    @endif

</div>
@endsection