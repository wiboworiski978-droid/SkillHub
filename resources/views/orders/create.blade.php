@extends('layouts.app')

@section('title', 'Pesan Jasa - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE KHUSUS HALAMAN PESAN JASA (CHECKOUT)
   ========================================= */

/* --- Layout Utama --- */
.checkout-container {
    max-width: 800px; /* Lebar yang ideal untuk form berparagraf panjang */
    margin: 40px auto 80px auto;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

.checkout-header {
    text-align: center;
    margin-bottom: 32px;
}

.checkout-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 8px 0;
}

.checkout-header p {
    color: #6b7280;
    font-size: 1.05rem;
    margin: 0;
}

/* --- Card Konten --- */
.checkout-content {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

/* --- Bagian Ringkasan (Atas) --- */
.checkout-summary {
    background-color: #f9fafb;
    padding: 24px 32px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    gap: 20px;
    align-items: center;
}

.summary-badge {
    background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    color: white;
    width: 80px;
    height: 80px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    font-weight: 600;
    text-align: center;
    padding: 10px;
    line-height: 1.3;
}

.summary-details h2 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 12px 0;
}

.summary-meta {
    display: flex;
    align-items: center;
    gap: 16px;
}

.summary-owner {
    font-size: 0.95rem;
    color: #4b5563;
}

.summary-price {
    font-size: 1.15rem;
    font-weight: 700;
    color: #10b981;
}

/* --- Area Form --- */
.checkout-form-section {
    padding: 32px;
}

.form-group {
    margin-bottom: 24px;
    display: flex;
    flex-direction: column;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.text-danger { color: #ef4444; }
.text-muted { color: #9ca3af; font-size: 0.85rem; font-weight: normal; margin-top: 6px; }

/* --- Input Styling --- */
.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid #d1d5db;
    border-radius: 8px;
    font-size: 1rem;
    color: #111827;
    background-color: #f9fafb;
    transition: all 0.2s ease;
    font-family: inherit;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #4f46e5;
    background-color: #ffffff;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
}

.form-control::placeholder { color: #9ca3af; }

.form-control.is-invalid {
    border-color: #ef4444;
    background-color: #fef2f2;
}

.error-msg {
    color: #dc2626;
    font-size: 0.85rem;
    margin-top: 6px;
    font-weight: 500;
}

/* --- Tombol Aksi --- */
.checkout-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 16px;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #f3f4f6;
}

/* Responsif (HP) */
@media (max-width: 640px) {
    .checkout-summary {
        flex-direction: column;
        text-align: center;
    }
    
    .summary-meta {
        flex-direction: column;
        gap: 8px;
    }
    
    .checkout-actions {
        flex-direction: column-reverse;
    }
    
    .checkout-actions .btn {
        width: 100%;
        text-align: center;
    }
}
</style>
<div class="checkout-container">
    
    <div class="checkout-header">
        <h1>Formulir Pemesanan</h1>
        <p>Isi detail kebutuhanmu dengan jelas agar freelancer dapat memberikan hasil yang maksimal.</p>
    </div>

    <div class="checkout-content">
        
        {{-- Bagian 1: Ringkasan Jasa yang Dipesan --}}
        <div class="checkout-summary">
            <div class="summary-badge">
                {{ $service->category->name ?? 'Jasa' }}
            </div>
            <div class="summary-details">
                <h2>{{ $service->title }}</h2>
                <div class="summary-meta">
                    <span class="summary-owner">👤 {{ $service->user->username }}</span>
                    <span class="summary-price">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Bagian 2: Formulir Kebutuhan --}}
        <div class="checkout-form-section">
            <form method="POST" action="{{ url('/services/' . $service->id . '/order') }}">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">

                <div class="form-group">
                    <label for="requirements" class="form-label">Deskripsi Kebutuhan <span class="text-danger">*</span></label>
                    <textarea
                        id="requirements"
                        name="requirements"
                        class="form-control @error('requirements') is-invalid @enderror"
                        rows="5"
                        placeholder="Contoh: Tolong buatkan desain dari foto terlampir untuk dijadikan sablon baju dengan gaya ilustrasi vektor..."
                        required
                        autofocus
                    >{{ old('requirements') }}</textarea>
                    
                    {{-- Pesan Error Spesifik --}}
                    @error('requirements')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deadline" class="form-label">Target Selesai (Deadline) <span class="text-danger">*</span></label>
                    <input
                        type="date"
                        id="deadline"
                        name="deadline"
                        class="form-control @error('deadline') is-invalid @enderror"
                        value="{{ old('deadline') }}"
                        min="{{ date('Y-m-d') }}" 
                        required
                    >
                    <small class="text-muted">Pilih tanggal kapan kamu membutuhkan proyek ini selesai.</small>
                    
                    @error('deadline')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">Catatan Tambahan <span class="text-muted">(Opsional)</span></label>
                    <textarea
                        id="notes"
                        name="notes"
                        class="form-control @error('notes') is-invalid @enderror"
                        rows="3"
                        placeholder="Masukkan link Google Drive berisi file aset, referensi warna, dll..."
                    >{{ old('notes') }}</textarea>
                    
                    @error('notes')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="checkout-actions">
                    <a href="{{ url('/services/' . $service->id) }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">Konfirmasi & Pesan Jasa</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection