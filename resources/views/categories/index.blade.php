@extends('layouts.app')

@section('title', 'Kelola Kategori - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE KELOLA KATEGORI (DISEMPURNAKAN)
   ========================================= */

.cat-container {
    max-width: 1100px;
    margin: 40px auto 80px auto;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- Grid Daftar Kategori --- */
.cat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

/* --- Card Kategori Presisi --- */
.cat-card {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.cat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
}

.cat-badge {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: #4338ca;
    background-color: #e0e7ff;
    padding: 4px 10px;
    border-radius: 20px;
    margin-bottom: 12px;
    letter-spacing: 0.03em;
}

.cat-info h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 24px 0;
    word-break: break-word;
    line-height: 1.4;
}

/* --- Area Tombol Aksi Sejajar --- */
.cat-actions {
    display: flex;
    gap: 12px;
    padding-top: 16px;
    border-top: 1px solid #f3f4f6;
    align-items: center;
}

.cat-form-action {
    flex: 1;
    margin: 0;
}

.cat-btn-action {
    width: 100%;
    padding: 10px 16px !important;
    font-size: 0.9rem !important;
    font-weight: 600;
    text-align: center;
    border-radius: 8px;
    display: inline-block;
    box-sizing: border-box;
}

/* Tombol Bahaya (Hapus) yang Konsisten */
.btn-danger {
    background-color: #ef4444;
    color: #ffffff;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-danger:hover {
    background-color: #dc2626;
}

/* Memperbaiki jarak tombol Outline agar sama tinggi */
.cat-actions .btn-outline {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
<div class="cat-container">

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
                <div class="cat-info">
                    <span class="cat-badge">Kategori Jasa</span>
                    <h3>{{ $category->name }}</h3>
                </div>

                {{-- Tombol Aksi Sejajar & Rapi --}}
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