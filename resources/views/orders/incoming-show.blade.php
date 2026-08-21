@extends('layouts.app')

@section('title', 'Detail Order Masuk - SkillHub')

@section('content')

<div class="service-detail">

    <h1>Detail Order Masuk</h1>

    <hr>

    <h2>{{ $order->service->title }}</h2>

    <p>
        <strong>Pembeli:</strong>
        {{ $order->buyer->username }}
    </p>

    <p>
        <strong>Kategori:</strong>
        {{ $order->service->category->name }}
    </p>

    <p>
        <strong>Harga:</strong>
        Rp {{ number_format($order->service->price, 0, ',', '.') }}
    </p>

    <p>
        <strong>Deadline:</strong>
        {{ $order->deadline }}
    </p>

    <p>
        <strong>Status:</strong>
        {{ $order->status }}
    </p>

    <hr>

    <h3>Kebutuhan Pembeli</h3>

    <p>
        {{ $order->requirements }}
    </p>

    @if ($order->notes)

        <h3>Catatan</h3>

        <p>
            {{ $order->notes }}
        </p>

    @endif

    <hr>

    @if ($order->status === 'pending')

        <form
            method="POST"
            action="/orders/incoming/{{ $order->id }}/status"
            style="display: inline;"
        >

            @csrf

            <input
                type="hidden"
                name="status"
                value="accepted"
            >

            <button type="submit" class="btn">
                Terima Order
            </button>

        </form>

        <form
            method="POST"
            action="/orders/incoming/{{ $order->id }}/status"
            style="display: inline;"
        >

            @csrf

            <input
                type="hidden"
                name="status"
                value="rejected"
            >

            <button type="submit" class="btn">
                Tolak Order
            </button>

        </form>

    @elseif ($order->status === 'accepted')

        <p>
            Order sudah diterima. Silakan mulai pengerjaan.
        </p>

    @elseif ($order->status === 'in_progress')

        <p>
            Order sedang dikerjakan.
        </p>

    @elseif ($order->status === 'complete')

        <p>
            Order sudah selesai.
        </p>

    @elseif ($order->status === 'rejected')

        <p>
            Order ditolak.
        </p>

    @elseif ($order->status === 'cancelled')

        <p>
            Order dibatalkan oleh pembeli.
        </p>

    @endif

    @if ($order->status === 'accepted')

    <form
        method="POST"
        action="/orders/incoming/{{ $order->id }}/start"
    >
        @csrf

        <button type="submit" class="btn">
            Mulai Pengerjaan
        </button>
    </form>

@endif


@if ($order->status === 'in_progress')

    <form
        method="POST"
        action="/orders/incoming/{{ $order->id }}/complete"
    >
        @csrf

        <button type="submit" class="btn">
            Selesaikan Order
        </button>
    </form>

@endif

    <br>

    <a href="/orders/incoming" class="btn">
        Kembali ke Order Masuk
    </a>

</div>

@endsection