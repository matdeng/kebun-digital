@extends('layouts.app')
@section('content')
    <div class="container section">
        <div class="section-header">
            <h2 class="section-title">🍉 Semua Produk</h2>
        </div>

        <!-- FILTERS -->
        <div class="card" style="margin-bottom:24px;">
            <form action="{{ route('products.index') }}" method="GET"
                style="display:flex;gap:12px;flex-wrap:wrap;align-items:end;">
                <div class="form-group" style="flex:1;min-width:200px;margin-bottom:0;">
                    <label>Cari</label>
                    <input type="text" name="search" placeholder="Cari buah..." value="{{ request('search') }}">
                </div>
                <div class="form-group" style="min-width:180px;margin-bottom:0;">
                    <label>Kategori</label>
                    <select name="category">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="min-width:160px;margin-bottom:0;">
                    <label>Susun</label>
                    <select name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah
                        </option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi
                        </option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>A-Z</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm" style="height:42px;">🔍 Cari</button>
                @if(request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm" style="height:42px;">✖ Reset</a>
                @endif
            </form>
        </div>

        <!-- PRODUCTS GRID -->
        @if($products->isEmpty())
            <div class="card" style="text-align:center;padding:60px;">
                <div style="font-size:4rem;margin-bottom:16px;">🔍</div>
                <h3>Tiada produk dijumpai</h3>
                <p style="color:var(--text-light);margin-top:8px;">Cuba cari dengan kata kunci lain.</p>
            </div>
        @else
            <div class="product-grid">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                        <div class="product-card-img">
                            @if($product->getFirstMediaUrl('product_image'))
                                <img src="{{ $product->getFirstMediaUrl('product_image') }}" alt="{{ $product->name }}">
                            @else
                                🍊
                            @endif
                            @if($product->is_featured)
                                <span class="product-badge">⭐ Pilihan</span>
                            @endif
                        </div>
                        <div class="product-card-body">
                            <h3>{{ $product->name }}</h3>
                            <p class="product-category">{{ $product->category->name }}</p>
                            <p class="product-price">RM {{ number_format($product->price, 2) }} <span class="product-unit">/
                                    {{ $product->unit }}</span></p>
                            <p class="product-stock">Stok: {{ $product->stock }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div class="pagination">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection