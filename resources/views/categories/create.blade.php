@extends('layouts.app')

@section('title', 'Tambah Kategori - SkillHub')

@section('content')

<div class="service-detail">

    <h1>Tambah Kategori</h1>

    @if ($errors->any())

        <div class="error-message">

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach

        </div>

    @endif

    <form method="POST" action="/categories">

        @csrf

        <div class="form-group">

            <label for="name">
                Nama Kategori
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Contoh: Desain Grafis"
                required
            >

        </div>

        <button type="submit" class="btn">
            Simpan Kategori
        </button>

    </form>

    <br>

    <a href="/categories" class="btn">
        Kembali
    </a>

</div>

@endsection