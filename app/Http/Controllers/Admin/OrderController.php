<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewOrderAdminMail;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('receipt_number', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }

        $orders = $query->latest()->paginate(15);

        $statusCounts = [
            'all' => Order::count(),
            'to_pay' => Order::where('status', 'to_pay')->count(),
            'to_ship' => Order::where('status', 'to_ship')->count(),
            'to_receive' => Order::where('status', 'to_receive')->count(),
            'arrived' => Order::where('status', 'arrived')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    public function create()
    {
        $customers = User::where('role', 'customer')->orderBy('name')->get();
        $products = Product::where('is_active', true)->where('stock', '>', 0)->orderBy('name')->get();

        return view('admin.orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required', // can be user ID or 'guest'
            'guest_email' => 'required_if:customer_id,guest|nullable|email',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cod,online_banking,ewallet',
            'ewallet_provider' => 'required_if:payment_method,ewallet|nullable|string',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Calculate subtotal
        $subtotal = 0;
        $orderItems = [];

        foreach ($request->products as $item) {
            $product = Product::findOrFail($item['id']);
            if ($product->stock < $item['quantity']) {
                return back()->with('error', "Stok {$product->name} tidak mencukupi!")->withInput();
            }
            $itemSubtotal = $product->price * $item['quantity'];
            $subtotal += $itemSubtotal;
            $orderItems[] = [
                'product' => $product,
                'quantity' => $item['quantity'],
                'subtotal' => $itemSubtotal,
            ];
        }

        // Shipping fee: COD = RM5, Others = RM8
        $shippingFee = Order::calculateShippingFee($request->payment_method, $subtotal);
        $total = $subtotal + $shippingFee;

        $orderStatus = $request->payment_method === 'cod' ? 'to_ship' : 'to_pay';

        $isGuest = $request->customer_id === 'guest';

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'receipt_number' => Order::generateReceiptNumber(),
            'user_id' => $isGuest ? null : $request->customer_id,
            'guest_email' => $isGuest ? $request->guest_email : null,
            'guest_name' => $isGuest ? $request->recipient_name : null,
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total' => $total,
            'status' => $orderStatus,
            'shipping_address' => $request->shipping_address,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'notes' => $request->notes,
        ]);

        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'product_price' => $item['product']->price,
                'quantity' => $item['quantity'],
                'subtotal' => $item['subtotal'],
            ]);
            $item['product']->decrement('stock', $item['quantity']);
        }

        Payment::create([
            'order_id' => $order->id,
            'method' => $request->payment_method,
            'status' => $request->payment_method === 'cod' ? 'pending' : 'paid',
            'amount' => $total,
            'ewallet_provider' => $request->ewallet_provider,
            'reference_number' => 'REF-' . strtoupper(uniqid()),
            'paid_at' => $request->payment_method !== 'cod' ? now() : null,
        ]);

        if (in_array($request->payment_method, ['online_banking', 'ewallet'])) {
            $order->update(['status' => 'to_ship']);
        }

        // Send confirmation email to customer
        $order->load(['items', 'payment', 'user']);
        Mail::to($order->getCustomerEmail())->send(new OrderPlacedMail($order));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Pesanan berjaya dibuat bagi pihak pelanggan! No: ' . $order->order_number);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:to_pay,to_ship,to_receive,arrived,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        // If status is completed and payment is COD, mark payment as paid
        if ($request->status === 'completed' && $order->payment && $order->payment->method === 'cod') {
            $order->payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        return back()->with('success', 'Status pesanan berjaya dikemaskini!');
    }
}
