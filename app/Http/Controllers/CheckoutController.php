<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderAdminMail;
use App\Mail\OrderPlacedMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Troli anda kosong!');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $rules = [
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cod,online_banking,ewallet',
            'ewallet_provider' => 'required_if:payment_method,ewallet|nullable|string',
            'notes' => 'nullable|string',
        ];

        if (!auth()->check()) {
            $rules['guest_email'] = 'required|email|max:255';
        }

        $request->validate($rules);

        $cart = $this->getCart();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Troli anda kosong!');
        }

        // Validate stock & calculate subtotal
        $subtotal = 0;
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Stok {$item->product->name} tidak mencukupi!");
            }
            $subtotal += $item->price * $item->quantity;
        }

        // Shipping fee: COD = RM5, Others = RM8
        $shippingFee = Order::calculateShippingFee($request->payment_method, $subtotal);
        $total = $subtotal + $shippingFee;

        // COD → to_ship (no payment needed upfront), Online → to_pay
        $orderStatus = $request->payment_method === 'cod' ? 'to_ship' : 'to_pay';

        // Create order with receipt number
        $orderData = [
            'order_number' => Order::generateOrderNumber(),
            'receipt_number' => Order::generateReceiptNumber(),
            'user_id' => auth()->id(),
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total' => $total,
            'status' => $orderStatus,
            'shipping_address' => $request->shipping_address,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'notes' => $request->notes,
        ];

        if (!auth()->check()) {
            $orderData['guest_email'] = $request->guest_email;
            $orderData['guest_name'] = $request->recipient_name;
        }

        $order = Order::create($orderData);

        // Create order items & reduce stock
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_price' => $item->price,
                'quantity' => $item->quantity,
                'subtotal' => $item->price * $item->quantity,
            ]);
            $item->product->decrement('stock', $item->quantity);
        }

        // Create payment record
        Payment::create([
            'order_id' => $order->id,
            'method' => $request->payment_method,
            'status' => 'pending',
            'amount' => $total,
            'ewallet_provider' => $request->ewallet_provider,
            'reference_number' => 'REF-' . strtoupper(uniqid()),
        ]);

        // Simulate online payment: mark as paid immediately
        if (in_array($request->payment_method, ['online_banking', 'ewallet'])) {
            $order->payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
            $order->update(['status' => 'to_ship']);
        }

        // Clear cart
        $cart->items()->delete();
        // Optionally delete the cart itself if it's a guest session to start fresh, but items delete is usually enough.

        // Load relationships for emails
        $order->load(['items', 'payment', 'user']);

        // Send email to customer
        $email = auth()->check() ? $order->user->email : $order->guest_email;
        Mail::to($email)->send(new OrderPlacedMail($order));

        // Send email to admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Mail::to($admin->email)->send(new NewOrderAdminMail($order));
        }

        return redirect()->to(\Illuminate\Support\Facades\URL::signedRoute('orders.show', $order))
            ->with('success', 'Pesanan berjaya dibuat! No. Pesanan: ' . $order->order_number . ' | No. Resit: ' . $order->receipt_number);
    }

    private function getCart()
    {
        if (auth()->check()) {
            return Cart::where('user_id', auth()->id())->with('items.product')->first();
        }
        return Cart::where('session_id', session()->getId())->with('items.product')->first();
    }
}
