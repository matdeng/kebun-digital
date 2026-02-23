@extends('layouts.admin')
@section('content')
    <div class="top-bar">
        <h1>✏️ Edit Produk: {{ $product->name }}</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline">← Kembali</a>
    </div>

    {{-- Image gallery & individual delete (outside main form) --}}
    @if($product->getMedia('product_image')->count())
        <div class="card" style="margin-bottom:16px;">
            <label style="font-weight:600;margin-bottom:12px;display:block;">📸 Gambar Semasa
                ({{ $product->getMedia('product_image')->count() }})</label>
            <div style="display:flex;flex-wrap:wrap;gap:12px;">
                @foreach($product->getMedia('product_image') as $media)
                    <div style="position:relative;width:100px;height:100px;">
                        <img src="{{ $media->getUrl() }}"
                            style="width:100%;height:100%;object-fit:cover;border-radius:8px;border:2px solid #e8f5e9;">
                        <form action="{{ route('admin.products.delete-image', [$product, $media->id]) }}" method="POST"
                            onsubmit="return confirm('Padam gambar ini?')" style="position:absolute;top:-6px;right:-6px;">
                            @csrf @method('DELETE')
                            <button type="submit"
                                style="background:#e74c3c;color:#fff;border:none;border-radius:50%;width:24px;height:24px;cursor:pointer;font-size:12px;line-height:24px;padding:0;">✕</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label>Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="category_id" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga (RM) *</label>
                    <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}"
                        required>
                </div>
                <div class="form-group">
                    <label>Unit *</label>
                    <select name="unit" required>
                        <option value="kg" {{ old('unit', $product->unit) == 'kg' ? 'selected' : '' }}>kg</option>
                        <option value="pcs" {{ old('unit', $product->unit) == 'pcs' ? 'selected' : '' }}>pcs</option>
                        <option value="pack" {{ old('unit', $product->unit) == 'pack' ? 'selected' : '' }}>pack</option>
                        <option value="sikat" {{ old('unit', $product->unit) == 'sikat' ? 'selected' : '' }}>sikat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Stok *</label>
                    <input type="number" name="stock" min="0" value="{{ old('stock', $product->stock) }}" required>
                </div>
                <div class="form-group">
                    <label>Tambah Gambar</label>
                    <input type="file" name="images[]" accept="image/*" multiple>
                    <p style="font-size:0.8rem;color:#888;margin-top:4px;">Boleh pilih beberapa gambar sekaligus</p>
                </div>
            </div>
            <div class="form-group">
                <label>Penerangan</label>
                <textarea name="description" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>
            <div style="display:flex;gap:20px;margin-bottom:16px;">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} style="transform:scale(1.3);">
                    <span>Aktif</span>
                </label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} style="transform:scale(1.3);">
                    <span>Produk Pilihan ⭐</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">💾 Kemaskini Produk</button>
        </form>
    </div>
@endsection