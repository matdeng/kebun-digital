@extends('layouts.app')
@section('content')
    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Buah Segar Terus dari Kebun ke Rumah Anda 🍎</h1>
                <p>Nikmati buah-buahan tropika segar berkualiti tinggi. Pesan sekarang, terima esok!</p>
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a href="{{ route('products.index') }}" class="btn btn-white">🛒 Mula Membeli</a>
                    <a href="#categories" class="btn btn-outline" style="color:white;border-color:rgba(255,255,255,0.5);">📂
                        Lihat Kategori</a>
                </div>
                <div style="display:flex;gap:30px;margin-top:30px;">
                    <div><strong style="font-size:1.5rem">20+</strong><br><small style="opacity:0.8">Jenis Buah</small>
                    </div>
                    <div><strong style="font-size:1.5rem">100%</strong><br><small style="opacity:0.8">Segar</small></div>
                    <div><strong style="font-size:1.5rem">🚚</strong><br><small style="opacity:0.8">Penghantaran
                            Pantas</small></div>
                </div>
            </div>
            <div class="hero-emoji">🥭🍊🍇</div>
        </div>
    </section>

    <!-- ORDER TRACKING -->
    <section class="section" style="background:#f8fffe;padding:30px 0;border-bottom:1px solid #e8f5e9;">
        <div class="container">
            <div class="card"
                style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:20px;padding:30px;background:white;border:1px solid #e8f5e9;">
                <div style="flex:1;min-width:300px;">
                    <h3 style="font-size:1.2rem;margin-bottom:8px;">🚚 Semak Status Pesanan</h3>
                    <p style="color:var(--text-light);font-size:0.9rem;">Masukkan nombor pesanan anda (contoh:
                        KD-20260219-0001) untuk menyemak status terkini.</p>
                </div>
                <form action="{{ route('orders.track') }}" method="GET"
                    style="flex:1;display:flex;gap:10px;min-width:300px;">
                    <input type="text" name="order_number" placeholder="Nombor Pesanan..." required
                        style="flex:1;padding:12px;border:2px solid var(--border);border-radius:8px;outline:none;">
                    <button type="submit" class="btn btn-primary">Semak</button>
                </form>
            </div>
        </div>
    </section>

    <!-- CATEGORIES -->
    <section class="section" id="categories">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Kategori Buah</h2>
                <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">Lihat Semua →</a>
            </div>
            <div class="category-grid">
                @php
                    $icons = ['buah-tropika' => '🥭', 'buah-tempatan' => '🍌', 'buah-import' => '🍎', 'buah-bermusim' => '🍑', 'buah-organik' => '🥝', 'pek-bundle' => '📦'];
                @endphp
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="category-card">
                        <div class="category-icon">{{ $icons[$category->slug] ?? '🍇' }}</div>
                        <h3>{{ $category->name }}</h3>
                        <p>{{ $category->active_products_count }} produk</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FEATURED PRODUCTS -->
    <section class="section" style="background:white;padding:40px 0;">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">⭐ Produk Pilihan</h2>
                <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">Lihat Semua →</a>
            </div>
            <div class="product-grid">
                @foreach($featuredProducts as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                        <div class="product-card-img">
                            @if($product->getFirstMediaUrl('product_image'))
                                <img src="{{ $product->getFirstMediaUrl('product_image') }}" alt="{{ $product->name }}">
                            @else
                                🍉
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
        </div>
    </section>

    <!-- LATEST PRODUCTS -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">🆕 Terbaru</h2>
            </div>
            <div class="product-grid">
                @foreach($latestProducts as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                        <div class="product-card-img">
                            @if($product->getFirstMediaUrl('product_image'))
                                <img src="{{ $product->getFirstMediaUrl('product_image') }}" alt="{{ $product->name }}">
                            @else
                                🍊
                            @endif
                        </div>
                        <div class="product-card-body">
                            <h3>{{ $product->name }}</h3>
                            <p class="product-category">{{ $product->category->name }}</p>
                            <p class="product-price">RM {{ number_format($product->price, 2) }} <span class="product-unit">/
                                    {{ $product->unit }}</span></p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE US -->
    <section class="section" style="background:white;padding:50px 0;">
        <div class="container">
            <h2 class="section-title" style="justify-content:center;margin-bottom:36px;">Kenapa Pilih Kebun Digital?</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:24px;">
                <div class="card" style="text-align:center;border:2px solid var(--border);">
                    <div style="font-size:2.5rem;margin-bottom:12px;">🌿</div>
                    <h3 style="font-size:1rem;margin-bottom:8px;">100% Segar</h3>
                    <p style="font-size:0.85rem;color:var(--text-light);">Buah dipetik dan dihantar terus dari kebun</p>
                </div>
                <div class="card" style="text-align:center;border:2px solid var(--border);">
                    <div style="font-size:2.5rem;margin-bottom:12px;">🚚</div>
                    <h3 style="font-size:1rem;margin-bottom:8px;">Penghantaran Pantas</h3>
                    <p style="font-size:0.85rem;color:var(--text-light);">Sampai dalam masa 1-2 hari bekerja</p>
                </div>
                <div class="card" style="text-align:center;border:2px solid var(--border);">
                    <div style="font-size:2.5rem;margin-bottom:12px;">💰</div>
                    <h3 style="font-size:1rem;margin-bottom:8px;">Harga Berpatutan</h3>
                    <p style="font-size:0.85rem;color:var(--text-light);">Harga kilang terus untuk anda</p>
                </div>
                <div class="card" style="text-align:center;border:2px solid var(--border);">
                    <div style="font-size:2.5rem;margin-bottom:12px;">✅</div>
                    <h3 style="font-size:1rem;margin-bottom:8px;">Jaminan Kualiti</h3>
                    <p style="font-size:0.85rem;color:var(--text-light);">Pulangan wang jika tidak berpuas hati</p>
                </div>
            </div>
        </div>
    </section>
@endsection