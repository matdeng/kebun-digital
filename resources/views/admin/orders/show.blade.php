@extends('layouts.admin')
@section('content')
    <div class="top-bar">
        <div>
            <h1>📦 Pesanan {{ $order->order_number }}</h1>
            @if($order->receipt_number)
                <p style="font-size:0.85rem;color:var(--text-light);margin-top:4px;">📄 Resit:
                    <strong>{{ $order->receipt_number }}</strong>
                </p>
            @endif
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">← Kembali</a>
    </div>

    <div style="display:grid;grid-template-columns:1fr 350px;gap:24px;">
        <!-- LEFT: ITEMS + SHIPPING -->
        <div>
            <!-- STATUS UPDATE -->
            <div class="card" style="margin-bottom:16px;">
                <div class="card-header">📊 Status Pesanan</div>
                <div style="display:flex;gap:12px;align-items:center;margin-bottom:16px;">
                    <span class="status-badge"
                        style="background:{{ $order->status_color }}22;color:{{ $order->status_color }};font-size:0.95rem;padding:8px 20px;">
                        {{ $order->status_label }}
                    </span>
                    <span
                        style="font-size:0.85rem;color:var(--text-light);">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>

                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST"
                    style="display:flex;gap:10px;align-items:end;">
                    @csrf
                    @method('PATCH')
                    <div class="form-group" style="flex:1;margin-bottom:0;">
                        <label>Kemaskini Status</label>
                        <select name="status">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="to_pay" {{ $order->status == 'to_pay' ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="to_ship" {{ $order->status == 'to_ship' ? 'selected' : '' }}>Sedang Diproses
                            </option>
                            <option value="to_receive" {{ $order->status == 'to_receive' ? 'selected' : '' }}>Dalam
                                Penghantaran
                            </option>
                            <option value="arrived" {{ $order->status == 'arrived' ? 'selected' : '' }}>Telah Sampai</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="height:42px;">💾 Kemaskini</button>
                </form>
            </div>

            <!-- ORDER ITEMS -->
            <div class="card" style="margin-bottom:16px;">
                <div class="card-header">📋 Item Pesanan</div>
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Kuantiti</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product_name }}</strong>
                                </td>
                                <td>RM {{ number_format($item->product_price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td style="font-weight:600;">RM {{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- SHIPPING INFO -->
            <div class="card">
                <div class="card-header">📍 Maklumat Penghantaran</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <p style="font-size:0.8rem;color:var(--text-light);">Penerima</p>
                        <p style="font-weight:600;">{{ $order->recipient_name }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.8rem;color:var(--text-light);">Telefon</p>
                        <p style="font-weight:600;">{{ $order->phone }}</p>
                    </div>
                </div>
                <div style="margin-top:12px;">
                    <p style="font-size:0.8rem;color:var(--text-light);">Alamat</p>
                    <p>{{ $order->shipping_address }}</p>
                </div>
                @if($order->notes)
                    <div style="margin-top:12px;padding:12px;background:#f8f9fa;border-radius:8px;">
                        <p style="font-size:0.8rem;color:var(--text-light);">Nota</p>
                        <p style="font-style:italic;">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT: PAYMENT SUMMARY -->
        <div>
            <div class="card" style="position:sticky;top:24px;">
                <div class="card-header">💰 Maklumat Pembayaran</div>
                @if($order->payment)
                    <div style="margin-bottom:16px;">
                        <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                            <span style="color:var(--text-light);font-size:0.85rem;">Kaedah</span>
                            <span style="font-weight:600;">{{ $order->payment->method_label }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                            <span style="color:var(--text-light);font-size:0.85rem;">Status Bayaran</span>
                            <span class="status-badge"
                                style="background:{{ $order->payment->status === 'paid' ? '#e8f5e9' : '#fff3e0' }};color:{{ $order->payment->status === 'paid' ? '#27ae60' : '#e49b0f' }};">
                                {{ $order->payment->status_label }}
                            </span>
                        </div>
                        @if($order->payment->reference_number)
                            <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                                <span style="color:var(--text-light);font-size:0.85rem;">No. Rujukan</span>
                                <span style="font-family:monospace;font-size:0.8rem;">{{ $order->payment->reference_number }}</span>
                            </div>
                        @endif
                        @if($order->payment->paid_at)
                            <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                                <span style="color:var(--text-light);font-size:0.85rem;">Tarikh Bayar</span>
                                <span style="font-size:0.85rem;">{{ $order->payment->paid_at->format('d M Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <hr style="border:1px solid #f0f0f0;margin:16px 0;">

                <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.9rem;">
                    <span>Subtotal</span>
                    <span>RM {{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.9rem;">
                    <span>Penghantaran</span>
                    <span>{{ $order->shipping_fee == 0 ? 'PERCUMA' : 'RM ' . number_format($order->shipping_fee, 2) }}</span>
                </div>
                <hr style="border:1px solid #f0f0f0;margin:12px 0;">
                <div style="display:flex;justify-content:space-between;font-size:1.2rem;font-weight:800;">
                    <span>Jumlah</span>
                    <span style="color:var(--accent);">RM {{ number_format($order->total, 2) }}</span>
                </div>

                <!-- CUSTOMER INFO -->
                <div style="margin-top:24px;padding-top:16px;border-top:1px solid #f0f0f0;">
                    <p style="font-weight:600;font-size:0.85rem;margin-bottom:8px;">👤 Pelanggan</p>
                    <p>{{ $order->getCustomerName() ?? 'N/A' }}</p>
                    <p style="font-size:0.85rem;color:var(--text-light);">{{ $order->getCustomerEmail() ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection