@extends('layouts.admin')
@section('content')
    <div class="top-bar">
        <h1>➕ Tambah Kategori</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
    <div class="card">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Nama Kategori *</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label>Penerangan</label>
                <textarea name="description" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <label style="display:flex;align-items:center;gap:8px;margin-bottom:16px;cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    style="transform:scale(1.3);">
                <span>Aktif</span>
            </label>
            <button type="submit" class="btn btn-primary">✅ Simpan</button>
        </form>
    </div>
@endsection