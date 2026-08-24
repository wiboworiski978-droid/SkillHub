<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkillHub')</title>
    
    {{-- Hubungkan ke file CSS utama kamu --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    {{-- (Opsional) Font Google --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    {{-- Tempat di mana form Login/Register akan dimunculkan --}}
    <main>
        @yield('content')
    </main>

</body>
</html>