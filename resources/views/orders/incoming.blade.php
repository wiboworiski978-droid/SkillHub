@extends('layouts.app')

@section('title', 'Order Masuk - SkillHub')

@section('content')

<div class="services-container">

    <h1>Order Masuk</h1>

    @if ($orders->count() > 0)

        @foreach ($orders as $order)

            <div class="service-card">

                <h2>
                    {{ $order->service->title }}
                </h2>

                <p>
                    <strong>Pembeli:</strong>
                    {{ $order->buyer->username }}
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

                <a
                    href="/orders/incoming/{{ $order->id }}"
                    class="btn"
                >
                    Lihat Order
                </a>

            </div>

        @endforeach

    @else

        <p>
            Belum ada order yang masuk.
        </p>

    @endif

</div>

@endsection