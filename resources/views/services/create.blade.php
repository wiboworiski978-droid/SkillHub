@extends('layouts.app')

@section('title', 'Buat Jasa Baru - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE LENGKAP KELOMPOK FORMULIR (SRVFORM)
   ========================================= */

/* --- Wrapper Utama Form --- */
.srvform-wrapper {
    max-width: 750px;
    margin: 40px auto 80px auto;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- Kartu Form --- */
.srvform-card {
    background-color: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.05);
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

/* --- Header Form --- */
.srvform-header {
    background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    padding: 36px 32px;
    text-align: center;
    color: #ffffff;
}

.srvform-header h1 {
    margin: 0 0 8px 0;
    font-size: 1.8rem;
    font-weight: 800;
    letter-spacing: -0.02em;
}

.srvform-header p {
    margin: 0;
    color: #e0e7ff;
    font-size: 1rem;
    line-height: 1.5;
}

/* --- Alert Error Global --- */
.srvform-alert-danger {
    background-color: #fef2f2;
    border-bottom: 1px solid #fecaca;
    color: #b91c1c;
    padding: 16px 32px;
    font-size: 0.95rem;
    font-weight: 500;
}

/* --- Body / Isian Form --- */
.srvform-body {
    padding: 32px;
}

.srvform-group {
    margin-bottom: 24px;
    display: flex;
    flex-direction: column;
}

.srvform-label {
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.text-danger { 
    color: #ef4444; 
}

/* --- Input Teks, Select, & Textarea --- */
.srvform-control {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    font-size: 1rem;
    color: #0f172a;
    background-color: #f8fafc;
    transition: all 0.2s ease;
    font-family: inherit;
    box-sizing: border-box;
}

.srvform-control:focus {
    outline: none;
    border-color: #4f46e5;
    background-color: #ffffff;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
}

.srvform-control::placeholder { 
    color: #94a3b8; 
}

/* --- Input File (Thumbnail) Khusus --- */
.srvform-control-file {
    display: block;
    width: 100%;
    padding: 12px 16px;
    border: 1.5px dashed #cbd5e1;
    border-radius: 10px;
    background-color: #f8fafc;
    color: #475569;
    font-size: 0.95rem;
    cursor: pointer;
    box-sizing: border-box;
    transition: all 0.2s;
    font-family: inherit;
}

.srvform-control-file:hover {
    border-color: #4f46e5;
    background-color: #f1f5f9;
}

.srvform-hint {
    display: block;
    margin-top: 6px;
    color: #64748b;
    font-size: 0.85rem;
}

/* --- Grid 2 Kolom (Harga & Estimasi / Skill & Sekolah) --- */
.srvform-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* --- Error Messages (Validasi per Input) --- */
.srvform-control.is-invalid,
.srvform-control-file.is-invalid {
    border-color: #ef4444;
    background-color: #fef2f2;
}

.srvform-control.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
}

.srvform-error-msg {
    color: #dc2626;
    font-size: 0.85rem;
    margin-top: 6px;
    font-weight: 500;
}

/* --- Action Buttons (Tombol Bawah Form) --- */
.srvform-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 16px;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #f1f5f9;
}

/* Standar Tombol Dalam Form */
.srvform-actions .btn {
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    font-size: 1rem;
    transition: all 0.2s ease;
    border: none;
    box-sizing: border-box;
    display: inline-block;
    text-align: center;
}

.srvform-actions .btn-primary { 
    background-color: #4f46e5; 
    color: white; 
}
.srvform-actions .btn-primary:hover { 
    background-color: #4338ca; 
}

.srvform-actions .btn-outline { 
    background-color: transparent; 
    border: 1.5px solid #cbd5e1; 
    color: #475569; 
}
.srvform-actions .btn-outline:hover { 
    background-color: #f1f5f9;
    border-color: #94a3b8;
    color: #0f172a; 
}

/* --- Responsif (Layar HP) --- */
@media (max-width: 640px) {
    .srvform-header {
        padding: 28px 20px;
    }
    
    .srvform-body {
        padding: 20px;
    }

    .srvform-row {
        grid-template-columns: 1fr; /* Berubah menjadi 1 kolom bersusun di HP */
        gap: 0;
    }

    .srvform-actions {
        flex-direction: column-reverse;
    }
    
    .srvform-actions .btn {
        width: 100%;
    }
}
</style>
<div class="srvform-wrapper">

    <div class="srvform-card">
        <div class="srvform-header">
            <h1>Buat Jasa Baru</h1>
            <p>Tawarkan keahlianmu dan mulai terima pesanan dari klien.</p>
        </div>

        {{-- Menampilkan alert error global --}}
        @if ($errors->any())
            <div class="srvform-alert-danger">
                <strong>Oops!</strong> Ada beberapa data yang belum sesuai. Silakan periksa kembali form di bawah.
            </div>
        @endif

        <form
            method="POST"
            action="{{ url('/services') }}"
            enctype="multipart/form-data"
            class="srvform-body"
        >
            @csrf

            {{-- Input: Judul Jasa --}}
            <div class="srvform-group">
                <label for="title" class="srvform-label">Judul Jasa <span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="srvform-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}" 
                    placeholder="Contoh: Jasa Pembuatan Website Company Profile" 
                    required 
                    autofocus
                >
                @error('title')
                    <span class="srvform-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input: Kategori --}}
            <div class="srvform-group">
                <label for="category_id" class="srvform-label">Kategori <span class="text-danger">*</span></label>
                <select 
                    id="category_id" 
                    name="category_id" 
                    class="srvform-control @error('category_id') is-invalid @enderror"
                    required
                >
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Pilih Kategori Jasa --</option>
                    @foreach ($categories as $category)
                        <option 
                            value="{{ $category->id }}" 
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="srvform-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input: Deskripsi --}}
            <div class="srvform-group">
                <label for="description" class="srvform-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="srvform-control @error('description') is-invalid @enderror"
                    rows="6" 
                    placeholder="Jelaskan secara detail layanan apa yang akan didapatkan oleh klien..." 
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <span class="srvform-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input: Thumbnail (Sudah disesuaikan stylenya) --}}
            <div class="srvform-group">
                <label for="thumbnail" class="srvform-label">Thumbnail Jasa</label>
                <input
                    type="file"
                    id="thumbnail"
                    name="thumbnail"
                    class="srvform-control-file @error('thumbnail') is-invalid @enderror"
                    accept="image/jpeg,image/png,image/webp"
                >
                <small class="srvform-hint">
                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                </small>
                @error('thumbnail')
                    <span class="srvform-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Grid 2 Kolom untuk Harga dan Estimasi --}}
            <div class="srvform-row">
                
                {{-- Input: Harga --}}
                <div class="srvform-group">
                    <label for="price" class="srvform-label">Harga (Rp) <span class="text-danger">*</span></label>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        class="srvform-control @error('price') is-invalid @enderror"
                        value="{{ old('price') }}" 
                        min="0" 
                        placeholder="Contoh: 500000" 
                        required
                    >
                    @error('price')
                        <span class="srvform-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Input: Estimasi Pengerjaan --}}
                <div class="srvform-group">
                    <label for="estimated_days" class="srvform-label">Estimasi Pengerjaan (Hari) <span class="text-danger">*</span></label>
                    <input 
                        type="number" 
                        id="estimated_days" 
                        name="estimated_days" 
                        class="srvform-control @error('estimated_days') is-invalid @enderror"
                        value="{{ old('estimated_days') }}" 
                        min="1" 
                        placeholder="Contoh: 3" 
                        required
                    >
                    @error('estimated_days')
                        <span class="srvform-error-msg">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="srvform-actions">
                <a href="{{ url('/my-services') }}" class="btn btn-outline">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    Simpan & Terbitkan Jasa
                </button>
            </div>
            
        </form>
    </div>

</div>
@endsection