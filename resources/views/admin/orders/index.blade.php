@extends('layouts.app')

@section('title', 'Kelola Order - SkillHub')

@section('content')

<div class="admin-dashboard">

    <h1>Kelola Order</h1>

    <p>
        Daftar seluruh order yang ada di SkillHub.
    </p>

    <div class="order-table-wrapper">

        <table class="order-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pembeli</th>
                    <th>Jasa</th>
                    <th>Pemilik Jasa</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Deadline</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($orders as $order)

                    <tr>

                        <td>
                            {{ $order->id }}
                        </td>

                        <td>
                            {{ $order->buyer->username ?? '-' }}
                        </td>

                        <td>
                            {{ $order->service->title ?? '-' }}
                        </td>

                        <td>
                            {{ $order->service->user->username ?? '-' }}
                        </td>

                        <td>
                            Rp {{ number_format($order->service->price ?? 0, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $order->status }}
                        </td>

                        <td>
                            {{ $order->deadline }}
                        </td>

                        <td>

                            <a
                                href="{{ url('/admin/orders/' . $order->id) }}"
                                class="btn"
                            >
                                Detail
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8">
                            Belum ada order.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <br>

    <a href="/admin/dashboard" class="btn">
        Kembali ke Dashboard
    </a>

</div>

<style>

.admin-dashboard {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
}

.order-table-wrapper {
    overflow-x: auto;
    margin-top: 30px;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.order-table th,
.order-table td {
    padding: 14px;
    border-bottom: 1px solid #ddd;
    text-align: left;
    white-space: nowrap;
}

.order-table th {
    background: #f5f5f5;
}

</style>

@endsection