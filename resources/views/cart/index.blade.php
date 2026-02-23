@extends('layouts.app')
@section('content')
    <div class="container section">
        <h2 class="section-title" style="margin-bottom:24px;">🛒 Troli Saya</h2>

        @if(!$cart || $cart->items->isEmpty())
            <div class="card" style="text-align:center;padding:60px;">
                <div style="font-size:5rem;margin-bottom:16px;">🛒</div>
                <h3>Troli anda kosong</h3>
                <p style="color:var(--text-light);margin:8px 0 20px;">Mula membeli buah-buahan segar sekarang!</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">🍊 Lihat Produk</a>
            </div>
        @else
            <div style="display:grid;grid-template-columns:1fr 340px;gap:24px;">
                <!-- CART ITEMS -->
                <div>
                    @foreach($cart->items as $item)
                        <div class="card" style="display:flex;gap:16px;margin-bottom:12px;align-items:center;">
                            <div
                                style="width:80px;height:80px;background:linear-gradient(135deg,var(--primary-light),#d5f5e3);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;flex-shrink:0;">
                                @if($item->product->getFirstMediaUrl('product_image'))
                                    <img src="{{ $item->product->getFirstMediaUrl('product_image') }}"
                                        style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                                @else
                                    🍊
                                @endif
                            </div>
                            <div style="flex:1;">
                                <h3 style="font-size:0.95rem;font-weight:600;">{{ $item->product->name }}</h3>
                                <p style="color:var(--accent);font-weight:700;font-size:1rem;">RM
                                    {{ number_format($item->price, 2) }} <span
                                        style="font-size:0.75rem;color:var(--text-light);font-weight:400;">/
                                        {{ $item->product->unit }}</span>
                                </p>
                            </div>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <form action="{{ route('cart.update', $item) }}" method="POST"
                                    style="display:flex;align-items:center;gap:4px;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}"
                                        class="btn btn-outline btn-sm"
                                        style="width:32px;height:32px;padding:0;justify-content:center;">−</button>
                                    <span style="width:40px;text-align:center;font-weight:600;">{{ $item->quantity }}</span>
                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                        class="btn btn-outline btn-sm"
                                        style="width:32px;height:32px;padding:0;justify-content:center;">+</button>
                                </form>
                            </div>
                            <div style="text-align:right;min-width:90px;">
                                <p style="font-weight:700;color:var(--text);">RM
                                    {{ number_format($item->price * $item->quantity, 2) }}
                                </p>
                            </div>
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm"
                                    style="background:#fee;color:var(--accent);border:1px solid #fcc;padding:6px 10px;">🗑️</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <!-- ORDER SUMMARY -->
                <div>
                    <div class="card" style="position:sticky;top:80px;">
                        <div class="card-header">📋 Ringkasan Pesanan</div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.9rem;">
                            <span>Jumlah Item</span>
                            <span>{{ $cart->totalItems }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.9rem;">
                            <span>Subtotal</span>
                            <span>RM {{ number_format($cart->total, 2) }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.9rem;">
                            <span>Penghantaran</span>
                            <span
                                style="color:{{ $cart->total >= 100 ? 'var(--primary)' : 'var(--text)' }}">{{ $cart->total >= 100 ? 'PERCUMA' : 'RM 8.00' }}</span>
                        </div>
                        @if($cart->total < 100)
                            <div style="background:#fff3cd;padding:8px 12px;border-radius:6px;font-size:0.8rem;margin-bottom:12px;">
                                💡 Tambah RM {{ number_format(100 - $cart->total, 2) }} lagi untuk penghantaran percuma!
                            </div>
                        @endif
                        <hr style="border:1px solid var(--border);margin:12px 0;">
                        <div style="display:flex;justify-content:space-between;font-size:1.1rem;font-weight:700;">
                            <span>Jumlah</span>
                            <span style="color:var(--accent);">RM
                                {{ number_format($cart->total + ($cart->total >= 100 ? 0 : 8), 2) }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary"
                            style="width:100%;justify-content:center;margin-top:16px;">
                            💳 Teruskan ke Pembayaran
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        @media (max-width: 768px) {
            .container.section>div {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection