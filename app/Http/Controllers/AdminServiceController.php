<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class AdminServiceController extends Controller
{
    //menampilkan semua jasa
    public function index()
    {
        $services = Service::with([
            'user',
            'category'
        ])
        ->latest()
        ->get();

        return view('admin.services.index', compact('services'));
    }

    //menghapus jasa 
    public function destroy($id)
    {
        $service =Service::find($id);

        if (!$service) {
            return back()->withErrors([
                'service' => 'Jasa dengan ID ' . $id . ' tidak ditemukan'
            ]);
        }

        $service->delete();

        return redirect('/admin/services')
            ->with('success', 'Jasa berhasil dihapus');
    }
}
