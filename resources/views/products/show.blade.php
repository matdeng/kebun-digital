@extends('layouts.app')
@section('content')
    <div class="container section">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:30px;">
            <!-- PRODUCT IMAGES -->
            <div class="card"
                style="display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:400px;gap:12px;">
                @if($product->getMedia('product_image')->count())
                    <img id="mainImage" src="{{ $product->getFirstMediaUrl('product_image') }}" alt="{{ $product->name }}"
                        style="max-width:100%;max-height:350px;object-fit:contain;border-radius:8px;">
                    @if($product->getMedia('product_image')->count() > 1)
                        <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:center;">
                            @foreach($product->getMedia('product_image') as $media)
                                <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}"
                                    onclick="document.getElementById('mainImage').src='{{ $media->getUrl() }}'"
                                    style="width:60px;height:60px;object-fit:cover;border-radius:6px;border:2px solid #e8f5e9;cursor:pointer;transition:border-color 0.2s;"
                                    onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='#e8f5e9'">
                            @endforeach
                        </div>
                    @endif
                @else
                    <div style="font-size:10rem;">🍉</div>
                @endif
            </div>

            <!-- PRODUCT INFO -->
            <div>
                <nav style="font-size:0.8rem;color:var(--text-light);margin-bottom:12px;">
                    <a href="{{ route('home') }}" style="color:var(--primary);text-decoration:none;">Laman Utama</a> /
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                        style="color:var(--primary);text-decoration:none;">{{ $product->category->name }}</a> /
                    {{ $product->name }}
                </nav>

                <h1 style="font-size:1.8rem;font-weight:800;margin-bottom:8px;">{{ $product->name }}</h1>

                <p style="color:var(--text-light);font-size:0.85rem;margin-bottom:16px;">
                    Kategori: <span style="color:var(--primary);font-weight:600;">{{ $product->category->name }}</span>
                </p>

                <div
                    style="background:linear-gradient(135deg,#fff5f5,#ffeee6);padding:20px;border-radius:12px;margin-bottom:20px;">
                    <span style="font-size:2rem;font-weight:800;color:var(--accent);">RM
                        {{ number_format($product->price, 2) }}</span>
                    <span style="font-size:0.9rem;color:var(--text-light);">/ {{ $product->unit }}</span>
                </div>

                <p style="margin-bottom:20px;line-height:1.8;color:#555;">{{ $product->description }}</p>

                <div style="display:flex;gap:16px;margin-bottom:20px;">
                    <div class="card" style="flex:1;text-align:center;padding:16px;">
                        <div
                            style="font-size:1.2rem;font-weight:700;color:{{ $product->stock > 10 ? 'var(--primary)' : 'var(--accent)' }}">
                            {{ $product->stock }}
                        </div>
                        <div style="font-size:0.75rem;color:var(--text-light);">Stok Tersedia</div>
                    </div>
                    <div class="card" style="flex:1;text-align:center;padding:16px;">
                        <div style="font-size:1.2rem;font-weight:700;color:var(--primary);">{{ $product->unit }}</div>
                        <div style="font-size:0.75rem;color:var(--text-light);">Unit Jualan</div>
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" style="display:flex;gap:12px;align-items:end;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="form-group" style="width:100px;margin-bottom:0;">
                        <label>Kuantiti</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                            style="text-align:center;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;">
                        🛒 Tambah ke Troli
                    </button>
                </form>
                @guest
                    <div style="margin-top:12px;font-size:0.85rem;color:var(--text-light);text-align:center;">
                        Sudah ada akaun? <a href="{{ route('login') }}"
                            style="color:var(--primary);text-decoration:none;font-weight:600;">Log Masuk</a> untuk kumpul mata
                        ganjaran
                    </div>
                @endguest
            </div>
        </div>

        <!-- RELATED PRODUCTS -->
        @if($relatedProducts->count() > 0)
            <div class="section">
                <h2 class="section-title">Produk Berkaitan</h2>
                <div class="product-grid" style="margin-top:20px;">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', $related->slug) }}" class="product-card">
                            <div class="product-card-img">
                                @if($related->getFirstMediaUrl('product_image'))
                                    <img src="{{ $related->getFirstMediaUrl('product_image') }}" alt="{{ $related->name }}">
                                @else
                                    🍊
                                @endif
                            </div>
                            <div class="product-card-body">
                                <h3>{{ $related->name }}</h3>
                                <p class="product-price">RM {{ number_format($related->price, 2) }} <span class="product-unit">/
                                        {{ $related->unit }}</span></p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <style>
        @media (max-width: 768px) {
            .container.section>div:first-child {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection