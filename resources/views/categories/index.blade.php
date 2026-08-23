@extends('layouts.app')

@section('title', 'Kelola Kategori - SkillHub')

@section('content')

<div class="service-detail">

    <h1>Kelola Kategori</h1>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <br>

    <a href="/categories/create" class="btn">
        + Tambah Kategori
    </a>

    <hr>

    @if ($categories->count() > 0)

        @foreach ($categories as $category)

            <div class="service-card">

                <h3>{{ $category->name }}</h3>

                <a href="/categories/{{ $category->id }}/edit" class="btn">
                    Edit
                </a>

                <form
                    method="POST"
                    action="/categories/{{ $category->id }}"
                    style="display: inline;"
                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                >

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn">
                        Hapus
                    </button>

                </form>

            </div>

        @endforeach

    @else

        <p>Belum ada kategori.</p>

    @endif

</div>

@endsection