@extends('layouts.app')

@section('title', 'Login - SkillHub')

@section('content')

<div class="auth-container">

    <div class="auth-card">

        <h1>Login SkillHub</h1>

        <p>Masuk ke akun SkillHub kamu</p>

        <form method="POST" action="/login">

            @csrf

            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Masukkan username"
                    value="{{ old('username') }}"
                    required
                >

            </div>

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>

            @if ($errors->any())

                <div class="error-message">

                    @foreach ($errors->all() as $error)

                        <p>{{ $error }}</p>

                    @endforeach

                </div>

            @endif

            <button type="submit" class="btn login-btn">
                Login
            </button>

        </form>

        <p class="auth-link">

            Belum punya akun?

            <a href="/register">
                Register
            </a>

        </p>

    </div>

</div>

@endsection