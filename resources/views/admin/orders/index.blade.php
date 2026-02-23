@extends('layouts.admin')
@section('content')
    <div class="top-bar" style="display:flex;justify-content:space-between;align-items:center;">
        <h1>📦 Pengurusan Pesanan</h1>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">＋ Buat Pesanan Baru</a>
    </div>

    <!-- FILTERS -->
    <div class="card" style="margin-bottom:16px;">
        <form action="{{ route('admin.orders.index') }}" method="GET"
            style="display:flex;gap:12px;flex-wrap:wrap;align-items:end;">
            <div class="form-group" style="flex:1;min-width:200px;margin-bottom:0;">
                <input type="text" name="search" placeholder="Cari no. pesanan / pelanggan..."
                    value="{{ request('search') }}">
            </div>
            <div class="form-group" style="min-width:160px;margin-bottom:0;">
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="to_pay" {{ request('status') == 'to_pay' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="to_ship" {{ request('status') == 'to_ship' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="to_receive" {{ request('status') == 'to_receive' ? 'selected' : '' }}>Dalam Penghantaran
                    </option>
                    <option value="arrived" {{ request('status') == 'arrived' ? 'selected' : '' }}>Telah Sampai</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">🔍 Cari</button>
        </form>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan / Resit</th>
                    <th>Pelanggan</th>
                    <th>Item</th>
                    <th>Jumlah</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Tarikh</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong>{{ $order->order_number }}</strong>
                            @if($order->receipt_number)
                                <div style="font-size:0.7rem;color:var(--text-light);">{{ $order->receipt_number }}</div>
                            @endif
                        </td>
                        <td>
                            <div>{{ $order->getCustomerName() ?? 'N/A' }}</div>
                            <div style="font-size:0.75rem;color:var(--text-light);">{{ $order->getCustomerEmail() }}</div>
                            <div style="font-size:0.75rem;color:var(--text-light);">{{ $order->phone }}</div>
                        </td>
                        <td>{{ $order->items_count ?? $order->items->count() }} item</td>
                        <td style="font-weight:700;">RM {{ number_format($order->total, 2) }}</td>
                        <td>
                            @if($order->payment)
                                <div style="font-size:0.8rem;">{{ $order->payment->method_label }}</div>
                                <span class="status-badge"
                                    style="background:{{ $order->payment->status === 'paid' ? '#e8f5e9' : '#fff3e0' }};color:{{ $order->payment->status === 'paid' ? '#27ae60' : '#f39c12' }};font-size:0.7rem;">
                                    {{ $order->payment->status_label }}
                                </span>
                            @else
                                <span style="color:var(--text-light);font-size:0.8rem;">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge"
                                style="background:{{ $order->status_color }}22;color:{{ $order->status_color }};">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td style="font-size:0.8rem;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm">Lihat</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:30px;color:var(--text-light);">Tiada pesanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $orders->withQueryString()->links() }}</div>
    </div>
@endsection