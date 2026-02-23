<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('email', 'customer@kebundigital.com')->first();
        $products = Product::all();

        if (!$customer || $products->isEmpty()) {
            return;
        }

        // Order 1: COD - Sedang Diproses (belum hantar lagi)
        $order1 = Order::create([
            'order_number' => 'KD-20260215-0001',
            'user_id' => $customer->id,
            'subtotal' => 89.70,
            'shipping_fee' => 8.00,
            'total' => 97.70,
            'status' => 'to_ship',
            'shipping_address' => 'No 12, Jalan Mawar 3, Taman Bunga Raya, 43000 Kajang, Selangor',
            'recipient_name' => $customer->name,
            'phone' => '012-345 6789',
            'notes' => 'Letak depan pintu pagar',
            'created_at' => now()->subDays(2),
        ]);

        $p1 = $products->where('name', 'Durian Musang King')->first() ?? $products->first();
        $p2 = $products->skip(1)->first() ?? $products->first();

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $p1->id,
            'product_name' => $p1->name,
            'product_price' => $p1->price,
            'quantity' => 1,
            'subtotal' => $p1->price,
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $p2->id,
            'product_name' => $p2->name,
            'product_price' => $p2->price,
            'quantity' => 2,
            'subtotal' => $p2->price * 2,
        ]);

        Payment::create([
            'order_id' => $order1->id,
            'method' => 'cod',
            'status' => 'pending',
            'amount' => 97.70,
            'reference_number' => 'REF-' . strtoupper(uniqid()),
        ]);

        // Order 2: FPX - Dalam Penghantaran
        $order2 = Order::create([
            'order_number' => 'KD-20260216-0001',
            'user_id' => $customer->id,
            'subtotal' => 156.50,
            'shipping_fee' => 0,
            'total' => 156.50,
            'status' => 'to_receive',
            'shipping_address' => 'No 12, Jalan Mawar 3, Taman Bunga Raya, 43000 Kajang, Selangor',
            'recipient_name' => $customer->name,
            'phone' => '012-345 6789',
            'created_at' => now()->subDay(),
        ]);

        $p3 = $products->skip(2)->first() ?? $products->first();
        $p4 = $products->skip(3)->first() ?? $products->first();
        $p5 = $products->skip(4)->first() ?? $products->first();

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $p3->id,
            'product_name' => $p3->name,
            'product_price' => $p3->price,
            'quantity' => 3,
            'subtotal' => $p3->price * 3,
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $p4->id,
            'product_name' => $p4->name,
            'product_price' => $p4->price,
            'quantity' => 1,
            'subtotal' => $p4->price,
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $p5->id,
            'product_name' => $p5->name,
            'product_price' => $p5->price,
            'quantity' => 2,
            'subtotal' => $p5->price * 2,
        ]);

        Payment::create([
            'order_id' => $order2->id,
            'method' => 'online_banking',
            'status' => 'paid',
            'amount' => 156.50,
            'reference_number' => 'FPX-' . strtoupper(uniqid()),
            'paid_at' => now()->subDay(),
        ]);

        // Order 3: E-Wallet - Telah Sampai (menunggu konfirmasi)
        $order3 = Order::create([
            'order_number' => 'KD-20260214-0001',
            'user_id' => $customer->id,
            'subtotal' => 45.00,
            'shipping_fee' => 8.00,
            'total' => 53.00,
            'status' => 'arrived',
            'shipping_address' => 'No 12, Jalan Mawar 3, Taman Bunga Raya, 43000 Kajang, Selangor',
            'recipient_name' => $customer->name,
            'phone' => '012-345 6789',
            'created_at' => now()->subDays(3),
        ]);

        $p6 = $products->skip(5)->first() ?? $products->first();

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $p6->id,
            'product_name' => $p6->name,
            'product_price' => $p6->price,
            'quantity' => 3,
            'subtotal' => $p6->price * 3,
        ]);

        Payment::create([
            'order_id' => $order3->id,
            'method' => 'ewallet',
            'status' => 'paid',
            'amount' => 53.00,
            'ewallet_provider' => 'Touch n Go',
            'reference_number' => 'TNG-' . strtoupper(uniqid()),
            'paid_at' => now()->subDays(3),
        ]);

        // Order 4: COD - Belum Bayar (baru dibuat hari ni)
        $order4 = Order::create([
            'order_number' => 'KD-20260217-0001',
            'user_id' => $customer->id,
            'subtotal' => 210.00,
            'shipping_fee' => 0,
            'total' => 210.00,
            'status' => 'to_ship',
            'shipping_address' => 'No 12, Jalan Mawar 3, Taman Bunga Raya, 43000 Kajang, Selangor',
            'recipient_name' => $customer->name,
            'phone' => '012-345 6789',
            'notes' => 'Hubungi sebelum hantar',
        ]);

        $p7 = $products->skip(6)->first() ?? $products->first();
        $p8 = $products->skip(7)->first() ?? $products->first();

        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $p7->id,
            'product_name' => $p7->name,
            'product_price' => $p7->price,
            'quantity' => 5,
            'subtotal' => $p7->price * 5,
        ]);
        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $p8->id,
            'product_name' => $p8->name,
            'product_price' => $p8->price,
            'quantity' => 2,
            'subtotal' => $p8->price * 2,
        ]);

        Payment::create([
            'order_id' => $order4->id,
            'method' => 'cod',
            'status' => 'pending',
            'amount' => 210.00,
            'reference_number' => 'REF-' . strtoupper(uniqid()),
        ]);

        // Order 5: Selesai
        $order5 = Order::create([
            'order_number' => 'KD-20260210-0001',
            'user_id' => $customer->id,
            'subtotal' => 120.00,
            'shipping_fee' => 0,
            'total' => 120.00,
            'status' => 'completed',
            'shipping_address' => 'No 12, Jalan Mawar 3, Taman Bunga Raya, 43000 Kajang, Selangor',
            'recipient_name' => $customer->name,
            'phone' => '012-345 6789',
            'created_at' => now()->subWeek(),
        ]);

        $p9 = $products->skip(8)->first() ?? $products->first();

        OrderItem::create([
            'order_id' => $order5->id,
            'product_id' => $p9->id,
            'product_name' => $p9->name,
            'product_price' => $p9->price,
            'quantity' => 4,
            'subtotal' => $p9->price * 4,
        ]);

        Payment::create([
            'order_id' => $order5->id,
            'method' => 'online_banking',
            'status' => 'paid',
            'amount' => 120.00,
            'reference_number' => 'FPX-' . strtoupper(uniqid()),
            'paid_at' => now()->subWeek(),
        ]);
    }
}
