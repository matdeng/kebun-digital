@extends('layouts.app')
@section('content')
    <!-- HERO -->
    <section
        class="bg-gradient-to-br from-primary-950 via-primary-900 to-primary-500 py-10 sm:py-16 text-white relative overflow-hidden">
        <div
            class="absolute top-[-50%] right-[-20%] w-[700px] h-[700px] bg-[radial-gradient(circle,rgba(245,158,11,0.08)_0%,transparent_70%)] rounded-full">
        </div>
        <div
            class="absolute bottom-[-30%] left-[-10%] w-[500px] h-[500px] bg-[radial-gradient(circle,rgba(16,185,129,0.1)_0%,transparent_70%)] rounded-full">
        </div>
        <div class="max-w-7xl mx-auto px-5 flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
            <div class="max-w-xl text-center md:text-left">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight mb-4">Buah Segar Terus dari Kebun
                    ke Rumah Anda 🍎</h1>
                <p class="text-base sm:text-lg opacity-90 mb-6">Nikmati buah-buahan tropika segar berkualiti tinggi. Pesan
                    sekarang, terima esok!</p>
                <div class="flex gap-3 flex-wrap justify-center md:justify-start">
                    <a href="{{ route('products.index') }}" class="btn btn-white">🛒 Mula Membeli</a>
                    <a href="#categories" class="btn border-2 border-white/50 text-white hover:bg-white/10">📂 Lihat
                        Kategori</a>
                </div>
                <div class="flex gap-8 mt-8 justify-center md:justify-start">
                    <div><strong class="text-xl sm:text-2xl">20+</strong><br><small class="opacity-80 text-sm">Jenis
                            Buah</small></div>
                    <div><strong class="text-xl sm:text-2xl">100%</strong><br><small
                            class="opacity-80 text-sm">Segar</small></div>
                    <div><strong class="text-xl sm:text-2xl">🚚</strong><br><small class="opacity-80 text-sm">Penghantaran
                            Pantas</small></div>
                </div>
            </div>
            <div class="text-6xl sm:text-8xl animate-float">🥭🍊🍇</div>
        </div>
    </section>

    <!-- ORDER TRACKING -->
    <section class="py-8 bg-primary-50 border-b border-primary-100">
        <div class="max-w-7xl mx-auto px-5">
            <div class="card">
                <div class="mb-4">
                    <h3 class="text-lg font-bold mb-2">🚚 Semak Status Pesanan</h3>
                    <p class="text-slate-500 text-sm">Masukkan nombor pesanan anda (contoh: KD-20260219-0001) untuk menyemak
                        status terkini.</p>
                </div>
                <form action="{{ route('orders.track') }}" method="GET">
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                        <div class="sm:col-span-8">
                            <input type="text" name="order_number" placeholder="Nombor Pesanan..." required
                                class="w-full py-3 px-4 border-2 border-primary-100 rounded-lg outline-none focus:border-primary-500 transition-colors text-sm">
                        </div>
                        <div class="sm:col-span-4">
                            <button type="submit" class="btn btn-primary w-full justify-center">Semak</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- CATEGORIES -->
    <section class="py-8 sm:py-10" id="categories">
        <div class="max-w-7xl mx-auto px-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
                <h2
                    class="text-xl font-bold text-slate-800 flex items-center gap-2.5 before:content-[''] before:w-1 before:h-6 before:bg-primary-500 before:rounded-sm">
                    Kategori Buah</h2>
                <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">Lihat Semua →</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                @php
                    $icons = ['buah-tropika' => '🥭', 'buah-tempatan' => '🍌', 'buah-import' => '🍎', 'buah-bermusim' => '🍑', 'buah-organik' => '🥝', 'pek-bundle' => '📦'];
                @endphp
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                        class="bg-white rounded-card p-5 text-center shadow-card border border-primary-100 no-underline text-slate-800 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-card-hover hover:border-primary-200">
                        <div class="text-4xl mb-2.5">{{ $icons[$category->slug] ?? '🍇' }}</div>
                        <h3 class="text-sm font-semibold mb-1">{{ $category->name }}</h3>
                        <p class="text-xs text-slate-500">{{ $category->active_products_count }} produk</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FEATURED PRODUCTS -->
    <section class="py-8 sm:py-10 bg-white">
        <div class="max-w-7xl mx-auto px-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
                <h2
                    class="text-xl font-bold text-slate-800 flex items-center gap-2.5 before:content-[''] before:w-1 before:h-6 before:bg-primary-500 before:rounded-sm">
                    ⭐ Produk Pilihan</h2>
                <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">Lihat Semua →</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5">
                @foreach($featuredProducts as $product)
                    <a href="{{ route('products.show', $product->slug) }}"
                        class="bg-white rounded-card overflow-hidden shadow-card border border-primary-100 no-underline text-slate-800 block transition-all duration-300 hover:-translate-y-1.5 hover:shadow-card-hover hover:border-primary-200">
                        <div
                            class="w-full h-36 sm:h-44 bg-gradient-to-br from-primary-200 via-primary-100 to-primary-50 flex items-center justify-center text-5xl sm:text-6xl relative">
                            @if($product->getFirstMediaUrl('product_image'))
                                <img src="{{ $product->getFirstMediaUrl('product_image') }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                🍉
                            @endif
                            @if($product->is_featured)
                                <span
                                    class="absolute top-2 left-2 bg-accent-500 text-white text-[0.65rem] font-bold px-2 py-1 rounded">⭐
                                    Pilihan</span>
                            @endif
                        </div>
                        <div class="p-3 sm:p-3.5">
                            <h3 class="text-sm font-semibold mb-1.5 line-clamp-2">{{ $product->name }}</h3>
                            <p class="text-xs text-slate-500 mb-2">{{ $product->category->name }}</p>
                            <p class="text-accent-500 text-base sm:text-lg font-bold">RM {{ number_format($product->price, 2) }}
                                <span class="text-xs text-slate-500 font-normal">/ {{ $product->unit }}</span></p>
                            <p class="text-xs text-slate-500 mt-1">Stok: {{ $product->stock }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- LATEST PRODUCTS -->
    <section class="py-8 sm:py-10">
        <div class="max-w-7xl mx-auto px-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
                <h2
                    class="text-xl font-bold text-slate-800 flex items-center gap-2.5 before:content-[''] before:w-1 before:h-6 before:bg-primary-500 before:rounded-sm">
                    🆕 Terbaru</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5">
                @foreach($latestProducts as $product)
                    <a href="{{ route('products.show', $product->slug) }}"
                        class="bg-white rounded-card overflow-hidden shadow-card border border-primary-100 no-underline text-slate-800 block transition-all duration-300 hover:-translate-y-1.5 hover:shadow-card-hover hover:border-primary-200">
                        <div
                            class="w-full h-36 sm:h-44 bg-gradient-to-br from-primary-200 via-primary-100 to-primary-50 flex items-center justify-center text-5xl sm:text-6xl">
                            @if($product->getFirstMediaUrl('product_image'))
                                <img src="{{ $product->getFirstMediaUrl('product_image') }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                🍊
                            @endif
                        </div>
                        <div class="p-3 sm:p-3.5">
                            <h3 class="text-sm font-semibold mb-1.5 line-clamp-2">{{ $product->name }}</h3>
                            <p class="text-xs text-slate-500 mb-2">{{ $product->category->name }}</p>
                            <p class="text-accent-500 text-base sm:text-lg font-bold">RM {{ number_format($product->price, 2) }}
                                <span class="text-xs text-slate-500 font-normal">/ {{ $product->unit }}</span></p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE US -->
    <section class="py-10 sm:py-12 bg-white">
        <div class="max-w-7xl mx-auto px-5">
            <h2 class="text-xl font-bold text-slate-800 text-center mb-9">Kenapa Pilih Kebun Digital?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="card text-center border-2 border-primary-100">
                    <div class="text-4xl mb-3">🌿</div>
                    <h3 class="text-sm font-bold mb-2">100% Segar</h3>
                    <p class="text-xs text-slate-500">Buah dipetik dan dihantar terus dari kebun</p>
                </div>
                <div class="card text-center border-2 border-primary-100">
                    <div class="text-4xl mb-3">🚚</div>
                    <h3 class="text-sm font-bold mb-2">Penghantaran Pantas</h3>
                    <p class="text-xs text-slate-500">Sampai dalam masa 1-2 hari bekerja</p>
                </div>
                <div class="card text-center border-2 border-primary-100">
                    <div class="text-4xl mb-3">💰</div>
                    <h3 class="text-sm font-bold mb-2">Harga Berpatutan</h3>
                    <p class="text-xs text-slate-500">Harga kilang terus untuk anda</p>
                </div>
                <div class="card text-center border-2 border-primary-100">
                    <div class="text-4xl mb-3">✅</div>
                    <h3 class="text-sm font-bold mb-2">Jaminan Kualiti</h3>
                    <p class="text-xs text-slate-500">Pulangan wang jika tidak berpuas hati</p>
                </div>
            </div>
        </div>
    </section>
@endsection