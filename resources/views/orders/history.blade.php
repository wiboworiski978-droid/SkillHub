@extends('layouts.app')

@section('title', 'Riwayat Order - SkillHub')

@section('content')

<div class="service-detail">

```
<h1>Riwayat Order</h1>

@if ($orders->isEmpty())

    <p>
        Belum ada riwayat order.
    </p>

@else

    @foreach ($orders as $order)

        <div class="service-card">

            <h2>
                {{ $order->service->title }}
            </h2>

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
                <strong>Deadline:</strong>
                {{ $order->deadline }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ $order->status }}
            </p>

            <a
                href="/orders/{{ $order->id }}"
                class="btn"
            >
                Lihat Detail
            </a>

        </div>

        <hr>

    @endforeach

@endif
```

</div>

@endsection
