@extends('layouts.admin')
@section('content')
    <div class="top-bar">
        <h1>✏️ Edit Kategori: {{ $category->name }}</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
    <div class="card">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Kategori *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
            </div>
            <div class="form-group">
                <label>Penerangan</label>
                <textarea name="description" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <label style="display:flex;align-items:center;gap:8px;margin-bottom:16px;cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} style="transform:scale(1.3);">
                <span>Aktif</span>
            </label>
            <button type="submit" class="btn btn-primary">💾 Kemaskini</button>
        </form>
    </div>
@endsection