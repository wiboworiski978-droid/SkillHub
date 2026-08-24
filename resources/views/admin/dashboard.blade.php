@extends('layouts.app')

@section('title', 'Dashboard Admin - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE DASHBOARD ADMIN
   ========================================= */

.admin-container {
    max-width: 1200px;
    margin: 40px auto 80px auto;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- Header Admin --- */
.admin-header {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-radius: 16px;
    padding: 40px;
    color: #ffffff;
    margin-bottom: 40px;
    box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.3);
}

.admin-header h1 {
    margin: 0 0 10px 0;
    font-size: 2.2rem;
    font-weight: 700;
}

.admin-header p {
    margin: 0;
    color: #94a3b8;
    font-size: 1.05rem;
}

/* --- Judul Section --- */
.admin-section-title {
    margin-bottom: 20px;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 12px;
}

.admin-section-title h2 {
    font-size: 1.35rem;
    color: #1e293b;
    margin: 0;
    font-weight: 700;
}

.mt-40 {
    margin-top: 40px;
}

/* --- Grid Statistik --- */
.dash-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
}

.dash-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    transition: transform 0.2s;
}

.dash-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
}

/* Ikon di Statistik */
.dash-icon {
    font-size: 2.2rem;
    padding: 16px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Info Text */
.dash-info h3 {
    margin: 0 0 4px 0;
    font-size: 0.9rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
}

.dash-number {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 800;
    color: #0f172a;
}

/* Variasi Warna Kartu Statistik (Background Icon tipis) */
.card-blue .dash-icon { background-color: #e0f2fe; color: #0284c7; }
.card-indigo .dash-icon { background-color: #e0e7ff; color: #4338ca; }
.card-purple .dash-icon { background-color: #f3e8ff; color: #7e22ce; }
.card-green .dash-icon { background-color: #dcfce7; color: #15803d; }
.card-yellow .dash-icon { background-color: #fef9c3; color: #a16207; }
.card-teal .dash-icon { background-color: #ccfbf1; color: #0f766e; }
.card-red .dash-icon { background-color: #fee2e2; color: #b91c1c; }
.card-gray .dash-icon { background-color: #f1f5f9; color: #475569; }

/* --- Grid Menu Manajemen --- */
.admin-menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.admin-menu-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
}

.admin-menu-card:hover {
    border-color: #4f46e5;
    background-color: #f8fafc;
    box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.1);
    transform: translateY(-2px);
}

.menu-icon {
    font-size: 2rem;
    background-color: #f1f5f9;
    padding: 12px;
    border-radius: 10px;
}

.admin-menu-card:hover .menu-icon {
    background-color: #e0e7ff; /* Berubah biru saat dihover */
}

.menu-text h3 {
    margin: 0 0 6px 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
}

.admin-menu-card:hover .menu-text h3 {
    color: #4f46e5;
}

.menu-text p {
    margin: 0;
    font-size: 0.9rem;
    color: #64748b;
    line-height: 1.4;
}

/* --- Responsif --- */
@media (max-width: 768px) {
    .dash-stats-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 kolom di tablet */
    }
}

@media (max-width: 480px) {
    .admin-header {
        padding: 24px 20px;
    }
    
    .admin-header h1 {
        font-size: 1.8rem;
    }

    .dash-stats-grid {
        grid-template-columns: 1fr; /* 1 kolom di HP */
    }
    
    .admin-menu-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<div class="admin-container">

    {{-- HEADER ADMIN --}}
    <div class="admin-header">
        <div class="admin-header-text">
            <h1>Dashboard Admin</h1>
            <p>Selamat datang, <strong>{{ session('username') ?? 'Admin' }}</strong>. Pantau dan kelola seluruh aktivitas SkillHub dari sini.</p>
        </div>
    </div>

    {{-- SECTION: STATISTIK --}}
    <div class="admin-section-title">
        <h2>📊 Ringkasan Statistik</h2>
    </div>

    <div class="dash-stats-grid">
        <div class="dash-card card-blue">
            <div class="dash-icon">👥</div>
            <div class="dash-info">
                <h3>Total User</h3>
                <p class="dash-number">{{ $totalUser ?? 0 }}</p>
            </div>
        </div>

        <div class="dash-card card-indigo">
            <div class="dash-icon">🛠</div>
            <div class="dash-info">
                <h3>Total Jasa</h3>
                <p class="dash-number">{{ $totalServices ?? 0 }}</p>
            </div>
        </div>

        <div class="dash-card card-purple">
            <div class="dash-icon">📂</div>
            <div class="dash-info">
                <h3>Kategori</h3>
                <p class="dash-number">{{ $totalCategories ?? 0 }}</p>
            </div>
        </div>

        <div class="dash-card card-green">
            <div class="dash-icon">📦</div>
            <div class="dash-info">
                <h3>Total Order</h3>
                <p class="dash-number">{{ $totalOrders ?? 0 }}</p>
            </div>
        </div>

        <div class="dash-card card-yellow">
            <div class="dash-icon">⏳</div>
            <div class="dash-info">
                <h3>Order Pending</h3>
                <p class="dash-number">{{ $pendingOrders ?? 0 }}</p>
            </div>
        </div>

        <div class="dash-card card-teal">
            <div class="dash-icon">✅</div>
            <div class="dash-info">
                <h3>Order Selesai</h3>
                <p class="dash-number">{{ $completeOrders ?? 0 }}</p>
            </div>
        </div>

        <div class="dash-card card-red">
            <div class="dash-icon">❌</div>
            <div class="dash-info">
                <h3>Order Ditolak</h3>
                <p class="dash-number">{{ $rejectedOrders ?? 0 }}</p>
            </div>
        </div>

        <div class="dash-card card-gray">
            <div class="dash-icon">⏸️</div>
            <div class="dash-info">
                <h3>Jasa Inactive</h3>
                <p class="dash-number">{{ $inactiveServices ?? 0 }}</p>
            </div>
        </div>
    </div>

    {{-- SECTION: MENU MANAJEMEN --}}
    <div class="admin-section-title mt-40">
        <h2>⚙️ Menu Manajemen</h2>
    </div>

    <div class="admin-menu-grid">
        <a href="/admin/users" class="admin-menu-card">
            <div class="menu-icon">👥</div>
            <div class="menu-text">
                <h3>Kelola User</h3>
                <p>Lihat, edit, atau blokir akun pengguna.</p>
            </div>
        </a>

        <a href="/admin/services" class="admin-menu-card">
            <div class="menu-icon">🛠</div>
            <div class="menu-text">
                <h3>Kelola Jasa</h3>
                <p>Pantau dan kelola jasa yang ditawarkan.</p>
            </div>
        </a>

        <a href="{{ url('/categories') }}" class="admin-menu-card">
            <div class="menu-icon">📂</div>
            <div class="menu-text">
                <h3>Kelola Kategori</h3>
                <p>Tambah, edit, dan hapus kategori jasa.</p>
            </div>
        </a>

        <a href="#" class="admin-menu-card">
            <div class="menu-icon">📦</div>
            <div class="menu-text">
                <h3>Kelola Order</h3>
                <p>Pantau semua transaksi yang berlangsung.</p>
            </div>
        </a>
    </div>

</div>
@endsection