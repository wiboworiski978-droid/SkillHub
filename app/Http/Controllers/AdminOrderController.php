<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    //menampilkan semua order
    public function index()
    {
        $orders = Order::with([
            'buyer',
            'service.user',
            'service.category'
        ])
        ->latest()
        ->get();

        return view('admin.orders.index', compact('orders'));
    }

    //detail prder
    public function show($id)
    {
        $order = Order::with([
            'buyer',
            'service.user',
            'service.category'
        ])->find($id);

        if (!$order) {
            abort(404);
        }
        return view('admin.orders.show', compact('order'));
    }
}
