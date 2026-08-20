<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SkillHub')</title>

    <link rel="stylesheet" href="{{ asset ('css/style.css')}}">
</head>
<body>
<nav>

    <a href="/">SkillHub</a>

    <a href="/">Home</a>

    <a href="/services">Explore Jasa</a>

    <a href="/orders">Order Saya</a>

</nav>

<main>

    @yield('content')

</main>
</body>
</html>