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

    //menerima atau menolak order
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $order = Order::with('service')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        //hanya pemilik jasa yanng boleh menerima/menolak
        if ($order->service->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah order ini'
            ], 403);
        }

        //order hanya boleh diubah jika masih pending
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Order sudah tidak berstatus pending'
            ], 400);
        }

        $order->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status order berhasil diubah',
            'data' => $order
        ]);
    }

    //mengubah orderan menjadi in progress
    public function startOrder(Request $request, $id)
    {
        $order = Order::with('service')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        //hanya pemilik jasa yang boleh memulai pengerjaan
        if ($order->service->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk memulai order ini'
            ], 403);
        }

        //Order harus accepted terlebih dahulu 
        if ($order->status !== 'accepted') {
            return response()->json([
                'success' => false,
                'message' => 'Order harus berstatus accepted terlebih dahulu'
            ], 404);
        }

        $order->update([
            'status' => 'in_progress'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order sedang dikerjakan',
            'data' => $order
        ]);
    }

    public function completeOrder(Request $request, $id)
    {
        $order = Order::with('service')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        //hanya pemilik jasa 
        if ($order->service->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk menyelesaikanorde ini'
            ], 403);
        }

        //Harus sedang dikerjakan
        if ($order->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'Order berstatus in_progress terlebih dahulu'
            ], 400);
        }

        $order->update([
            'status'=> 'complete'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil diselesaikan',
            'data' => $order
        ]);
    }

    //membatalkan orderan
    public function cancelOrder(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        //hanya buyer yang membuat order boleh membatalkan
        if ($order->buyer_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk membatalkan order ini'
            ], 403);
        }

        //order yang sudah selesai atau ditolak tidak bisa dibatalkan
        if (in_array($order->status, ['complete', 'rejected', 'cancelled'])) {
            return response()->json([
                'success' => false,
                'message' => 'Order sudah tidak dapat dibatalkan'
            ], 400);
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil dibatalkan',
            'data' => $order
        ]);
    }

    //melihat riwayat order
    public function history(Request $request)
    {
        $orders = Order::with([
            'service.user',
            'service.category'
        ])
        ->where('buyer_id', $request->user()->id)
        ->whereIn('status', [
            'complete',
            'rejected',
            'cancelled'
        ])
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Riwayat order berhasil diambil',
            'data' => $orders
        ]);
    }

    //front end order
    public function webCreate($id)
    {
        $service = Service::with(['user', 'category'])->find($id);

        if (!$service) {
            abort(404);
        }

        if ($service->status !== 'active') {
            return redirect('/services/' . $id)
                ->withErrors([
                    'service' => 'Jasa ini sedang tidak aktif'
                ]);
        }

        return view('orders.create', compact('service'));
    }

    //mengisi form order
    public function webStore(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'requirements' => 'required|string',
            'deadline' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $service = Service::find($request->service_id);

        //tidak boleh memesan jasa sendiri
        if ($service->user_id === session('user_id')) {
            return back()->withErrors([
                'order' => 'Anda tidak bisa memesan jasa sendiri'
            ])->withInput();
        }

        //jasa harus aktiv
        if ($service->status !== 'active') {
            return back()->withErrors([
                'order' => 'Jasa ini sedang tidak aktif'
            ])->withInput(); 
        }

        $order = Order::create([
            'buyer_id' => session('user_id'),
            'service_id' => $request->service_id,
            'requirements' => $request->requirements,
            'deadline' => $request->deadline,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect('/orders/' . $order->id)
            ->with('success', 'Order berhasil dibuat');
    }

    //nampilin semua orderann milik user
    public function webIndex()
    {
        $orders = Order::with([
            'service.user',
            'service.category'
        ])
        ->where('buyer_id', session('user_id'))
        ->latest()
        ->get();

        return view('orders.index', compact('orders'));
    }

    //front end detail order
    public function webShow($id)
    {
        $order = Order::with([
            'service.user',
            'service.category'
        ])
        ->where('buyer_id', session('user_id'))
        ->find($id);

        if (!$order) {
            abort(404);
        }

        return view('orders.show', compact('order'));
    }

    //front end cancel order
    public function webCancel(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            abort(404);
        }

        //Hanya buyer yang membuat order yang boleh membatalkan
        if ($order->buyer_id !== session('user_id')) {
            abort(403);
        }

        //order yang sudah tidak bisa dibatalkan
        if (in_array($order->status, [
            'complete',
            'rejected',
            'cancelled'
        ])) {
            return back()->withErrors([
                'order' => 'Order sudah tidak dapat dibatalkan'
            ]);
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return redirect('/orders/' . $order->id)
            ->with('success', 'Order berhasil dibatalkan');
    }

    //frontend pemilik jasa harus bisa melihat siapa yang
    //memesan jasanya
    public function webIncoming()
    {
        $orders = Order::with([
            'service',
            'buyer'
        ])
        ->whereHas('service', function ($query) {
            $query->where('user_id', session('user_id'));
        })
        ->latest()
        ->get();

        return view('orders.incoming', compact('orders'));
    }

    //frontend detail order masuk
    public function webIncomingShow($id)
    {
        $order = Order::with([
            'service',
            'service.category',
            'buyer'
        ])
        ->whereHas('service', function ($query) {
            $query->where('user_id', session('user_id'));
        })
        ->find($id);

        if (!$order) {
            abort(404);
        }

        return view('orders.incoming-show', compact('order'));
    }

    //frontend terima atau tolak order
    public function webUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $order = Order::with('service')->find($id);

        if (!$order) {
            abort(404);
        }

        //hanya pemilik jasa yang boleh mengubah status
        if ($order->service->user_id !== session('user_id')) {
            abort(403);
        }

        //hanya order pending yang boleh diterima / ditolak
        if ($order->status !== 'pending') {
            return back()->withErrors([
                'order' => 'Order sudah tidak berstatus pending'
            ]);
        }

        $order->update([
            'status' => $request->status
        ]);

        return redirect('/orders/incoming/' . $order->id)
            ->with(
                'success',
                $request->status === 'accepted'
                    ? 'Order berhasil diterima'
                    : 'Order berhasil ditolak'
            );
    }

    //frontend mulai pengerjaan
    public function webStartOrder($id)
    {
        $order = Order::with('service')->find($id);

        if (!$order) {
            abort(404);
        }

        //hanya pemilik jasa
        if ($order->service->user_id !== session('user_id')) {
            abort(403);
        }

        //harus berstatus accepted
        if ($order->status !== 'accepted') {
            return back()->withErrors([
                'order' => 'Order harus berstatus accepted terlebih dahulu'
            ]);
        }

        $order->update([
            'status' => 'in_progress'
        ]);

        return back()->with(
            'success',
            'Order sedang dikerjakan'
        );
    }

    //frontend penyelesaian orderan
    public function webCompleteOrder($id)
    {
        $order = Order::with('service')->find($id);

        if (!$order) {
            abort(404);
        }

        //hanya pemilik jasa 
        if ($order->service->user_id !== session('user_id')) {
            abort(403);
        }

        //harus berstatus sedang dikerjakan
        if ($order->status !== 'in_progress') {
            return back()->withErrors([
                'order' => 'Order harus berstatus in_progress terlebih dahulu'
            ]);
        }

        $order->update([
            'status' => 'complete'
        ]);

        return back()->with(
            'success',
            'Order berhasil diselesaikan'
        );
    }
}
