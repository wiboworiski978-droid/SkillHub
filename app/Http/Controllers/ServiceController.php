<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    //membuat jasa
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ]);

        $service = Service::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'estimated_days' =>$request->estimated_days,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jasa berhasil dibuat',
            'data' => $service
        ], 201);
    }

    //melihat semua jasa + search + filter kategori
    public function index(Request $request)
    {
        $query = Service::with(['user', 'category']);

        //search berdasarkan judul atau deskripsi
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        //filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        //filter harga minimun
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        //filter harga maksimum
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        //sort
        if ($request->filled('sort')) {
            if ($request->sort === 'latest') {
                $query->latest();
            } elseif ($request->sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            }
        } else {
            //default: terbaru
            $query->latest();
        }

        //Pagination
        $services = $query->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Data jasa berhasil diambil',
            'data' => $services
        ]);
    }

    //detail jasa
    public function show($id)
    {
        $service = Service::with(['user', 'category'])->find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Jasa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail jasa berhasil diambil',
            'data' => $service
        ]);
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Jasa tidak ditemukan'
            ], 404);
        }

        //hanya pemilik jasa yang boleh mengedit
        if ($service->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengedit jasa ini'
            ], 403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $service->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'estimated_days' => $request->estimated_days,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jasa berhasil diperbarui',
            'data' => $service
        ]);
    }

    //menghapus jasa
    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'jasa tidak ditemukan'
            ], 404);
        }

        //hanya pemilik jasa yang boleh menghapus
        if ($service->user_id !== request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk menghapus jasa ini'
            ], 403);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jasa berhasil dihapus'
        ]);
    }

    //status=active atau inactive
    public function toggleStatus($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Jasa tidak ditemukan'
            ], 404);
        }

        //hanya pemilik jasa yang boleh mengubah status
        if ($service->user_id !== request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah status jasa ini'
            ], 403);
        }

        $service->status = $service->status === 'active'
            ? 'inactive'
            : 'active';

        $service->save();

        return response()->json([
            'success' => true,
            'message' => 'Status jasa berhasil diubah',
            'data' => $service
        ]);
    }

    //front end explore services
    public function webIndex()
    {
        $services = Service::with(['user', 'category'])
            ->latest()
            ->get();
        return view('services.index', compact('services'));
    }

    //front end detail jasa
    public function webShow($id)
    {
        $service = Service::with(['user', 'category'])->find($id);

        if (!$service) {
            abort(404, 'Jasa tidak ditmukan');
        }

        return view('services.show', compact('service'));
    }
}
