@extends('layouts.admin')
@section('content')
    <div class="top-bar">
        <h1>📊 Dashboard</h1>
        <span style="font-size:0.85rem;color:var(--text-light);">{{ now()->format('d M Y, H:i') }}</span>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f5e9;">📦</div>
            <div>
                <div class="stat-value">{{ $stats['total_orders'] }}</div>
                <div class="stat-label">Jumlah Pesanan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff3e0;">💰</div>
            <div>
                <div class="stat-value">RM {{ number_format($stats['total_revenue'], 2) }}</div>
                <div class="stat-label">Jumlah Hasil</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#e3f2fd;">🍊</div>
            <div>
                <div class="stat-value">{{ $stats['total_products'] }}</div>
                <div class="stat-label">Produk</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce4ec;">👥</div>
            <div>
                <div class="stat-value">{{ $stats['total_customers'] }}</div>
                <div class="stat-label">Pelanggan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff8e1;">⏳</div>
            <div>
                <div class="stat-value">{{ $stats['pending_orders'] }}</div>
                <div class="stat-label">Pesanan Tertangguh</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#e0f7fa;">📅</div>
            <div>
                <div class="stat-value">{{ $stats['today_orders'] }}</div>
                <div class="stat-label">Pesanan Hari Ini</div>
            </div>
        </div>
    </div>

    <!-- RECENT ORDERS -->
    <div class="card">
        <div class="card-header">
            <span>📋 Pesanan Terkini</span>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">Lihat Semua →</a>
        </div>
        @if($recentOrders->isEmpty())
            <p style="text-align:center;padding:30px;color:var(--text-light);">Tiada pesanan lagi</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Jumlah</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Tarikh</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->getCustomerName() ?? 'N/A' }}</td>
                            <td style="font-weight:600;">RM {{ number_format($order->total, 2) }}</td>
                            <td>{{ $order->payment->method_label ?? 'N/A' }}</td>
                            <td>
                                <span class="status-badge"
                                    style="background:{{ $order->status_color }}22;color:{{ $order->status_color }};">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm">Lihat</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection