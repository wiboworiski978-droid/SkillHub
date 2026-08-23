@extends('layouts.app')

@section('title', 'Edit Kategori - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE KHUSUS FORMULIR (KATEGORI & JASA)
   ========================================= */

/* --- Wrapper Form --- */
.srvform-wrapper {
    max-width: 750px;
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

.text-danger { 
    color: #ef4444; 
}

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

.srvform-control::placeholder { 
    color: #9ca3af; 
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

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    border: none;
    font-size: 1rem;
    transition: all 0.2s ease;
}
.btn-primary { 
    background-color: #4f46e5; 
    color: white; 
}
.btn-primary:hover { 
    background-color: #4338ca; 
}
.btn-outline { 
    background-color: transparent; 
    border: 2px solid #e5e7eb; 
    color: #4b5563; 
}
.btn-outline:hover { 
    background-color: #f3f4f6; 
}

/* --- Responsif (Mobile) --- */
@media (max-width: 640px) {
    .srvform-actions {
        flex-direction: column-reverse;
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
            <h1>Edit Kategori</h1>
            <p>Perbarui nama kategori untuk mengelompokkan jasa dengan lebih baik.</p>
        </div>

        {{-- Global Error Handler --}}
        @if ($errors->any())
            <div class="srvform-alert-danger">
                <strong>Oops!</strong> Gagal memperbarui data. Silakan periksa kembali form di bawah.
            </div>
        @endif

        <form method="POST" action="{{ url('/categories/' . $category->id) }}" class="srvform-body">
            @csrf
            @method('PUT')

            {{-- Input: Nama Kategori --}}
            <div class="srvform-group">
                <label for="name" class="srvform-label">Nama Kategori <span class="text-danger">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="srvform-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $category->name) }}"
                    required
                    autofocus
                >
                @error('name')
                    <span class="srvform-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="srvform-actions">
                <a href="{{ url('/categories') }}" class="btn btn-outline">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection