<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - SkillHub')</title>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body style="background-color: #f8fafc; margin: 0; font-family: 'Inter', sans-serif;">

    {{-- NAVBAR ADMIN (Clean & Serasi) --}}
    <nav class="admin-topbar">
        <div class="topbar-container">
            
            {{-- Kiri: Brand --}}
            <a href="{{ url('/admin/dashboard') }}" class="topbar-brand">
                <div class="brand-logo">S</div>
                SkillHub <span class="brand-badge">Admin Panel</span>
            </a>
            
            {{-- Kanan: Aksi & Profil --}}
            <div class="topbar-actions">
                
                {{-- Link ke web publik --}}
                <a href="{{ url('/') }}" target="_blank" class="topbar-link">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    <span class="hide-on-mobile">Lihat Web</span>
                </a>

                <div class="topbar-divider"></div>

                {{-- Info Profil Singkat --}}
                <div class="topbar-user">
                    <div class="user-avatar-mini">
                        {{ strtoupper(substr(session('username') ?? 'A', 0, 1)) }}
                    </div>
                    <span class="user-name-mini hide-on-mobile">{{ session('username') ?? 'Admin' }}</span>
                </div>

                {{-- Tombol Logout Ikonik --}}
                <form action="{{ url('/logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="topbar-logout" title="Logout dari Admin">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>

            </div>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main>
        @yield('content')
    </main>

</body>
</html>