@extends('layouts.app')

@section('title', 'Order Saya - SkillHub')

@section('content')

<div class="services-container">

    <h1>Order Saya</h1>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if ($orders->count() > 0)

        @foreach ($orders as $order)

            <div class="service-card">

                <h2>
                    {{ $order->service->title }}
                </h2>

                <p>
                    Pemilik:
                    {{ $order->service->user->username }}
                </p>

                <p>
                    Harga:
                    Rp {{ number_format($order->service->price, 0, ',', '.') }}
                </p>

                <p>
                    Deadline:
                    {{ $order->deadline }}
                </p>

                <p>
                    Status:
                    <strong>{{ $order->status }}</strong>
                </p>

                <a
                    href="/orders/{{ $order->id }}"
                    class="btn"
                >
                    Lihat Detail
                </a>

            </div>

        @endforeach

    @else

        <p>
            Kamu belum memiliki order.
        </p>

    @endif

</div>

@endsection