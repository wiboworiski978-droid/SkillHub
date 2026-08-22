@extends('layouts.app')

@section('title', 'Login - SkillHub')

@section('content')
<style>
    /* --- Reset Dasar --- */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    /* Font modern yang bersih */
    font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    background-color: #f3f4f6; /* Warna latar abu-abu sangat muda */
    color: #333;
}

/* --- Layout Container --- */
.auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh; /* Memenuhi tinggi layar penuh */
    padding: 20px;
}

/* --- Card Login --- */
.auth-card {
    background-color: #ffffff;
    width: 100%;
    max-width: 400px;
    padding: 40px 32px;
    border-radius: 16px; /* Sudut melengkung yang modern */
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); /* Bayangan halus */
}

/* --- Tipografi --- */
.auth-card h1 {
    text-align: center;
    font-size: 1.75rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
}

.auth-card > p {
    text-align: center;
    color: #6b7280;
    font-size: 0.95rem;
    margin-bottom: 28px;
}

/* --- Form Elements --- */
.form-group {
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.9rem;
    color: #374151;
}

.form-group input[type="text"],
.form-group input[type="password"] {
    padding: 12px 16px;
    border: 1.5px solid #d1d5db;
    border-radius: 8px;
    font-size: 1rem;
    color: #111827;
    background-color: #f9fafb;
    transition: all 0.2s ease-in-out;
    outline: none;
}

/* Efek saat input diklik/fokus */
.form-group input:focus {
    border-color: #4f46e5; /* Warna utama: Indigo */
    background-color: #ffffff;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
}

.form-group input::placeholder {
    color: #9ca3af;
}

/* --- Checkbox Remember Me --- */
.remember-me {
    flex-direction: row;
    align-items: center;
    margin-bottom: 24px;
}

.remember-me label {
    margin-bottom: 0;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #4b5563;
}

.remember-me input[type="checkbox"] {
    width: 16px;
    height: 16px;
    cursor: pointer;
    accent-color: #4f46e5;
}

/* --- Tombol Login --- */
.btn {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

.login-btn {
    background-color: #4f46e5; /* Warna utama */
    color: #ffffff;
}

.login-btn:hover {
    background-color: #4338ca; /* Lebih gelap saat di-hover */
    transform: translateY(-1px); /* Efek melayang sedikit */
}

.login-btn:active {
    transform: translateY(1px); /* Efek ditekan */
}

/* --- Link Register --- */
.auth-link {
    text-align: center;
    margin-top: 24px;
    font-size: 0.9rem;
    color: #6b7280;
}

.auth-link a {
    color: #4f46e5;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}

.auth-link a:hover {
    color: #3730a3;
    text-decoration: underline;
}

/* --- Pesan Error (Validasi Laravel) --- */
.error-message {
    background-color: #fef2f2;
    border: 1px solid #f87171;
    color: #b91c1c;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 24px;
    font-size: 0.9rem;
}

.error-message ul {
    margin: 0;
    padding-left: 20px;
}

/* Input saat error */
input.is-invalid {
    border-color: #ef4444 !important;
    background-color: #fef2f2 !important;
}

input.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15) !important;
}

/* Text error di bawah input */
.text-danger {
    color: #dc2626;
    margin-top: 6px;
    display: block;
}

.small {
    font-size: 0.8rem;
}
</style>
<div class="auth-container">
    <div class="auth-card">
        <h1>Login SkillHub</h1>
        <p>Masuk ke akun SkillHub kamu</p>

        <!-- {{-- Gunakan route helper alih-alih hardcode URL --}} -->
        <form method="POST" action="/login">
            @csrf

            <!-- {{-- Opsi 1: Menampilkan error secara global (bisa dipertahankan jika suka style ini) --}} -->
            @if ($errors->any())
                <div class="error-message alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Masukkan username" 
                    value="{{ old('username') }}" 
                    required 
                    autofocus
                    autocomplete="username"
                    class="@error('username') is-invalid @enderror"
                >
                <!-- {{-- Opsi 2: Menampilkan pesan error spesifik di bawah input (Direkomendasikan di Laravel) --}} -->
                @error('username')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Masukkan password" 
                    required 
                    autocomplete="current-password"
                    class="@error('password') is-invalid @enderror"
                >
                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- {{-- Tambahan opsional: Fitur Remember Me --}} -->
            <div class="form-group remember-me">
                <label>
                    <input type="checkbox" name="remember"> Ingat Saya
                </label>
            </div>

            <button type="submit" class="btn login-btn">
                Login
            </button>
        </form>

        <p class="auth-link">
            Belum punya akun? 
            <a href="/register">Register</a>
        </p>
    </div>
</div>
@endsection