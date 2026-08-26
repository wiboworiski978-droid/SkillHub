<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
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
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ]);

        $thumbnail = null;
        
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')
                ->store('services', 'public');
        }

        $service = Service::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $thumbnail,
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
    public function webIndex(Request $request)
    {
        $query = Service::with(['user', 'category'])
            ->where('status', 'active');

        //search berdasarkan judul atau deskripsi
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');

            }); 
        }

        $services = $query
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

    //frontend jasa milik user
    public function myService() {
        $services = Service::with(['category'])
            ->where('user_id', session('user_id'))
            ->latest()
            ->get();

        return view('services.my-services', compact('services'));
    }

    //front end form buat jasa
    public function webCreate() {
        $categories = Category::all();

        return view('services.create', compact('categories'));
    }

    //front end minyimpan jasa
    public function webStore(Request $request) {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ]);

        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')
                ->store('services', 'public');
        }
        $service = Service::create([
            'user_id' => session('user_id'),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $thumbnail,
            'price' => $request->price,
            'estimated_days' => $request->estimated_days,
            'status' => 'active',
        ]);

        return redirect('/services/' . $service->id)
            ->with('success', 'Jasa berhasil dibuat');
    }

    //frontend form edit jasa
    public function webEdit($id) {
        $service = Service::where('user_id', session('user_id'))
            ->find($id);

        if (!$service) {
            abort(404);
        }

        $categories = Category::all();

        return view('services.edit', compact('service', 'categories'));
    }

    //frontend menyimpan perubahan jasa
    public function webUpdate(Request $request, $id) {
        $service = Service::where('user_id', session('user_id'))
            ->find($id);

        if (!$service) {
            abort(404);
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

        return redirect('/my-services')
            ->with('success', 'Jasa berhasil diperbarui');
    }

    //frontend hapus jasa
    public function webDestroy($id) {
        $service = Service::where('user_id', session('user_id'))
            ->find($id);

        if (!$service) {
            abort(404);
        }

        $service->delete();

        return redirect('/my-services')
            ->with('success', 'Jasa berhasil dihapus');
    }
}
