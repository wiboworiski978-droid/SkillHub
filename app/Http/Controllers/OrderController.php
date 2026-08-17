<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //membuat order
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'requirements' => 'required|string',
            'deadline' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $service = Service::find($request->service_id);

        //tidak boleh memesan jasa sendiri
        if ($service->user_id === $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak bisa memesan jasa sendiri'
            ], 403);
        }

        $order = Order::create([
            'buyer_id' => $request->user()->id,
            'service_id' => $request->service_id,
            'requirements' => $request->requirements,
            'deadline' => $request->deadline,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil dibuat',
            'data' => $order
        ], 201);
    }

    //melihat order milik user yang sedang login
    public  function index(Request $request)
    {
        $orders = Order::with([
            'service.user',
            'service.category'
        ])
        ->where('buyer_id', $request->user()->id)
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data order berhasil diambil',
            'data' => $orders
        ]);
    }
    //melihat detail orderan
    public function show(Request $request, $id)
    {
        $order = Order::with([
            'service.user',
            'service.category'
        ])
        ->where('buyer_id', $request->user()->id)
        ->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail order berhasil diambil',
            'data' => $order
        ]);
    }
}
