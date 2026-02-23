<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::whereIn('status', ['to_ship', 'to_receive', 'arrived', 'completed'])->sum('total'),
            'total_products' => Product::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'pending_orders' => Order::whereIn('status', ['to_pay', 'to_ship'])->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
        ];

        $recentOrders = Order::with(['user', 'payment'])->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
