<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SkillHub')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<nav>

    <a href="/">
        SkillHub
    </a>

    <a href="/">
        Home
    </a>

    <a href="/services">
        Explore Jasa
    </a>

    <a href="/orders">
        Order Saya
    </a>

    <a href="/orders/incoming">
        Order Masuk
    </a>

    <a href="/profile">
        Profile
    </a>
    
    <a href="/orders/history">Riwayat Order</a>

    <form method="POST" action="/logout" style="display: inline;">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>

</nav>

<main>

    @yield('content')

</main>

</body>
</html>