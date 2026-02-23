@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pengurusan Pelanggan</h1>
        </div>

        <!-- Filters -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'all' ? 'active' : '' }}"
                            href="{{ route('admin.customers.index', ['type' => 'all']) }}">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'registered' ? 'active' : '' }}"
                            href="{{ route('admin.customers.index', ['type' => 'registered']) }}">Berdaftar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'guest' ? 'active' : '' }}"
                            href="{{ route('admin.customers.index', ['type' => 'guest']) }}">Tetamu (Guest)</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Senarai Pelanggan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
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
                                    <td>{{ $customer['name'] }}</td>
                                    <td>{{ $customer['email'] }}</td>
                                    <td>{{ $customer['phone'] ?? '-' }}</td>
                                    <td>
                                        @if($customer['type'] === 'registered')
                                            <span class="badge badge-success">Berdaftar</span>
                                        @else
                                            <span class="badge badge-warning">Tetamu</span>
                                        @endif
                                    </td>
                                    <td>{{ $customer['total_orders'] }}</td>
                                    <td>{{ $customer['last_order'] ? \Carbon\Carbon::parse($customer['last_order'])->format('d M Y H:i') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tiada pelanggan ditemui.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $paginatedCustomers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection