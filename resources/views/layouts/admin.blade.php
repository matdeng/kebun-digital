<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — Kebun Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #2ECC71;
            --primary-dark: #27AE60;
            --accent: #E74C3C;
            --text: #2c3e50;
            --text-light: #7f8c8d;
            --bg: #f0f2f5;
            --border: #e8f5e9;
            --shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
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
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 0 20px 24px;
            font-size: 1.3rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 16px;
        }

        .sidebar-logo span {
            font-size: 1.5rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            border-left-color: var(--primary);
        }

        .sidebar-nav a.active {
            font-weight: 600;
        }

        .sidebar-section {
            padding: 8px 20px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.3);
            margin-top: 16px;
        }

        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 24px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 16px 24px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 24px;
        }

        .top-bar h1 {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 24px;
            margin-bottom: 16px;
        }

        .card-header {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            border-bottom: 2px solid #eee;
        }

        td {
            border-bottom: 1px solid #f5f5f5;
        }

        tr:hover td {
            background: #fafffe;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-danger {
            background: var(--accent);
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
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

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.75rem;
        }

        .btn-secondary {
            background: #3498db;
            color: white;
        }

        .status-badge {
            display: inline-flex;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
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
            border: 2px solid #e8e8e8;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--primary);
        }

        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 20px;
            list-style: none;
        }

        .pagination a,
        .pagination span {
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85rem;
            background: white;
            border: 1px solid #eee;
            color: var(--text);
        }

        .pagination a:hover {
            background: var(--primary);
            color: white;
        }

        .pagination .active span {
            background: var(--primary);
            color: white;
        }

        .admin-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 12px 24px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 24px;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text);
            padding: 4px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text);
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            transition: opacity 0.3s;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 50;
            }

            .admin-layout.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .admin-layout.sidebar-open .sidebar-overlay {
                display: block;
                opacity: 1;
            }

            .mobile-menu-btn {
                display: block;
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>
    <div class="admin-layout" x-data="{ sidebarOpen: false }" :class="{ 'sidebar-open': sidebarOpen }">
        <!-- OVERLAY BILA SIDEBAR TERBUKA (MOBILE) -->
        <div class="sidebar-overlay" @click="sidebarOpen = false"></div>

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <span>🌿</span> Kebun Digital
            </div>
            <div style="padding: 0 24px; margin-bottom: 20px; color: rgba(255,255,255,0.9); font-size: 0.9rem;">
                👋 Hi, {{ Auth::user()->name }}
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>

                <div class="sidebar-section">Pengurusan</div>
                <a href="{{ route('admin.products.index') }}"
                    class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">🍊 Produk</a>
                <a href="{{ route('admin.categories.index') }}"
                    class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">📂 Kategori</a>
                <a href="{{ route('admin.orders.index') }}"
                    class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">📦 Pesanan</a>
                <a href="{{ route('admin.customers.index') }}"
                    class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">👥 Pelanggan</a>

                <div class="sidebar-section">Lain-lain</div>
                <a href="{{ route('home') }}">🏠 Laman Depan</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="this.closest('form').submit()" style="border:none;">🚪 Log Keluar</a>
                </form>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <!-- ADMIN NAVBAR -->
            <nav class="admin-navbar">
                <div class="nav-left">
                    <button @click="sidebarOpen = !sidebarOpen" class="mobile-menu-btn">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <!-- You can add breadcrumbs or title here if needed -->
                </div>
                <div class="nav-right">
                    <div class="admin-profile">
                        <span class="profile-name">{{ Auth::user()->name }}</span>
                        <div class="profile-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
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