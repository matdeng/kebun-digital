<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — Kebun Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-slate-100 text-slate-800">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }" :class="{ 'sidebar-open': sidebarOpen }">
        <!-- OVERLAY (MOBILE) -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-40 transition-opacity lg:hidden"
            x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <!-- SIDEBAR -->
        <aside
            class="w-64 bg-gradient-to-b from-dark to-dark-light text-white py-5 fixed h-screen overflow-y-auto z-50 border-r border-primary-500/10 transition-transform duration-300 -translate-x-full lg:translate-x-0"
            :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">
            <div class="px-5 pb-6 text-xl font-extrabold flex items-center gap-2.5 border-b border-white/10 mb-4">
                <span class="text-2xl">🌿</span> Kebun Digital
            </div>
            <div class="px-6 mb-5 text-white/90 text-sm">
                👋 Hi, {{ Auth::user()->name }}
            </div>
            <nav>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-6 py-3 text-white/70 no-underline text-sm transition-all border-l-[3px] border-transparent hover:bg-white/[0.08] hover:text-white hover:border-l-primary-500 {{ request()->routeIs('admin.dashboard') ? 'bg-white/[0.08] text-white border-l-primary-500 font-semibold' : '' }}">
                    📊 Dashboard
                </a>

                <div class="px-5 py-2 text-[0.7rem] uppercase tracking-widest text-white/30 mt-4">Pengurusan</div>
                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-white/70 no-underline text-sm transition-all border-l-[3px] border-transparent hover:bg-white/[0.08] hover:text-white hover:border-l-primary-500 {{ request()->routeIs('admin.products.*') ? 'bg-white/[0.08] text-white border-l-primary-500 font-semibold' : '' }}">
                    🍊 Produk
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-white/70 no-underline text-sm transition-all border-l-[3px] border-transparent hover:bg-white/[0.08] hover:text-white hover:border-l-primary-500 {{ request()->routeIs('admin.categories.*') ? 'bg-white/[0.08] text-white border-l-primary-500 font-semibold' : '' }}">
                    📂 Kategori
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-white/70 no-underline text-sm transition-all border-l-[3px] border-transparent hover:bg-white/[0.08] hover:text-white hover:border-l-primary-500 {{ request()->routeIs('admin.orders.*') ? 'bg-white/[0.08] text-white border-l-primary-500 font-semibold' : '' }}">
                    📦 Pesanan
                </a>
                <a href="{{ route('admin.customers.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-white/70 no-underline text-sm transition-all border-l-[3px] border-transparent hover:bg-white/[0.08] hover:text-white hover:border-l-primary-500 {{ request()->routeIs('admin.customers.*') ? 'bg-white/[0.08] text-white border-l-primary-500 font-semibold' : '' }}">
                    👥 Pelanggan
                </a>

                <div class="px-5 py-2 text-[0.7rem] uppercase tracking-widest text-white/30 mt-4">Lain-lain</div>
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-6 py-3 text-white/70 no-underline text-sm transition-all border-l-[3px] border-transparent hover:bg-white/[0.08] hover:text-white hover:border-l-primary-500">
                    🏠 Laman Depan
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="this.closest('form').submit()"
                        class="flex items-center gap-3 px-6 py-3 text-white/70 no-underline text-sm transition-all border-l-[3px] border-transparent hover:bg-white/[0.08] hover:text-white hover:border-l-primary-500">
                        🚪 Log Keluar
                    </a>
                </form>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 lg:ml-64 p-4 sm:p-6">
            <!-- ADMIN NAVBAR -->
            <nav class="flex justify-between items-center bg-white p-4 rounded-card shadow-card mb-6">
                <div>
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden bg-transparent border-none cursor-pointer text-slate-800 p-1">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-semibold text-sm">{{ Auth::user()->name }}</span>
                    <div
                        class="w-9 h-9 bg-primary-500 text-white rounded-full flex items-center justify-center font-bold text-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </nav>

            <!-- ALERTS -->
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">❌ {{ $errors->first() }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>