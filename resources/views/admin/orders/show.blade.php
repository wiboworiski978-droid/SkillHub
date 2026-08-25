@extends('layouts.app')

@section('title', 'Detail Order - SkillHub')

@section('content')

<div class="admin-dashboard">

    <h1>Detail Order #{{ $order->id }}</h1>

    <hr>

    <h2>
        {{ $order->service->title }}
    </h2>

    <p>
        <strong>Pembeli:</strong>
        {{ $order->buyer->username ?? '-' }}
    </p>

    <p>
        <strong>Pemilik Jasa:</strong>
        {{ $order->service->user->username ?? '-' }}
    </p>

    <p>
        <strong>Kategori:</strong>
        {{ $order->service->category->name ?? '-' }}
    </p>

    <p>
        <strong>Harga:</strong>
        Rp {{ number_format($order->service->price ?? 0, 0, ',', '.') }}
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

    <br>

    <a href="/admin/orders" class="btn">
        Kembali ke Order
    </a>

</div>

@endsection