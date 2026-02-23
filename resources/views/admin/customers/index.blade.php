@extends('layouts.admin')

@section('content')
    <div class="top-bar" style="display:flex;justify-content:space-between;align-items:center;">
        <h1>👥 Pengurusan Pelanggan</h1>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom:16px;">
        <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
            <a href="{{ route('admin.customers.index', ['type' => 'all']) }}"
                class="btn {{ $type === 'all' ? 'btn-primary' : 'btn-outline' }}">Semua</a>
            <a href="{{ route('admin.customers.index', ['type' => 'registered']) }}"
                class="btn {{ $type === 'registered' ? 'btn-primary' : 'btn-outline' }}">Berdaftar</a>
            <a href="{{ route('admin.customers.index', ['type' => 'guest']) }}"
                class="btn {{ $type === 'guest' ? 'btn-primary' : 'btn-outline' }}">Tetamu (Guest)</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span>📋 Senarai Pelanggan</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Emel</th>
                    <th>No. Telefon</th>
                    <th>Jenis</th>
                    <th>Jumlah Pesanan</th>
                    <th>Pesanan Terakhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paginatedCustomers as $customer)
                    <tr>
                        <td><strong>{{ $customer['name'] }}</strong></td>
                        <td>{{ $customer['email'] }}</td>
                        <td>{{ $customer['phone'] ?? '-' }}</td>
                        <td>
                            @if($customer['type'] === 'registered')
                                <span class="status-badge" style="background:#e8f5e9;color:#27ae60;">Berdaftar</span>
                            @else
                                <span class="status-badge" style="background:#fff3e0;color:#f39c12;">Tetamu</span>
                            @endif
                        </td>
                        <td style="font-weight:600;">{{ $customer['total_orders'] }}</td>
                        <td style="font-size:0.8rem;">
                            {{ $customer['last_order'] ? \Carbon\Carbon::parse($customer['last_order'])->format('d/m/Y H:i') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:30px;color:var(--text-light);">Tiada pelanggan ditemui.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $paginatedCustomers->withQueryString()->links() }}</div>
    </div>
@endsection