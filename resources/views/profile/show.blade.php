@extends('layouts.app')

@section('title', 'Profile - SkillHub')

@section('content')

<div class="profile-container">

    <h1>Profile Saya</h1>

    <div class="profile-card">

        <h2>{{ $user->username }}</h2>

        <p>
            <strong>Role:</strong>
            {{ $user->role }}
        </p>

        <p>
            <strong>Bio:</strong>
            {{ $user->bio ?? 'Belum diisi' }}
        </p>

        <p>
            <strong>Skill:</strong>
            {{ $user->skill ?? 'Belum diisi' }}
        </p>

        <p>
            <strong>Sekolah:</strong>
            {{ $user->school ?? 'Belum diisi' }}
        </p>

        <a href="/profile/edit" class="btn">
            Edit Profile
        </a>

    </div>

</div>

@endsection