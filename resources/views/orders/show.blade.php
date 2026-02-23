@extends('layouts.app')
@section('content')
    <div class="container section">
        <nav style="font-size:0.8rem;color:var(--text-light);margin-bottom:20px;">
            <a href="{{ route('orders.index') }}" style="color:var(--primary);text-decoration:none;">Pesanan Saya</a> /
            {{ $order->order_number }}
        </nav>

        <div style="display:flex;gap:16px;margin-bottom:16px;flex-wrap:wrap;">
            <div style="background:#f0faf4;padding:10px 16px;border-radius:8px;">
                <span style="font-size:0.75rem;color:var(--text-light);">No. Pesanan</span><br>
                <strong style="font-family:monospace;">{{ $order->order_number }}</strong>
            </div>
            @if($order->receipt_number)
                <div style="background:#fff8e1;padding:10px 16px;border-radius:8px;">
                    <span style="font-size:0.75rem;color:var(--text-light);">No. Resit</span><br>
                    <strong style="font-family:monospace;">{{ $order->receipt_number }}</strong>
                </div>
            @endif
        </div>

        <div style="display:grid;grid-template-columns:1fr 350px;gap:24px;">
            <!-- ORDER DETAILS -->
            <div>
                <!-- STATUS TIMELINE -->
                <div class="card" style="margin-bottom:16px;">
                    <div class="card-header">📊 Status Pesanan</div>
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                        <span class="status-badge"
                            style="background:{{ $order->status_color }}22;color:{{ $order->status_color }};font-size:0.9rem;padding:6px 16px;">
                            {{ $order->status_label }}
                        </span>
                        <span style="font-size:0.8rem;color:var(--text-light);">|
                            {{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>

                    <!-- PROGRESS BAR -->
                    @php
                        $steps = ['to_pay' => 'Bayar', 'to_ship' => 'Diproses', 'to_receive' => 'Penghantaran', 'arrived' => 'Sampai', 'completed' => 'Selesai'];
                        $currentIndex = array_search($order->status, array_keys($steps));
                        if ($currentIndex === false)
                            $currentIndex = -1;
                    @endphp
                    <div style="display:flex;align-items:center;gap:4px;">
                        @foreach($steps as $key => $label)
                            @php $index = array_search($key, array_keys($steps)); @endphp
                            <div style="flex:1;text-align:center;">
                                <div
                                    style="height:4px;background:{{ $index <= $currentIndex ? 'var(--primary)' : '#eee' }};border-radius:2px;margin-bottom:6px;">
                                </div>
                                <span
                                    style="font-size:0.7rem;color:{{ $index <= $currentIndex ? 'var(--primary)' : 'var(--text-light)' }};font-weight:{{ $index == $currentIndex ? '700' : '400' }};">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- ORDER ITEMS -->
                <div class="card" style="margin-bottom:16px;">
                    <div class="card-header">📦 Item Pesanan</div>
                    @foreach($order->items as $item)
                        <div
                            style="display:flex;gap:12px;align-items:center;margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid #f5f5f5;">
                            <div
                                style="width:70px;height:70px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:2rem;flex-shrink:0;">
                                @if($item->product && $item->product->getFirstMediaUrl('product_image'))
                                    <img src="{{ $item->product->getFirstMediaUrl('product_image') }}"
                                        style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                                @else
                                    🍊
                                @endif
                            </div>
                            <div style="flex:1;">
                                <p style="font-weight:600;">{{ $item->product_name }}</p>
                                <p style="font-size:0.8rem;color:var(--text-light);">RM
                                    {{ number_format($item->product_price, 2) }} x {{ $item->quantity }}
                                </p>
                            </div>
                            <p style="font-weight:700;color:var(--text);">RM {{ number_format($item->subtotal, 2) }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- SHIPPING INFO -->
                <div class="card">
                    <div class="card-header">📍 Maklumat Penghantaran</div>
                    <p style="font-weight:600;">{{ $order->recipient_name }}</p>
                    <p style="font-size:0.9rem;color:var(--text-light);">{{ $order->phone }}</p>
                    <p style="font-size:0.9rem;margin-top:8px;">{{ $order->shipping_address }}</p>
                    @if($order->notes)
                        <p style="font-size:0.85rem;color:var(--text-light);margin-top:8px;font-style:italic;">Nota:
                            {{ $order->notes }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- PAYMENT INFO -->
            <div>
                <div class="card" style="position:sticky;top:80px;">
                    <div class="card-header">💰 Maklumat Pembayaran</div>

                    @if($order->payment)
                        <div style="margin-bottom:16px;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                                <span style="font-size:0.85rem;color:var(--text-light);">Kaedah</span>
                                <span style="font-weight:600;font-size:0.85rem;">{{ $order->payment->method_label }}</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                                <span style="font-size:0.85rem;color:var(--text-light);">Status</span>
                                <span
                                    style="font-weight:600;font-size:0.85rem;color:{{ $order->payment->status === 'paid' ? 'var(--primary)' : 'var(--secondary)' }};">
                                    {{ $order->payment->status_label }}
                                </span>
                            </div>
                            @if($order->payment->reference_number)
                                <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                                    <span style="font-size:0.85rem;color:var(--text-light);">No. Rujukan</span>
                                    <span
                                        style="font-size:0.8rem;font-family:monospace;">{{ $order->payment->reference_number }}</span>
                                </div>
                            @endif
                            @if($order->payment->paid_at)
                                <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                                    <span style="font-size:0.85rem;color:var(--text-light);">Tarikh Bayar</span>
                                    <span style="font-size:0.85rem;">{{ $order->payment->paid_at->format('d M Y, H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    <hr style="border:1px solid var(--border);margin:12px 0;">

                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:0.9rem;">
                        <span>Subtotal</span>
                        <span>RM {{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:0.9rem;">
                        <span>Penghantaran</span>
                        <span>{{ $order->shipping_fee == 0 ? 'PERCUMA' : 'RM ' . number_format($order->shipping_fee, 2) }}</span>
                    </div>
                    <hr style="border:1px solid var(--border);margin:12px 0;">
                    <div style="display:flex;justify-content:space-between;font-size:1.2rem;font-weight:700;">
                        <span>Jumlah</span>
                        <span style="color:var(--accent);">RM {{ number_format($order->total, 2) }}</span>
                    </div>

                    @if($order->status === 'arrived')
                        <form action="{{ \Illuminate\Support\Facades\URL::signedRoute('orders.confirm', $order) }}"
                            method="POST" style="margin-top:16px;">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">✅ Sahkan
                                Penerimaan</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .container.section>div {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection