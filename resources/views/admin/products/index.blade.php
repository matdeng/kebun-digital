@extends('layouts.admin')
@section('content')
    <div class="top-bar">
        <h1>🍊 Pengurusan Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">➕ Tambah Produk</a>
    </div>

    <!-- FILTERS -->
    <div class="card" style="margin-bottom:16px;">
        <form action="{{ route('admin.products.index') }}" method="GET"
            style="display:flex;gap:12px;flex-wrap:wrap;align-items:end;">
            <div class="form-group" style="flex:1;min-width:200px;margin-bottom:0;">
                <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
            </div>
            <div class="form-group" style="min-width:180px;margin-bottom:0;">
                <select name="category">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">🔍 Cari</button>
        </form>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div
                                    style="width:40px;height:40px;background:#e8f5e9;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    @if($product->getFirstMediaUrl('product_image'))
                                        <img src="{{ $product->getFirstMediaUrl('product_image') }}"
                                            style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                                    @else
                                        🍊
                                    @endif
                                </div>
                                <div>
                                    <strong>{{ $product->name }}</strong>
                                    @if($product->is_featured) <span style="font-size:0.7rem;color:#f39c12;">⭐</span> @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td style="font-weight:600;">RM {{ number_format($product->price, 2) }}/{{ $product->unit }}</td>
                        <td>
                            <span
                                style="color:{{ $product->stock > 10 ? 'var(--primary-dark)' : 'var(--accent)' }};font-weight:600;">{{ $product->stock }}</span>
                        </td>
                        <td>
                            <span class="status-badge"
                                style="background:{{ $product->is_active ? '#e8f5e9' : '#ffebee' }};color:{{ $product->is_active ? '#27ae60' : '#e74c3c' }};">
                                {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline btn-sm">✏️
                                    Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('Padam produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:30px;color:var(--text-light);">Tiada produk</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $products->withQueryString()->links() }}</div>
    </div>
@endsection