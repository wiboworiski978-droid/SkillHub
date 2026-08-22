@extends('layouts.app')

@section('title', 'Buat Jasa - SkillHub')

@section('content')

<div class="service-detail">

    <h1>Buat Jasa</h1>

    @if ($errors->any())

        <div class="error-message">

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach

        </div>

    @endif

    <form method="POST" action="/services">

        @csrf

        <div class="form-group">

            <label for="title">
                Judul Jasa
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title') }}"
                placeholder="Contoh: Jasa Membuat Website"
                required
            >

        </div>

        <div class="form-group">

            <label for="category_id">
                Kategori
            </label>

            <select
                id="category_id"
                name="category_id"
                required
            >

                <option value="">
                    -- Pilih Kategori --
                </option>

                @foreach ($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label for="description">
                Deskripsi
            </label>

            <textarea
                id="description"
                name="description"
                rows="5"
                placeholder="Jelaskan jasa yang kamu tawarkan..."
                required
            >{{ old('description') }}</textarea>

        </div>

        <div class="form-group">

            <label for="price">
                Harga
            </label>

            <input
                type="number"
                id="price"
                name="price"
                value="{{ old('price') }}"
                min="0"
                placeholder="50000"
                required
            >

        </div>

        <div class="form-group">

            <label for="estimated_days">
                Estimasi Pengerjaan (hari)
            </label>

            <input
                type="number"
                id="estimated_days"
                name="estimated_days"
                value="{{ old('estimated_days') }}"
                min="1"
                placeholder="3"
                required
            >

        </div>

        <button type="submit" class="btn">
            Buat Jasa
        </button>

        <a href="/my-services" class="btn">
            Batal
        </a>

    </form>

</div>

@endsection