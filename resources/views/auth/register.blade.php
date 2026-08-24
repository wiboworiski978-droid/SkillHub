@extends('layouts.auth')

@section('title', 'Register - SkillHub')

@section('content')
<style>
    /* =========================================
   STYLE UNTUK HALAMAN AUTH (LOGIN & REGISTER)
   ========================================= */

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    background-color: #f3f4f6;
    color: #333;
}

/* --- Layout Container --- */
.auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

/* --- Card Auth (Login & Register) --- */
.auth-card {
    background-color: #ffffff;
    width: 100%;
    max-width: 420px;
    padding: 40px 32px;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
}

/* --- Tipografi Header --- */
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
    width: 100%;
}

.form-group input:focus {
    border-color: #4f46e5;
    background-color: #ffffff;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
}

.form-group input::placeholder {
    color: #9ca3af;
}

/* --- Tombol Utama (Login/Register) --- */
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
    background-color: #4f46e5;
    color: #ffffff;
    margin-top: 8px;
}

.login-btn:hover {
    background-color: #4338ca;
    transform: translateY(-1px);
}

.login-btn:active {
    transform: translateY(1px);
}

/* --- Link Beralih (Login <-> Register) --- */
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
    margin-bottom: 20px;
    font-size: 0.9rem;
}

.error-message ul {
    margin: 0;
    padding-left: 20px;
}

input.is-invalid {
    border-color: #ef4444 !important;
    background-color: #fef2f2 !important;
}

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
        <h1>Register SkillHub</h1>
        <p>Buat akun SkillHub kamu</p>

        {{-- Menggunakan route helper untuk action form --}}
        <form method="POST" action="{{ url('/register') }}">
            @csrf

            {{-- Pesan Error Global --}}
            @if ($errors->any())
                <div class="error-message">
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
                    autocomplete="new-password"
                    class="@error('password') is-invalid @enderror"
                >
                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                    autocomplete="new-password"
                >
            </div>

            <button type="submit" class="btn login-btn">
                Register
            </button>
        </form>

        <p class="auth-link">
            Sudah punya akun? 
            <a href="{{ url('/login') }}">Login</a>
        </p>
    </div>
</div>
@endsection