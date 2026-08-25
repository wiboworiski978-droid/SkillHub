@extends('layouts.admin')

@section('title', 'Kelola Kategori - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE KELOLA KATEGORI (CLEAN SAAS)
   ========================================= */

.cat-container {
    max-width: 1100px;
    margin: 40px auto 80px auto;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- Header Kategori --- */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    flex-wrap: wrap; /* Mencegah bentrok di layar sempit */
    gap: 20px;
}

.header-text h1 {
    font-size: 2rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 8px 0;
    letter-spacing: -0.02em;
}

.header-text p {
    color: #64748b;
    margin: 0;
    font-size: 1.05rem;
}

/* --- Grid Card Kategori --- */
.cat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

.cat-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.cat-card:hover {
    transform: translateY(-4px); /* Efek melayang tipis saat di-hover */
    box-shadow: 0 12px 20px -5px rgba(15, 23, 42, 0.08);
    border-color: #cbd5e1;
}

/* --- Konten Info Card --- */
.cat-info {
    flex-grow: 1;
    margin-bottom: 24px;
}

.cat-badge {
    display: inline-block;
    background-color: #e0e7ff;
    color: #4338ca;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 12px;
}

.cat-info h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
}

/* --- Area Tombol Aksi (Edit & Hapus) --- */
.cat-actions {
    display: flex;
    gap: 12px;
    border-top: 1px solid #f1f5f9;
    padding-top: 20px;
}

.cat-form-action {
    margin: 0;
    flex: 1; /* Memastikan form mengambil sisa ruang yang seimbang */
}

.cat-btn-action {
    display: inline-block;
    width: 100%;
    text-align: center;
    box-sizing: border-box;
    padding: 10px 16px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
    border: 1px solid transparent;
}

/* Varian Tombol Edit (Outline Soft Blue) */
.cat-actions .btn-outline {
    background-color: #f8fafc;
    color: #4f46e5;
    border-color: #e2e8f0;
    flex: 1; /* Keseimbangan lebar tombol */
}

.cat-actions .btn-outline:hover {
    background-color: #e0e7ff;
    border-color: #c7d2fe;
}

/* Varian Tombol Hapus (Soft Red) */
.cat-actions .btn-danger {
    background-color: #fff1f2;
    color: #e11d48;
    border-color: #ffe4e6;
}

.cat-actions .btn-danger:hover {
    background-color: #ffe4e6;
    border-color: #fecdd3;
    color: #be123c;
}

/* --- Tampilan Kosong (Empty State) --- */
.empty-state {
    grid-column: 1 / -1; /* Memaksa kotak berada di tengah memenuhi baris */
    background-color: #ffffff;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    text-align: center;
    padding: 60px 20px;
}

.empty-state h3 {
    color: #0f172a;
    font-size: 1.25rem;
    margin: 0 0 8px 0;
}

.empty-state p {
    color: #64748b;
    margin: 0 0 24px 0;
}

.mt-3 {
    margin-top: 16px;
}

/* --- Responsif HP --- */
@media (max-width: 640px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }
    
    .header-action {
        width: 100%;
    }
    
    .header-action .btn {
        display: block;
        width: 100%;
        text-align: center;
    }
}
</style>
<div class="cat-container">

    {{-- Navigasi Kembali ke Dashboard Admin --}}
    <div style="margin-bottom: 24px;">
        <a href="{{ url('/admin/dashboard') }}" class="back-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success">
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- Header Section --}}
    <div class="page-header">
        <div class="header-text">
            <h1>Kelola Kategori</h1>
            <p>Atur daftar kategori yang tersedia untuk pengelompokan jasa.</p>
        </div>
        <div class="header-action">
            <a href="{{ url('/categories/create') }}" class="btn btn-primary">
                + Tambah Kategori
            </a>
        </div>
    </div>

    {{-- Daftar Kategori (Grid) --}}
    <div class="cat-grid">
        @forelse ($categories as $category)
            <div class="cat-card">
                
                {{-- Info Kategori --}}
                <div class="cat-info">
                    <span class="cat-badge">Kategori Jasa</span>
                    <h3>{{ $category->name }}</h3>
                </div>

                {{-- Tombol Aksi (Edit & Hapus) --}}
                <div class="cat-actions">
                    <a href="{{ url('/categories/' . $category->id . '/edit') }}" class="btn btn-outline cat-btn-action">
                        Edit
                    </a>

                    <form
                        method="POST"
                        action="{{ url('/categories/' . $category->id) }}"
                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                        class="cat-form-action"
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger cat-btn-action">
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        @empty
            
            {{-- Tampilan Saat Kategori Masih Kosong --}}
            <div class="empty-state">
                <div class="empty-icon">📂</div>
                <h3>Belum Ada Kategori</h3>
                <p>Belum ada kategori yang ditambahkan. Silakan buat kategori baru terlebih dahulu.</p>
                <a href="{{ url('/categories/create') }}" class="btn btn-primary mt-3">
                    + Tambah Kategori Pertama
                </a>
            </div>

        @endforelse
    </div>

</div>
@endsection