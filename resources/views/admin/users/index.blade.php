@extends('layouts.app')

@section('title', 'Kelola User - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE ADMIN KELOLA USER (PREMIUM)
   ========================================= */

.admin-container {
    max-width: 1100px;
    margin: 40px auto 80px auto;
    padding: 0 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

/* --- Header --- */
.admin-page-header {
    margin-bottom: 32px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #64748b;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 16px;
    transition: color 0.2s;
}

.back-link:hover { color: #0f172a; }

.admin-page-header h1 {
    font-size: 2rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 8px 0;
    letter-spacing: -0.02em;
}

.admin-page-header p {
    color: #64748b;
    margin: 0;
    font-size: 1.05rem;
}

/* --- Premium Table Card --- */
.premium-table-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
    overflow: hidden;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
}

.premium-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

/* Header Tabel */
.premium-table th {
    background-color: #f8fafc;
    padding: 16px 24px;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    border-bottom: 1px solid #e2e8f0;
}

/* Isi Tabel */
.premium-table td {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    transition: background-color 0.2s;
}

.premium-table tbody tr:hover td {
    background-color: #f8fafc;
}

.premium-table tbody tr:last-child td {
    border-bottom: none;
}

/* --- Avatar & User Info --- */
.user-profile-cell {
    display: flex;
    align-items: center;
    gap: 16px;
}

.user-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    font-weight: 700;
    box-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.user-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 0.95rem;
}

.user-id {
    font-size: 0.8rem;
    color: #94a3b8;
}

/* --- Badges dengan Dot --- */
.premium-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.badge-admin { 
    background-color: #e0e7ff; 
    color: #3730a3; 
}
.badge-admin .badge-dot { background-color: #4f46e5; }

.badge-user { 
    background-color: #f1f5f9; 
    color: #475569; 
}
.badge-user .badge-dot { background-color: #94a3b8; }

/* --- Teks Utilitas --- */
.text-secondary { color: #475569; font-size: 0.95rem; }
.text-right { text-align: right !important; }
.text-muted-italic { color: #94a3b8; font-style: italic; font-size: 0.9rem; }

/* --- Tombol Aksi Hapus --- */
.btn-action-delete {
    background-color: transparent;
    color: #ef4444;
    border: 1px solid #fecaca;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-action-delete:hover {
    background-color: #fef2f2;
    border-color: #ef4444;
}

/* --- Responsif HP --- */
@media (max-width: 640px) {
    .premium-table-card { border-radius: 0; border-left: none; border-right: none; }
    .admin-page-header h1 { font-size: 1.7rem; }
}
</style>
<div class="admin-container">

    {{-- Header Admin Modern --}}
    <div class="admin-page-header">
        <div class="header-content">
            <a href="{{ url('/admin/dashboard') }}" class="back-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
            <h1>Kelola User</h1>
            <p>Kelola seluruh akun pengguna, hak akses, dan status mereka di SkillHub.</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert alert-success">
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- Card Tabel Modern --}}
    <div class="premium-table-card">
        <div class="table-responsive">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Role Akses</th>
                        <th>Instansi / Sekolah</th>
                        <th>Tanggal Gabung</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            {{-- Kolom Avatar + Nama (Sangat Elegan) --}}
                            <td>
                                <div class="user-profile-cell">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->username, 0, 1)) }}
                                    </div>
                                    <div class="user-details">
                                        <span class="user-name">{{ $user->username }}</span>
                                        <span class="user-id">User ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </td>
                            
                            {{-- Kolom Role --}}
                            <td>
                                <span class="premium-badge {{ strtolower($user->role) === 'admin' ? 'badge-admin' : 'badge-user' }}">
                                    <span class="badge-dot"></span>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            
                            {{-- Kolom Sekolah --}}
                            <td>
                                <span class="text-secondary">{{ $user->school ?? 'Belum diisi' }}</span>
                            </td>
                            
                            {{-- Kolom Tanggal --}}
                            <td>
                                <span class="text-secondary">{{ $user->created_at?->format('d M Y') }}</span>
                            </td>
                            
                            {{-- Kolom Aksi --}}
                            <td class="text-right">
                                @if ($user->id !== session('user_id'))
                                    <form action="{{ url('/admin/users/' . $user->id . '/delete') }}" method="POST" onsubmit="return confirm('Hapus user ini secara permanen?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-delete">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted-italic">Anda (Admin)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">👥</div>
                                    <h3>Belum ada pengguna</h3>
                                    <p>Saat ini belum ada pengguna yang mendaftar ke aplikasi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection