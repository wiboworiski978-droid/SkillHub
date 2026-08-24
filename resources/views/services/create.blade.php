@extends('layouts.app')

@section('title', 'Buat Jasa Baru - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE KHUSUS FORMULIR (BUAT JASA)
   ========================================= */

/* --- Wrapper Form --- */
.srvform-wrapper {
    max-width: 750px; /* Dibuat lebih sempit agar form mudah dibaca */
    margin: 40px auto 80px auto;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- Card Form --- */
.srvform-card {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    border: 1px solid #f3f4f6;
    overflow: hidden;
}

/* --- Header Form --- */
.srvform-header {
    background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    padding: 32px;
    text-align: center;
    color: #ffffff;
}

.srvform-header h1 {
    margin: 0 0 8px 0;
    font-size: 1.8rem;
    font-weight: 700;
}

.srvform-header p {
    margin: 0;
    color: #e0e7ff;
    font-size: 1rem;
}

/* --- Alert Error Global --- */
.srvform-alert-danger {
    background-color: #fef2f2;
    border-bottom: 1px solid #fecaca;
    color: #b91c1c;
    padding: 16px 32px;
    font-size: 0.95rem;
}

/* --- Body Form --- */
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
    color: #374151;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.text-danger { color: #ef4444; }

/* --- Input Control --- */
.srvform-control {
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

.srvform-control:focus {
    outline: none;
    border-color: #4f46e5;
    background-color: #ffffff;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
}

.srvform-control::placeholder { color: #9ca3af; }

/* --- Grid 2 Kolom (Harga & Hari) --- */
.srvform-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* --- Error Messages (Validasi) --- */
.srvform-control.is-invalid {
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

/* --- Action Buttons --- */
.srvform-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 16px;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #f3f4f6;
}

/* Gunakan class tombol .btn, .btn-primary, .btn-outline dari file CSS sebelumnya */
.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    border: none;
    font-size: 1rem;
}
.btn-primary { background-color: #4f46e5; color: white; }
.btn-primary:hover { background-color: #4338ca; }
.btn-outline { background-color: transparent; border: 2px solid #e5e7eb; color: #4b5563; }
.btn-outline:hover { background-color: #f3f4f6; }

/* --- Responsif (Mobile) --- */
@media (max-width: 640px) {
    .srvform-row {
        grid-template-columns: 1fr; /* Jadi 1 kolom bersusun ke bawah di HP */
        gap: 0;
    }
    
    .srvform-actions {
        flex-direction: column-reverse; /* Tombol Batal di bawah */
    }
    
    .srvform-actions .btn {
        width: 100%;
        text-align: center;
    }
}
</style>
<div class="srvform-wrapper">

    <div class="srvform-card">
        <div class="srvform-header">
            <h1>Buat Jasa Baru</h1>
            <p>Tawarkan keahlianmu dan mulai terima pesanan dari klien.</p>
        </div>

        {{-- Menampilkan alert error global (Opsional jika form gagal) --}}
        @if ($errors->any())
            <div class="srvform-alert-danger">
                <strong>Oops!</strong> Ada beberapa data yang belum sesuai. Silakan periksa kembali form di bawah.
            </div>
        @endif

            <form
                method="POST"
                action="/services"
                enctype="multipart/form-data"
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

        <div class="form-group">
            <label for="thumbnail">Thumbnail</label>

            <input
                type="file"
                id="thumbnail"
                name="thumbnail"
                accept="image/jpeg,image/png,image/webp"
            >

            <small>
                Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
            </small>
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