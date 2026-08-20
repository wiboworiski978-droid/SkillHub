<?php

namespace App\Http\Controllers;

use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
    if (!session()->has('user_id')) {
        return redirect('/login');
    }
        $services = Service::with(['user', 'category'])
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('services'));
    }
}