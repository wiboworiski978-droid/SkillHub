@extends('layouts.app')

@section('title', 'Detail Order - SkillHub')

@section('content')

@if (session('success'))

    <div class="success-message">
        {{ session('success') }}
    </div>

@endif

<div class="service-detail">

    <h1>Detail Order</h1>

    <h2>{{ $order->service->title }}</h2>

    <hr>

    <p>
        <strong>Pemilik Jasa:</strong>
        {{ $order->service->user->username }}
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
        <strong>Status:</strong>
        {{ $order->status }}
    </p>

    <p>
        <strong>Deadline:</strong>
        {{ $order->deadline }}
    </p>

    <hr>

    <h3>Kebutuhan</h3>

    <p>
        {{ $order->requirements }}
    </p>

    @if ($order->notes)

        <h3>Catatan</h3>

        <p>
            {{ $order->notes }}
        </p>

    @endif

    <br>

    <a href="/orders" class="btn">
        Kembali ke Order
    </a>

@if (in_array($order->status, ['pending', 'accepted', 'in_progress']))

    <form
        method="POST"
        action="/orders/{{ $order->id }}/cancel"
        style="margin-top: 10px;"
        onsubmit="return confirm('Yakin ingin membatalkan order ini?')"
    >

        @csrf

        <button type="submit" class="btn">
            Batalkan Order
        </button>

    </form>

@endif

</div>

@endsection