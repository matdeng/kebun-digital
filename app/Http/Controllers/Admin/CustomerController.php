<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'all'); // all, registered, guest

        $customers = collect();

        if ($type === 'all' || $type === 'registered') {
            $users = User::where('role', 'customer')
                ->withCount('orders')
                ->with([
                    'orders' => function ($query) {
                        $query->latest()->limit(1);
                    }
                ])
                ->get()
                ->map(function ($user) {
                    return [
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'type' => 'registered',
                        'total_orders' => $user->orders_count,
                        'last_order' => $user->orders->first()?->created_at,
                    ];
                });
            $customers = $customers->merge($users);
        }

        if ($type === 'all' || $type === 'guest') {
            $guests = Order::whereNull('user_id')
                ->whereNotNull('guest_email')
                ->select('guest_email', 'guest_name', 'phone', 'created_at')
                ->get()
                ->groupBy('guest_email')
                ->map(function ($orders, $email) {
                    $lastOrder = $orders->sortByDesc('created_at')->first();
                    return [
                        'name' => $lastOrder->guest_name,
                        'email' => $email,
                        'phone' => $lastOrder->phone,
                        'type' => 'guest',
                        'total_orders' => $orders->count(),
                        'last_order' => $lastOrder->created_at,
                    ];
                })->values();
            $customers = $customers->merge($guests);
        }

        // Pagination manually since we merged collections
        $page = $request->get('page', 1);
        $perPage = 10;
        $paginatedCustomers = new LengthAwarePaginator(
            $customers->forPage($page, $perPage),
            $customers->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.customers.index', compact('paginatedCustomers', 'type'));
    }
}
