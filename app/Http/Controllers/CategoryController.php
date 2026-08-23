<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //melihat semua kategori
    public function index()
    {
        $categories = Category::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data kategori berhasil diambil',
            'data' => $categories
        ]);
    }

    //menambah kategori
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $category
        ], 201);
    }

    //melihat satu kategori 
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditemukan',
            'data' => $category
        ]);
    }

    //mengubah kategori
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui',
            'data' => $category
        ]);
    }

    //menghapus kategori
    public function destroy($id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }

    //frontend melihat semua kategori
    public function webIndex() 
    {
        $this->checkAdmin();

        $categories = Category::latest()->get();

        return view('categories.index', compact('categories'));
    }

    //frontend form tambah kategori
    public function webCreate()
    {
        $this->checkAdmin();
        return view('categories.create');    
    }

    //frontend menyimpan kategori
    public function webStore(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect('/categories')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    //frontend form edit kategori
    public function webEdit($id)
    {
        $this->checkAdmin();

        $category = Category::find($id);

        if (!$category) {
            abort(404);
        }

        return view('categories.edit', compact('category'));
    }

    //frontend update kategori
    public function webUpdate(Request $request, $id)
    {
        $this->checkAdmin();

        $category = Category::find($id);

        if (!$category) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name' . $id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect('/categories')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    //frontend hapus kategori
    public function weDestroy($id)
    {
        $this->checkAdmin();

        $category = Category::find($id);

        if (!$category) {
            abort(404);
        }

        $category->delete();

        return redirect('/categories')
            ->with('success', 'Kategori berhasil dihapus');
    }

    // frontend cek admin
    private function checkAdmin()
    {
        $user = \App\Models\User::find(session('user_id'));

        if (!$user || $user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
    }
}
