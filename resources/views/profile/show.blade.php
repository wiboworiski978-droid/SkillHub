@extends('layouts.app')

@section('title', 'Profile - SkillHub')

@section('content')
<style>
    /* --- Profile Container --- */
.profile-container {
    max-width: 700px; /* Dibuat lebih sempit agar fokus di tengah layar */
    margin: 40px auto;
    padding: 0 20px;
}

.profile-header-title h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 24px;
    text-align: center;
}

/* --- Profile Card --- */
.profile-card {
    background-color: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    border: 1px solid #f3f4f6;
}

/* --- Profile Header (Avatar & Nama) --- */
.profile-header {
    display: flex;
    align-items: center;
    gap: 24px;
    padding: 32px;
    border-bottom: 1px solid #f3f4f6;
    background-color: #ffffff;
}

.avatar-circle {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    color: #ffffff;
    font-size: 2.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
}

.profile-title h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 6px;
}

.role-badge {
    display: inline-block;
    background-color: #e0e7ff; /* Latar biru muda */
    color: #4338ca; /* Teks biru tua */
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

/* --- Profile Body (Data Detail) --- */
.profile-body {
    padding: 32px;
    display: flex;
    flex-direction: column;
    gap: 24px;
    background-color: #f9fafb; /* Latar sedikit abu-abu untuk bedakan konten */
}

.info-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.info-value {
    font-size: 1rem;
    color: #111827;
    line-height: 1.6;
    background-color: #ffffff;
    padding: 14px 16px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

/* Style khusus jika data belum diisi */
.info-value.empty {
    color: #9ca3af;
    font-style: italic;
    background-color: transparent;
    border-color: transparent;
    padding-left: 0;
}

/* --- Profile Footer --- */
.profile-footer {
    padding: 24px 32px;
    background-color: #ffffff;
    border-top: 1px solid #f3f4f6;
    display: flex;
    justify-content: flex-end; /* Memposisikan tombol ke kanan */
}

.profile-footer .btn {
    padding: 12px 24px;
    min-width: 150px;
}
</style>
<div class="profile-container">
    
    <div class="profile-header-title">
        <h1>Profile Saya</h1>
    </div>

    <div class="profile-card">
        {{-- Bagian Atas: Avatar & Nama --}}
        <div class="profile-header">
            <div class="avatar-circle">
                {{-- Mengambil huruf pertama dari username sebagai avatar --}}
                {{ strtoupper(substr($user->username, 0, 1)) }}
            </div>
            <div class="profile-title">
                <h2>{{ $user->username }}</h2>
                {{-- Membuat huruf depan role jadi kapital, misal: 'admin' jadi 'Admin' --}}
                <span class="role-badge">{{ ucfirst($user->role) }}</span>
            </div>
        </div>

        {{-- Bagian Tengah: Detail Informasi --}}
        <div class="profile-body">
            <div class="info-group">
                <span class="info-label">Bio</span>
                @if($user->bio)
                    <p class="info-value">{{ $user->bio }}</p>
                @else
                    <p class="info-value empty">Belum diisi</p>
                @endif
            </div>

            <div class="info-group">
                <span class="info-label">Skill Utama</span>
                @if($user->skill)
                    <p class="info-value">{{ $user->skill }}</p>
                @else
                    <p class="info-value empty">Belum diisi</p>
                @endif
            </div>

            <div class="info-group">
                <span class="info-label">Sekolah / Instansi</span>
                @if($user->school)
                    <p class="info-value">{{ $user->school }}</p>
                @else
                    <p class="info-value empty">Belum diisi</p>
                @endif
            </div>
        </div>

        {{-- Bagian Bawah: Tombol Aksi --}}
        <div class="profile-footer">
            {{-- Gunakan route helper. Asumsi nama route: 'profile.edit' --}}
            <a href="/profile/edit" class="btn btn-primary">
                Edit Profile
            </a>
        </div>
    </div>

</div>
@endsection