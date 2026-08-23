@extends('layouts.app')

@section('title', 'Edit Kategori - SkillHub')

@section('content')

<div class="service-detail">

    <h1>Edit Kategori</h1>

    @if ($errors->any())

        <div class="error-message">

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach

        </div>

    @endif

    <form
        method="POST"
        action="/categories/{{ $category->id }}"
    >

        @csrf
        @method('PUT')

        <div class="form-group">

            <label for="name">
                Nama Kategori
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $category->name) }}"
                required
            >

        </div>

        <button type="submit" class="btn">
            Update Kategori
        </button>

    </form>

    <br>

    <a href="/categories" class="btn">
        Kembali
    </a>

</div>

@endsection