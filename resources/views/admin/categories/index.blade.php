@extends('layouts.admin')
@section('content')
    <div class="top-bar">
        <h1>📂 Pengurusan Kategori</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">➕ Tambah Kategori</a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Produk</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td style="font-family:monospace;font-size:0.8rem;">{{ $category->slug }}</td>
                        <td>{{ $category->products_count }} produk</td>
                        <td>
                            <span class="status-badge"
                                style="background:{{ $category->is_active ? '#e8f5e9' : '#ffebee' }};color:{{ $category->is_active ? '#27ae60' : '#e74c3c' }};">
                                {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline btn-sm">✏️
                                    Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    onsubmit="return confirm('Padam kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:30px;color:var(--text-light);">Tiada kategori</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection