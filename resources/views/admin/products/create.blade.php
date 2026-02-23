@extends('layouts.admin')
@section('content')
    <div class="top-bar">
        <h1>➕ Tambah Produk Baru</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline">← Kembali</a>
    </div>

    <div class="card">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label>Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="category_id" required>
                        <option value="">Pilih kategori...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga (RM) *</label>
                    <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
                </div>
                <div class="form-group">
                    <label>Unit *</label>
                    <select name="unit" required>
                        <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg</option>
                        <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>pcs</option>
                        <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>pack</option>
                        <option value="sikat" {{ old('unit') == 'sikat' ? 'selected' : '' }}>sikat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Stok *</label>
                    <input type="number" name="stock" min="0" value="{{ old('stock', 0) }}" required>
                </div>
                <div class="form-group">
                    <label>Gambar Produk</label>
                    <input type="file" name="images[]" accept="image/*" multiple>
                    <p style="font-size:0.8rem;color:#888;margin-top:4px;">Boleh pilih beberapa gambar sekaligus</p>
                </div>
            </div>
            <div class="form-group">
                <label>Penerangan</label>
                <textarea name="description" rows="3">{{ old('description') }}</textarea>
            </div>
            <div style="display:flex;gap:20px;margin-bottom:16px;">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        style="transform:scale(1.3);">
                    <span>Aktif</span>
                </label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                        style="transform:scale(1.3);">
                    <span>Produk Pilihan ⭐</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">✅ Simpan Produk</button>
        </form>
    </div>
@endsection