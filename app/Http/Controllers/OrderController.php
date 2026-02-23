<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Order::where('user_id', auth()->id())
            ->with(['items.product', 'payment'])
            ->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10);

        // Count by status for tabs
        $statusCounts = [
            'to_pay' => Order::where('user_id', auth()->id())->where('status', 'to_pay')->count(),
            'to_ship' => Order::where('user_id', auth()->id())->where('status', 'to_ship')->count(),
            'to_receive' => Order::where('user_id', auth()->id())->where('status', 'to_receive')->count(),
            'arrived' => Order::where('user_id', auth()->id())->where('status', 'arrived')->count(),
        ];

        return view('orders.index', compact('orders', 'status', 'statusCounts'));
    }

    public function track(Request $request)
    {
        $orderNumber = $request->query('order_number');
        if (!$orderNumber) {
            return redirect()->route('home')->with('error', 'Sila masukkan nombor pesanan.');
        }

        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Pesanan tidak dijumpai.');
        }

        $order->load(['items.product', 'payment']);

        return view('orders.show', compact('order'));
    }

    public function show(Order $order, Request $request)
    {
        // Allow if user is owner OR if signature is valid (for guests)
        if (!$request->hasValidSignature() && $order->user_id !== auth()->id()) {
            // Also allow if it's a guest order being viewed (handled via track mainly, but strictly show might need protection)
            // For now, keep show strict to signature/auth, track handles the "search" access.
            abort(403);
        }

        $order->load(['items.product', 'payment']);

        return view('orders.show', compact('order'));
    }

    public function confirmReceived(Order $order, Request $request)
    {
        // Allow if auth user owns order OR if signature is valid (for guests)
        if (!$request->hasValidSignature() && $order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status === 'arrived') {
            $order->update(['status' => 'completed']);

            // If COD, mark payment as paid
            if ($order->payment && $order->payment->method === 'cod' && $order->payment->status === 'pending') {
                $order->payment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);
            }

            return back()->with('success', 'Pesanan telah disahkan diterima!');
        }

        return back()->with('error', 'Status pesanan tidak boleh dikemaskini.');
    }
}
