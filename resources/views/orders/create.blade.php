@extends('layouts.app')

@section('title', 'Pesan Jasa - SkillHub')

@section('content')

<style>
    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        background-color: #f4f7f6;
        padding: 2rem 1rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .auth-card {
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 500px;
    }

    .auth-card h1 {
        font-size: 1.8rem;
        color: #2c3e50;
        margin-bottom: 0.25rem;
        text-align: center;
        font-weight: 700;
    }

    .auth-card h2 {
        font-size: 1.1rem;
        color: #7f8c8d;
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: 500;
    }

    .service-info {
        background: #f8f9fa;
        padding: 1rem 1.25rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border-left: 4px solid #3498db;
    }

    .service-info p {
        margin: 0.4rem 0;
        color: #444;
        font-size: 0.95rem;
    }

    .service-info strong {
        color: #2c3e50;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #34495e;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #dcdde1;
        border-radius: 6px;
        font-size: 1rem;
        color: #2f3640;
        transition: all 0.3s ease;
        box-sizing: border-box;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 0.85rem;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 1.05rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.1s ease;
        margin-top: 2rem;
    }

    .btn:hover {
        background-color: #2980b9;
    }

    .btn:active {
        transform: scale(0.98);
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <h1>Pesan Jasa</h1>
        <h2>{{ $service->title }}</h2>

        <div class="service-info">
            <p><strong>Pemilik:</strong> {{ $service->user->username }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($service->price, 0, ',', '.') }}</p>
        </div>

        <form method="POST" action="/services/{{ $service->id }}/order">
            @csrf
            
            <!-- Hidden Input dipisah agar struktur HTML lebih rapi -->
            <input type="hidden" name="service_id" value="{{ $service->id }}">

            <div class="form-group">
                <label for="requirements">Kebutuhan</label>
                <textarea
                    id="requirements"
                    name="requirements"
                    class="form-control"
                    rows="4"
                    placeholder="Jelaskan kebutuhan jasa yang Anda inginkan..."
                    required
                ></textarea>
            </div>

            <div class="form-group">
                <label for="deadline">Deadline</label>
                <!-- Menambahkan input date yang sebelumnya hilang -->
                <input
                    type="date"
                    id="deadline"
                    name="deadline"
                    class="form-control"
                    required
                >
            </div>

            <div class="form-group">
                <label for="notes">Catatan (Opsional)</label>
                <textarea
                    id="notes"
                    name="notes"
                    class="form-control"
                    rows="3"
                    placeholder="Tambahkan catatan khusus jika ada..."
                ></textarea>
            </div>

            <button type="submit" class="btn">Buat Order</button>
        </form>
    </div>
</div>

@endsection