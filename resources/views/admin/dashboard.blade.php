@extends('layouts.admin')

@section('title', 'Dashboard Admin - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE DASHBOARD ADMIN (CLEAN & MODERN)
   ========================================= */

.admin-container {
    max-width: 1100px;
    margin: 40px auto 80px auto;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- 1. Welcome Card --- */
.admin-welcome-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-left: 6px solid #4f46e5; /* Aksen garis biru di kiri */
    border-radius: 12px;
    padding: 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    margin-bottom: 40px;
}

.welcome-text h1 {
    font-size: 1.8rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 8px 0;
}

.welcome-text p {
    margin: 0;
    color: #64748b;
    font-size: 1rem;
}

.welcome-date span {
    background-color: #f1f5f9;
    color: #475569;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

/* --- 2. Judul Section --- */
.admin-section-header {
    margin-bottom: 24px;
}

.admin-section-header h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.mt-40 {
    margin-top: 40px;
}

/* --- 3. Grid & Card Statistik --- */
.admin-grid-stats {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.stat-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
}

/* Lingkaran Ikon Pastel */
.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.icon-blue { background-color: #e0f2fe; color: #0284c7; }
.icon-indigo { background-color: #e0e7ff; color: #4338ca; }
.icon-purple { background-color: #f3e8ff; color: #7e22ce; }
.icon-green { background-color: #dcfce7; color: #15803d; }
.icon-yellow { background-color: #fef9c3; color: #a16207; }
.icon-teal { background-color: #ccfbf1; color: #0f766e; }

.stat-details {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
}

/* --- 4. Grid & Card Menu Manajemen --- */
.admin-grid-menu {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
}

.menu-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    text-decoration: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    transition: all 0.2s ease;
}

.menu-card:hover {
    border-color: #4f46e5;
    background-color: #f8fafc;
    box-shadow: 0 8px 12px -3px rgba(79, 70, 229, 0.1);
}

.menu-card-icon {
    font-size: 1.75rem;
    background-color: #f1f5f9;
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s ease;
}

.menu-card:hover .menu-card-icon {
    background-color: #e0e7ff; /* Berubah ungu muda saat di-hover */
}

.menu-card-content {
    flex-grow: 1;
}

.menu-card-content h3 {
    margin: 0 0 4px 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    transition: color 0.2s;
}

.menu-card:hover .menu-card-content h3 {
    color: #4f46e5;
}

.menu-card-content p {
    margin: 0;
    font-size: 0.9rem;
    color: #64748b;
    line-height: 1.4;
}

.menu-card-arrow {
    font-size: 1.25rem;
    color: #cbd5e1;
    transition: color 0.2s, transform 0.2s;
}

.menu-card:hover .menu-card-arrow {
    color: #4f46e5;
    transform: translateX(4px); /* Efek panah bergeser sedikit */
}

/* --- Responsif (Mobile) --- */
@media (max-width: 768px) {
    .admin-welcome-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    .admin-grid-menu {
        grid-template-columns: 1fr;
    }
}
</style>
<div class="admin-container">

    {{-- WELCOME CARD (Lebih bersih dan elegan) --}}
    <div class="admin-welcome-card">
        <div class="welcome-text">
            <h1>Halo, {{ session('username') ?? 'Admin' }}! 👋</h1>
            <p>Ini adalah pusat kendali SkillHub. Pantau perkembangan pengguna, jasa, dan transaksi hari ini.</p>
        </div>
        <div class="welcome-date">
            <span>{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    {{-- SECTION: STATISTIK --}}
    <div class="admin-section-header">
        <h2>Ringkasan Platform</h2>
    </div>

    <div class="admin-grid-stats">
        {{-- Card Stat 1 --}}
        <div class="stat-card">
            <div class="stat-icon icon-blue">👥</div>
            <div class="stat-details">
                <span class="stat-label">Total User</span>
                <span class="stat-value">{{ $totalUser ?? 0 }}</span>
            </div>
        </div>

        {{-- Card Stat 2 --}}
        <div class="stat-card">
            <div class="stat-icon icon-indigo">🛠</div>
            <div class="stat-details">
                <span class="stat-label">Total Jasa</span>
                <span class="stat-value">{{ $totalServices ?? 0 }}</span>
            </div>
        </div>

        {{-- Card Stat 3 --}}
        <div class="stat-card">
            <div class="stat-icon icon-purple">📂</div>
            <div class="stat-details">
                <span class="stat-label">Kategori</span>
                <span class="stat-value">{{ $totalCategories ?? 0 }}</span>
            </div>
        </div>

        {{-- Card Stat 4 --}}
        <div class="stat-card">
            <div class="stat-icon icon-green">📦</div>
            <div class="stat-details">
                <span class="stat-label">Total Order</span>
                <span class="stat-value">{{ $totalOrders ?? 0 }}</span>
            </div>
        </div>

        {{-- Card Stat 5 --}}
        <div class="stat-card">
            <div class="stat-icon icon-yellow">⏳</div>
            <div class="stat-details">
                <span class="stat-label">Order Pending</span>
                <span class="stat-value">{{ $pendingOrders ?? 0 }}</span>
            </div>
        </div>

        {{-- Card Stat 6 --}}
        <div class="stat-card">
            <div class="stat-icon icon-teal">✅</div>
            <div class="stat-details">
                <span class="stat-label">Order Selesai</span>
                <span class="stat-value">{{ $completeOrders ?? 0 }}</span>
            </div>
        </div>
    </div>

    {{-- SECTION: MENU MANAJEMEN --}}
    <div class="admin-section-header mt-40">
        <h2>Menu Manajemen</h2>
    </div>

    <div class="admin-grid-menu">
        <a href="{{ url('/admin/users') }}" class="menu-card">
            <div class="menu-card-icon">👥</div>
            <div class="menu-card-content">
                <h3>Kelola User</h3>
                <p>Pantau dan atur hak akses pengguna terdaftar.</p>
            </div>
            <div class="menu-card-arrow">&rarr;</div>
        </a>

        <a href="{{ url('/admin/services') }}" class="menu-card">
            <div class="menu-card-icon">🛠</div>
            <div class="menu-card-content">
                <h3>Kelola Jasa</h3>
                <p>Moderasi seluruh layanan yang ditawarkan.</p>
            </div>
            <div class="menu-card-arrow">&rarr;</div>
        </a>

        <a href="{{ url('/categories') }}" class="menu-card">
            <div class="menu-card-icon">📂</div>
            <div class="menu-card-content">
                <h3>Kelola Kategori</h3>
                <p>Tambah atau ubah kategori jasa yang ada.</p>
            </div>
            <div class="menu-card-arrow">&rarr;</div>
        </a>

        <a href="{{ url('/admin/orders') }}" class="menu-card">
            <div class="menu-card-icon">📦</div>
            <div class="menu-card-content">
                <h3>Kelola Order</h3>
                <p>Lihat status dan riwayat transaksi proyek.</p>
            </div>
            <div class="menu-card-arrow">&rarr;</div>
        </a>
    </div>

</div>
@endsection