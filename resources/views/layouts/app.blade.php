<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SkillHub')</title>

    <!-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> -->

    <style>
        /* =========================================
   STYLE GLOBAL & NAVBAR (LAYOUT UTAMA)
   ========================================= */

body {
    margin: 0;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    background-color: #f3f4f6;
    color: #111827;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* --- Navigasi Utama (Navbar) --- */
nav {
    background-color: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    padding: 0 32px;
    display: flex;
    align-items: center;
    gap: 8px;
    height: 70px;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    overflow-x: auto; /* Bisa digeser di HP jika menu terlalu panjang */
}

/* Sembunyikan scrollbar bawaan navbar di HP tapi tetap bisa digeser */
nav::-webkit-scrollbar {
    display: none;
}

/* --- Link di Navbar --- */
nav a {
    color: #4b5563;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 500;
    padding: 8px 14px;
    border-radius: 6px;
    transition: all 0.2s ease;
    white-space: nowrap;
}

nav a:hover {
    color: #4f46e5;
    background-color: #f3f4f6;
}

/* --- Brand / Logo SkillHub di Navbar --- */
nav a:first-child {
    font-size: 1.25rem;
    font-weight: 700;
    color: #4f46e5;
    margin-right: 16px;
    padding-left: 0;
    background: transparent !important;
}

nav a:first-child:hover {
    color: #4338ca;
}

/* --- Tombol Logout di Navbar --- */
nav form {
    margin-left: auto; /* Mendorong tombol logout paling kanan */
}

nav button[type="submit"] {
    background-color: #f3f4f6;
    color: #ef4444;
    border: 1px solid #fecaca;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

nav button[type="submit"]:hover {
    background-color: #fee2e2;
    border-color: #ef4444;
}

/* --- Main Content Area --- */
main {
    flex-grow: 1; /* Memastikan footer/bawah halaman memenuhi layar */
}
    </style>
</head>

<body>

<nav>
    <!-- Brand / Logo -->
    <a href="/">SkillHub</a>

    <!-- Menu Utama -->
    <a href="/">Home</a>
    <a href="/services">Explore Jasa</a>

    <!-- Aktivitas Jasa & Transaksi Pengguna -->
    <a href="/my-services">Jasa Saya</a>
    <a href="/orders">Order Saya</a>
    <a href="/orders/incoming">Order Masuk</a>
    <a href="/orders/history">Riwayat Order</a>

    <a href="/profile">Profile</a>

    <!-- Menu Khusus Admin -->
    @if (session('role') === 'admin')
        <a href="/categories">Kelola Kategori</a>
    @endif

    <!-- Tombol Logout (Didorong ke paling kanan dengan CSS flexbox margin-left: auto) -->
    <form method="POST" action="/logout" style="display: inline;">
        @csrf
        <button type="submit">Logout</button>
    </form>
</nav>

<main>

    @yield('content')

</main>

</body>
</html>