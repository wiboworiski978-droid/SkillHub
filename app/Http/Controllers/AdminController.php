<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Order;
use App\Models\Category;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUser = User::count();

        $totalServices = Service::count();

        $totalOrders = Order::count();

        $totalCategories = Category::count();

        $pendingOrders = Order::where('status', 'pending')->count();

        $completeOrders = Order::where('status', 'complete')->count();

        $rejectedOrders = Order::where('status', 'rejected')->count();

        $inactiveServices = Service::where('status', 'inactive')->count();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalServices',
            'totalOrders',
            'totalCategories',
            'pendingOrders',
            'completeOrders',
            'rejectedOrders',
            'inactiveServices'
        ));
    }
}
