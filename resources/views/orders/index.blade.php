@extends('layouts.app')
@section('content')
    <div class="container section">
        <h2 class="section-title" style="margin-bottom:24px;">📦 Pesanan Saya</h2>

        <!-- TABS -->
        <div class="tabs">
            <a href="{{ route('orders.index', ['status' => 'all']) }}" class="tab {{ $status == 'all' ? 'active' : '' }}">
                Semua
            </a>
            <a href="{{ route('orders.index', ['status' => 'to_pay']) }}"
                class="tab {{ $status == 'to_pay' ? 'active' : '' }}">
                💰 Belum Bayar
                @if($statusCounts['to_pay'] > 0)
                    <span class="tab-count">{{ $statusCounts['to_pay'] }}</span>
                @endif
            </a>
            <a href="{{ route('orders.index', ['status' => 'to_ship']) }}"
                class="tab {{ $status == 'to_ship' ? 'active' : '' }}">
                📦 Sedang Diproses
                @if($statusCounts['to_ship'] > 0)
                    <span class="tab-count">{{ $statusCounts['to_ship'] }}</span>
                @endif
            </a>
            <a href="{{ route('orders.index', ['status' => 'to_receive']) }}"
                class="tab {{ $status == 'to_receive' ? 'active' : '' }}">
                🚚 Dalam Penghantaran
                @if($statusCounts['to_receive'] > 0)
                    <span class="tab-count">{{ $statusCounts['to_receive'] }}</span>
                @endif
            </a>
            <a href="{{ route('orders.index', ['status' => 'arrived']) }}"
                class="tab {{ $status == 'arrived' ? 'active' : '' }}">
                ✅ Telah Sampai
                @if($statusCounts['arrived'] > 0)
                    <span class="tab-count">{{ $statusCounts['arrived'] }}</span>
                @endif
            </a>
        </div>

        <!-- ORDERS LIST -->
        @if($orders->isEmpty())
            <div class="card" style="text-align:center;padding:60px;">
                <div style="font-size:5rem;margin-bottom:16px;">📭</div>
                <h3>Tiada pesanan</h3>
                <p style="color:var(--text-light);margin:8px 0 20px;">Anda belum membuat sebarang pesanan lagi.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">🛒 Mula Membeli</a>
            </div>
        @else
            @foreach($orders as $order)
                <div class="card" style="margin-bottom:16px;">
                    <!-- ORDER HEADER -->
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <strong style="font-size:0.9rem;">{{ $order->order_number }}</strong>
                            <span
                                style="font-size:0.75rem;color:var(--text-light);">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <span class="status-badge"
                            style="background:{{ $order->status_color }}22;color:{{ $order->status_color }};">
                            {{ $order->status_label }}
                        </span>
                    </div>

                    <!-- ORDER ITEMS -->
                    @foreach($order->items->take(2) as $item)
                        <div style="display:flex;gap:12px;align-items:center;margin-bottom:8px;">
                            <div
                                style="width:60px;height:60px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:2rem;flex-shrink:0;">
                                @if($item->product && $item->product->getFirstMediaUrl('product_image'))
                                    <img src="{{ $item->product->getFirstMediaUrl('product_image') }}"
                                        style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                                @else
                                    🍊
                                @endif
                            </div>
                            <div style="flex:1;">
                                <p style="font-mass:0.9rem;font-weight:600;">{{ $item->product_name }}</p>
                                <p style="font-size:0.8rem;color:var(--text-light);">x{{ $item->quantity }}</p>
                            </div>
                            <p style="font-weight:600;color:var(--text);">RM {{ number_format($item->subtotal, 2) }}</p>
                        </div>
                    @endforeach

                    @if($order->items->count() > 2)
                        <p style="font-size:0.8rem;color:var(--text-light);margin-bottom:8px;">+ {{ $order->items->count() - 2 }} produk
                            lain</p>
                    @endif

                    <!-- ORDER FOOTER -->
                    <div
                        style="display:flex;justify-content:space-between;align-items:center;padding-top:12px;border-top:1px solid var(--border);">
                        <div>
                            <span style="font-size:0.8rem;color:var(--text-light);">Jumlah Pesanan: </span>
                            <span style="font-weight:700;color:var(--accent);font-size:1.1rem;">RM
                                {{ number_format($order->total, 2) }}</span>
                        </div>
                        <div style="display:flex;gap:8px;">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline btn-sm">Lihat Butiran</a>
                            @if($order->status === 'arrived')
                                <form action="{{ route('orders.confirm', $order) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">✅ Terima Pesanan</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="pagination">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection