@extends('layouts.app')

@section('title', 'Pesan Jasa - SkillHub')

@section('content')

<div class="auth-container">

    <div class="auth-card">

        <h1>Pesan Jasa</h1>

        <h2>{{ $service->title }}</h2>

        <p>
            Pemilik:
            {{ $service->user->username }}
        </p>

        <p>
            Harga:
            Rp {{ number_format($service->price, 0, ',', '.') }}
        </p>

        <form method="POST" action="#">

            @csrf

            <div class="form-group">

                <label for="requirements">
                    Kebutuhan
                </label>

                <textarea
                    id="requirements"
                    name="requirements"
                    rows="5"
                    required
                ></textarea>

            </div>

            <div class="form-group">

                <label for="deadline">
                    Deadline
                </label>

                <input
                    type="date"
                    id="deadline"
                    name="deadline"
                    required
                >

            </div>

            <div class="form-group">

                <label for="notes">
                    Catatan
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    rows="4"
                ></textarea>

            </div>

            <button type="submit" class="btn">
                Buat Order
            </button>

        </form>

    </div>

</div>

@endsection