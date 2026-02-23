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
    <style>
        :root {
            --primary: #2ECC71;
            --primary-dark: #27AE60;
            --primary-light: #A8E6CF;
            --secondary: #F39C12;
            --accent: #E74C3C;
            --dark: #1a1a2e;
            --dark-light: #16213e;
            --text: #2c3e50;
            --text-light: #7f8c8d;
            --bg: #f8fffe;
            --white: #ffffff;
            --border: #e8f5e9;
            --shadow: 0 2px 15px rgba(46, 204, 113, 0.08);
            --shadow-lg: 0 8px 30px rgba(46, 204, 113, 0.15);
            --radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 12px 20px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
            font-size: 1.4rem;
            font-weight: 800;
        }

        .nav-logo span {
            font-size: 1.6rem;
        }

        .nav-search {
            flex: 1;
            max-width: 500px;
            margin: 0 30px;
            position: relative;
        }

        .nav-search input {
            width: 100%;
            padding: 10px 40px 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            background: rgba(255, 255, 255, 0.95);
        }

        .nav-search input:focus {
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        .nav-search button {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            cursor: pointer;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-actions a {
            color: white;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-actions a:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        /* DROPDOWN STYLES */
        .nav-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-trigger {
            cursor: pointer;
            color: white;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .dropdown-trigger:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 200px;
            box-shadow: var(--shadow-lg);
            border-radius: var(--radius);
            padding: 8px 0;
            z-index: 1001;
            margin-top: 8px;
            border: 1px solid var(--border);
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-content.show {
            display: block;
        }

        .dropdown-content a {
            color: var(--text) !important;
            padding: 10px 20px !important;
            text-decoration: none;
            display: flex !important;
            gap: 10px;
            font-size: 0.9rem;
            transition: background 0.2s;
            border-radius: 0 !important;
            justify-content: flex-start !important;
        }

        .dropdown-content a:hover {
            background-color: #f8f9fa !important;
            color: var(--primary) !important;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 8px 0;
        }

        .cart-badge {
            position: relative;
        }

        .cart-badge .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--accent);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero {
            background: linear-gradient(135deg, #0f4c25 0%, #1a7d42 40%, #2ecc71 100%);
            padding: 60px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hero-text {
            max-width: 550px;
        }

        .hero-text h1 {
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .hero-text p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 24px;
        }

        .hero-emoji {
            font-size: 8rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-white {
            background: white;
            color: var(--primary-dark);
        }

        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-danger {
            background: var(--accent);
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.8rem;
        }

        .btn-secondary {
            background: var(--secondary);
            color: white;
        }

        .btn-secondary:hover {
            background: #e67e22;
        }

        .section {
            padding: 40px 0;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: var(--primary);
            border-radius: 2px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .product-card-img {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, var(--primary-light), #d5f5e3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            position: relative;
        }

        .product-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--accent);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .product-card-body {
            padding: 14px;
        }

        .product-card-body h3 {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-category {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-bottom: 8px;
        }

        .product-price {
            color: var(--accent);
            font-size: 1.1rem;
            font-weight: 700;
        }

        .product-unit {
            font-size: 0.75rem;
            color: var(--text-light);
            font-weight: 400;
        }

        .product-stock {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-top: 4px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 16px;
        }

        .category-card {
            background: white;
            border-radius: var(--radius);
            padding: 20px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
        }

        .category-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .category-card h3 {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .category-card p {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .footer {
            background: var(--dark);
            color: rgba(255, 255, 255, 0.8);
            padding: 40px 0 20px;
            margin-top: 60px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer h4 {
            color: white;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.85rem;
            display: block;
            margin-bottom: 8px;
        }

        .footer a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
        }

        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: inherit;
            transition: border-color 0.2s;
            outline: none;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--primary);
        }

        .table-container {
            overflow-x: auto;
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 16px;
            text-align: left;
            font-size: 0.85rem;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid var(--border);
        }

        td {
            border-bottom: 1px solid #f0f0f0;
        }

        tr:hover td {
            background: #fafffe;
        }

        .tabs {
            display: flex;
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow-x: auto;
            margin-bottom: 24px;
        }

        .tab {
            padding: 14px 20px;
            text-decoration: none;
            color: var(--text-light);
            font-size: 0.85rem;
            font-weight: 500;
            white-space: nowrap;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
            text-align: center;
            flex: 1;
        }

        .tab:hover {
            color: var(--primary);
            background: rgba(46, 204, 113, 0.05);
        }

        .tab.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
            font-weight: 600;
        }

        .tab .tab-count {
            background: var(--accent);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 6px;
        }

        .status-badge {
            display: inline-flex;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 30px;
            list-style: none;
        }

        .pagination a,
        .pagination span {
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85rem;
            color: var(--text);
            background: white;
            border: 1px solid var(--border);
        }

        .pagination a:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination .active span {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 24px;
        }

        .card-header {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .promo-bar {
            background: linear-gradient(90deg, #ff6b6b, #ee5a24, #f39c12);
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            animation: shimmer 3s ease infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.85;
            }
        }

        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 2rem;
            }

            .hero-emoji {
                font-size: 5rem;
            }

            .nav-search {
                display: none;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .category-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .nav-actions a .nav-label {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>
    <!-- PROMO BAR -->
    <div class="promo-bar">
        {{ __("Penghantaran PERCUMA untuk pesanan melebihi RM100! | Gunakan kod: BUAHSEGAR 🍑") }}
    </div>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-top">
            <a href="{{ route('home') }}" class="nav-logo">
                <span>🌿</span> Kebun Digital
            </a>
            <form class="nav-search" action="{{ route('products.index') }}" method="GET">
                <input type="text" name="search" placeholder="{{ __('Cari buah-buahan segar...') }}"
                    value="{{ request('search') }}">
                <button type="submit">🔍</button>
            </form>

            <div style="display:flex;gap:8px;margin-right:12px;">
                <a href="{{ route('set-locale', 'ms') }}"
                    style="text-decoration:none;font-size:1.2rem;opacity:{{ app()->getLocale() == 'ms' ? '1' : '0.5' }};filter:{{ app()->getLocale() == 'ms' ? 'none' : 'grayscale(1)' }};"
                    title="Bahasa Melayu">🇲🇾</a>
                <a href="{{ route('set-locale', 'en') }}"
                    style="text-decoration:none;font-size:1.2rem;opacity:{{ app()->getLocale() == 'en' ? '1' : '0.5' }};filter:{{ app()->getLocale() == 'en' ? 'none' : 'grayscale(1)' }};"
                    title="English">🇺🇸</a>
            </div>

            <div class="nav-actions">
                <a href="{{ route('cart.index') }}" class="cart-badge">
                    🛒 <span class="nav-label">{{ __('Troli') }}</span>
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
                        <div class="badge">{{ $cartCount }}</div>
                    @endif
                </a>

                @auth
                    <a href="{{ route('orders.index') }}">📦 <span class="nav-label">{{ __('Pesanan') }}</span></a>

                    <div class="nav-dropdown">
                        <div class="dropdown-trigger" id="admin-dropdown-trigger">
                            👤 <span class="nav-label">{{ Auth::user()->name }}</span> ▾
                        </div>
                        <div class="dropdown-content" id="admin-dropdown-content">
                            <a href="{{ route('profile.edit') }}">👤 {{ __('Profil Saya') }}</a>

                            @if(auth()->user()->isAdmin())
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('admin.dashboard') }}">⚙️ {{ __('Lihat Pengurusan') }}</a>
                            @endif

                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    style="color: var(--accent) !important;">
                                    🚪 {{ __('Keluar') }}
                                </a>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}">🔑 <span class="nav-label">{{ __('Log Masuk') }}</span></a>
                    <a href="{{ route('register') }}" class="btn btn-white btn-sm">📝 {{ __('Daftar') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ALERTS -->
    <div class="container" style="margin-top: 16px;">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                ❌
                <ul style="margin:0;padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- HEADER SLOT (for component-based views) -->
    @if(isset($header))
        <header class="bg-white shadow">
            <div class="container" style="padding: 20px 0;">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- CONTENT -->
    @yield('content')
    {{ $slot ?? '' }}

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-grid">
            <div>
                <h4>🌿 Kebun Digital</h4>
                <p style="font-size:0.85rem;">Platform jualan buah-buahan segar secara online. Terus dari kebun ke rumah
                    anda.</p>
            </div>
            <div>
                <h4>Pautan Pantas</h4>
                <a href="{{ route('home') }}">{{ __('Laman Utama') }}</a>
                <a href="{{ route('products.index') }}">{{ __('Semua Produk') }}</a>
                @auth
                    <a href="{{ route('orders.index') }}">{{ __('Pesanan Saya') }}</a>
                @endauth
            </div>
            <div>
                <h4>{{ __('Kategori') }}</h4>
                <a href="{{ route('products.index', ['category' => 'buah-tropika']) }}">Buah Tropika</a>
                <a href="{{ route('products.index', ['category' => 'buah-tempatan']) }}">Buah Tempatan</a>
                <a href="{{ route('products.index', ['category' => 'buah-import']) }}">Buah Import</a>
            </div>
            <div>
                <h4>{{ __('Hubungi Kami') }}</h4>
                <a href="#">📧 info@kebundigital.com</a>
                <a href="#">📱 +60 12-345 6789</a>
                <a href="#">📍 Selangor, Malaysia</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ date('Y') }} Kebun Digital. Semua hak cipta terpelihara. 🇲🇾</p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trigger = document.getElementById('admin-dropdown-trigger');
            const content = document.getElementById('admin-dropdown-content');

            if (trigger && content) {
                trigger.addEventListener('click', function (e) {
                    e.stopPropagation();
                    content.classList.toggle('show');
                });

                document.addEventListener('click', function (e) {
                    if (!trigger.contains(e.target) && !content.contains(e.target)) {
                        content.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>

</html>