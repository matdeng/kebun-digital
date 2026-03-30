<!DOCTYPE html>
<html lang="ms" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Kebun Digital' }} — Buah Segar Online</title>
    <meta name="description"
        content="Kebun Digital — Platform jualan buah-buahan segar online. Durian, Mangga, dan pelbagai buah tropika terus dari kebun ke rumah anda.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-primary-50 min-h-screen">
    <!-- PROMO BAR -->
    <div
        class="bg-gradient-to-r from-gold-500 via-gold-700 to-gold-500 bg-[length:200%_auto] text-white text-center py-2.5 px-4 text-sm font-semibold animate-shimmer">
        🚚 {{ __("Penghantaran PERCUMA untuk pesanan melebihi RM100!") }}
    </div>

    <!-- NAVBAR -->
    <nav
        class="bg-gradient-to-r from-primary-950 via-primary-900 to-primary-700 sticky top-0 z-50 shadow-[0_4px_30px_rgba(0,0,0,0.15)] backdrop-blur-sm border-b border-white/[0.08]">
        <div class="max-w-7xl mx-auto px-4 sm:px-5 py-3 flex items-center justify-between flex-wrap gap-2">
            <!-- Logo -->
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 no-underline text-white text-lg sm:text-xl font-extrabold">
                <span class="text-2xl">🌿</span> Kebun Digital
            </a>

            <!-- Search -->
            <form class="hidden md:flex flex-1 max-w-md mx-6 relative" action="{{ route('products.index') }}"
                method="GET">
                <input type="text" name="search" placeholder="{{ __('Cari buah-buahan segar...') }}"
                    value="{{ request('search') }}"
                    class="w-full py-2.5 pl-4 pr-10 border-none rounded-lg text-sm outline-none bg-white/95 focus:ring-2 focus:ring-white/30">
                <button type="submit"
                    class="absolute right-1 top-1/2 -translate-y-1/2 bg-primary-500 border-none text-white w-8 h-8 rounded-md cursor-pointer flex items-center justify-center">🔍</button>
            </form>

            <!-- Language Switcher -->
            <div class="flex gap-1 sm:gap-2 mr-1 sm:mr-3">
                <a href="{{ route('set-locale', 'ms') }}"
                    class="no-underline text-base sm:text-lg {{ app()->getLocale() == 'ms' ? 'opacity-100' : 'opacity-50 grayscale' }}"
                    title="Bahasa Melayu">🇲🇾</a>
                <a href="{{ route('set-locale', 'en') }}"
                    class="no-underline text-base sm:text-lg {{ app()->getLocale() == 'en' ? 'opacity-100' : 'opacity-50 grayscale' }}"
                    title="English">🇺🇸</a>
            </div>

            <!-- Nav Actions -->
            <div class="flex items-center gap-1 sm:gap-3">
                <a href="{{ route('cart.index') }}"
                    class="relative text-white no-underline text-sm font-medium flex items-center gap-1.5 px-2 sm:px-3.5 py-2 rounded-lg hover:bg-white/[0.15] transition-all">
                    🛒 <span class="hidden sm:inline">{{ __('Troli') }}</span>
                    @php
                        $query = \App\Models\Cart::query();
                        if (auth()->check()) {
                            $query->where('user_id', auth()->id());
                        } else {
                            $query->where('session_id', session()->getId());
                        }
                        $cartCount = $query->first()?->items->sum('quantity') ?? 0;
                    @endphp
                    @if($cartCount > 0)
                        <div
                            class="absolute -top-1 -right-1 bg-accent-500 text-white text-[0.65rem] font-bold min-w-[18px] h-[18px] flex items-center justify-center rounded-full">
                            {{ $cartCount }}
                        </div>
                    @endif
                </a>

                @auth
                    <a href="{{ route('orders.index') }}"
                        class="text-white no-underline text-sm font-medium flex items-center gap-1.5 px-2 sm:px-3.5 py-2 rounded-lg hover:bg-white/[0.15] transition-all">
                        📦 <span class="hidden sm:inline">{{ __('Pesanan') }}</span>
                    </a>

                    <div class="relative" x-data="{ open: false }">
                        <div @click="open = !open"
                            class="cursor-pointer text-white px-2 sm:px-3.5 py-2 rounded-lg text-sm font-medium flex items-center gap-1.5 hover:bg-white/[0.15] transition-all">
                            👤 <span class="hidden sm:inline">{{ Auth::user()->name }}</span> ▾
                        </div>
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 bg-white min-w-[200px] shadow-card-lg rounded-card py-2 mt-2 border border-primary-100 z-50">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-2.5 px-5 py-2.5 text-sm text-slate-800 hover:bg-gray-50 hover:text-primary-500 transition-colors">👤
                                {{ __('Profil Saya') }}</a>

                            @if(auth()->user()->isAdmin())
                                <div class="h-px bg-primary-100 my-2"></div>
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center gap-2.5 px-5 py-2.5 text-sm text-slate-800 hover:bg-gray-50 hover:text-primary-500 transition-colors">⚙️
                                    {{ __('Lihat Pengurusan') }}</a>
                            @endif

                            <div class="h-px bg-primary-100 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="flex items-center gap-2.5 px-5 py-2.5 text-sm text-accent-500 hover:bg-gray-50 transition-colors">
                                    🚪 {{ __('Keluar') }}
                                </a>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-white no-underline text-sm font-medium flex items-center gap-1.5 px-2 sm:px-3.5 py-2 rounded-lg hover:bg-white/[0.15] transition-all">
                        🔑 <span class="hidden sm:inline">{{ __('Log Masuk') }}</span>
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-register btn-sm">📝 <span
                            class="hidden sm:inline">{{ __('Daftar') }}</span></a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ALERTS -->
    <div class="max-w-7xl mx-auto px-4 sm:px-5 mt-4">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                ❌
                <ul class="m-0 pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- HEADER SLOT -->
    @if(isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-5 py-5">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- CONTENT -->
    @yield('content')
    {{ $slot ?? '' }}

    <!-- FOOTER -->
    <footer
        class="bg-gradient-to-b from-dark to-dark-light text-white/80 pt-12 pb-5 mt-16 border-t-[3px] border-primary-500">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto px-5">
            <div>
                <h4 class="text-white font-bold mb-4">🌿 Kebun Digital</h4>
                <p class="text-sm">Platform jualan buah-buahan segar secara online. Terus dari kebun ke rumah anda.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Pautan Pantas</h4>
                <a href="{{ route('home') }}"
                    class="text-white/70 no-underline text-sm block mb-2 hover:text-primary-500 transition-colors">{{ __('Laman Utama') }}</a>
                <a href="{{ route('products.index') }}"
                    class="text-white/70 no-underline text-sm block mb-2 hover:text-primary-500 transition-colors">{{ __('Semua Produk') }}</a>
                @auth
                    <a href="{{ route('orders.index') }}"
                        class="text-white/70 no-underline text-sm block mb-2 hover:text-primary-500 transition-colors">{{ __('Pesanan Saya') }}</a>
                @endauth
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">{{ __('Kategori') }}</h4>
                <a href="{{ route('products.index', ['category' => 'buah-tropika']) }}"
                    class="text-white/70 no-underline text-sm block mb-2 hover:text-primary-500 transition-colors">Buah
                    Tropika</a>
                <a href="{{ route('products.index', ['category' => 'buah-tempatan']) }}"
                    class="text-white/70 no-underline text-sm block mb-2 hover:text-primary-500 transition-colors">Buah
                    Tempatan</a>
                <a href="{{ route('products.index', ['category' => 'buah-import']) }}"
                    class="text-white/70 no-underline text-sm block mb-2 hover:text-primary-500 transition-colors">Buah
                    Import</a>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">{{ __('Hubungi Kami') }}</h4>
                <a href="#"
                    class="text-white/70 no-underline text-sm block mb-2 hover:text-primary-500 transition-colors">📧
                    info@kebundigital.com</a>
                <a href="#"
                    class="text-white/70 no-underline text-sm block mb-2 hover:text-primary-500 transition-colors">📱
                    +60 12-345 6789</a>
                <a href="#"
                    class="text-white/70 no-underline text-sm block mb-2 hover:text-primary-500 transition-colors">📍
                    Selangor, Malaysia</a>
            </div>
        </div>
        <div class="text-center pt-5 mt-8 border-t border-white/10 text-xs max-w-7xl mx-auto px-5">
            <p>© {{ date('Y') }} Kebun Digital. Semua hak cipta terpelihara. 🇲🇾</p>
        </div>
    </footer>
</body>

</html>