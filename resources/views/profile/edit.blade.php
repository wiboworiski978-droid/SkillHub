@extends('layouts.app')

@section('title', 'Edit Profile - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE KHUSUS FORMULIR (EDIT PROFILE, JASA, DLL)
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

/* --- Grid 2 Kolom (Skill & Sekolah) --- */
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
    .srvform-row {
        grid-template-columns: 1fr; /* Jadi 1 kolom bersusun ke bawah di HP */
        gap: 0;
    }

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
            <h1>Edit Profile</h1>
            <p>Lengkapi profilmu agar klien lebih percaya dengan keahlian yang kamu tawarkan.</p>
        </div>

        {{-- Global Error Handler --}}
        @if ($errors->any())
            <div class="srvform-alert-danger">
                <strong>Oops!</strong> Gagal menyimpan profil. Silakan periksa kembali isian form di bawah.
            </div>
        @endif

        <form method="POST" action="{{ url('/profile/edit') }}" class="srvform-body">
            @csrf
            @method('PUT')

            {{-- Input: Username --}}
            <div class="srvform-group">
                <label for="username" class="srvform-label">Username <span class="text-danger">*</span></label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="srvform-control @error('username') is-invalid @enderror"
                    value="{{ old('username', $user->username) }}"
                    required
                    autofocus
                >
                @error('username')
                    <span class="srvform-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input: Bio --}}
            <div class="srvform-group">
                <label for="bio" class="srvform-label">Bio Singkat</label>
                <textarea
                    id="bio"
                    name="bio"
                    class="srvform-control @error('bio') is-invalid @enderror"
                    rows="4"
                    placeholder="Ceritakan sedikit tentang pengalaman dan fokus jasamu..."
                >{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <span class="srvform-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Grid 2 Kolom untuk Skill & Sekolah --}}
            <div class="srvform-row">
                
                {{-- Input: Skill --}}
                <div class="srvform-group">
                    <label for="skill" class="srvform-label">Keahlian Utama (Skill)</label>
                    <input
                        type="text"
                        id="skill"
                        name="skill"
                        class="srvform-control @error('skill') is-invalid @enderror"
                        value="{{ old('skill', $user->skill) }}"
                        placeholder="Contoh: Web Developer, UI/UX"
                    >
                    @error('skill')
                        <span class="srvform-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Input: Sekolah --}}
                <div class="srvform-group">
                    <label for="school" class="srvform-label">Institusi / Universitas</label>
                    <input
                        type="text"
                        id="school"
                        name="school"
                        class="srvform-control @error('school') is-invalid @enderror"
                        value="{{ old('school', $user->school) }}"
                        placeholder="Contoh: Universitas Indonesia"
                    >
                    @error('school')
                        <span class="srvform-error-msg">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="srvform-actions">
                <a href="{{ url('/profile') }}" class="btn btn-outline">
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