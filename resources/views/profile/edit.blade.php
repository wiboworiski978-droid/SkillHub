@extends('layouts.app')

@section('title', 'Edit Profile - SkillHub')

@section('content')

<div class="service-detail">

    <h1>Edit Profile</h1>

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/profile/edit">

        @csrf
        @method('PUT')

        <div class="form-group">

            <label for="username">
                Username
            </label>

            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username', $user->username) }}"
                required
            >

        </div>

        <div class="form-group">

            <label for="bio">
                Bio
            </label>

            <textarea
                id="bio"
                name="bio"
                rows="5"
            >{{ old('bio', $user->bio) }}</textarea>

        </div>

        <div class="form-group">

            <label for="skill">
                Skill
            </label>

            <input
                type="text"
                id="skill"
                name="skill"
                value="{{ old('skill', $user->skill) }}"
            >

        </div>

        <div class="form-group">

            <label for="school">
                Sekolah
            </label>

            <input
                type="text"
                id="school"
                name="school"
                value="{{ old('school', $user->school) }}"
            >

        </div>

        <button type="submit" class="btn">
            Simpan Perubahan
        </button>

        <a href="/profile" class="btn">
            Batal
        </a>

    </form>

</div>

@endsection