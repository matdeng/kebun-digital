<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — {{ request()->routeIs('login') ? 'Log Masuk' : 'Daftar' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Auth-specific overrides */
        .auth-card .form-group input {
            background: #f8fffe;
            border: 2px solid #e2e8f0;
            padding: 14px 16px;
            font-size: 0.95rem;
            border-radius: 12px;
            transition: all 0.25s ease;
        }

        .auth-card .form-group input:focus {
            border-color: #10B981;
            background: white;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        .auth-card .form-group label {
            color: #334155;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .auth-card h2 {
            text-align: center;
            font-size: 1.4rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 28px;
        }

        .auth-card .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .auth-card .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border: 2px solid #cbd5e1;
            border-radius: 4px;
            cursor: pointer;
            accent-color: #10B981;
        }

        .auth-card .remember-me span {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }

        .auth-card .auth-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 24px;
            gap: 12px;
        }

        .auth-card .auth-actions a {
            color: #10B981;
            font-size: 0.85rem;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-card .auth-actions a:hover {
            color: #059669;
            text-decoration: underline;
        }

        .auth-card .btn-auth {
            background: linear-gradient(135deg, #10B981, #059669);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
            letter-spacing: 0.02em;
        }

        .auth-card .btn-auth:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(16, 185, 129, 0.35);
        }

        .auth-card .btn-auth-full {
            width: 100%;
            text-align: center;
            display: block;
        }

        .auth-card .error-text {
            color: #ef4444;
            font-size: 0.78rem;
            margin-top: 6px;
            font-weight: 500;
        }

        .auth-card .alert-status {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            font-weight: 500;
        }
    </style>
</head>

<body class="font-sans min-h-screen flex items-center justify-center p-5 relative"
    style="background: linear-gradient(135deg, #022C22 0%, #064E3B 25%, #047857 60%, #10B981 100%);">

    <!-- Decorative elements -->
    <div class="fixed top-[-20%] right-[-15%] w-[500px] h-[500px] rounded-full pointer-events-none opacity-40"
        style="background: radial-gradient(circle, rgba(245,158,11,0.12) 0%, transparent 70%);"></div>
    <div class="fixed bottom-[-15%] left-[-10%] w-[400px] h-[400px] rounded-full pointer-events-none opacity-30"
        style="background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, transparent 70%);"></div>

    <div class="w-full max-w-[440px] relative z-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="no-underline text-white inline-flex items-center gap-3">
                <span class="text-4xl">🌿</span>
                <span class="text-3xl font-extrabold tracking-tight">Kebun Digital</span>
            </a>
            <p class="text-white/60 text-sm mt-2">Platform Buah Segar Online</p>
        </div>

        <!-- Auth Card -->
        <div class="auth-card bg-white rounded-2xl p-8 sm:p-10 animate-card-up"
            style="box-shadow: 0 25px 60px rgba(0,0,0,0.2), 0 0 0 1px rgba(255,255,255,0.05);">
            {{ $slot }}
        </div>

        <!-- Footer Links -->
        @if(request()->routeIs('login'))
            <div class="text-center mt-6 text-sm text-white/80">
                Belum ada akaun?
                <a href="{{ route('register') }}"
                    class="text-white font-bold no-underline hover:underline ml-1 inline-flex items-center gap-1">
                    Daftar sekarang <span class="text-xs">→</span>
                </a>
            </div>
        @elseif(request()->routeIs('register'))
            <div class="text-center mt-6 text-sm text-white/80">
                Sudah ada akaun?
                <a href="{{ route('login') }}"
                    class="text-white font-bold no-underline hover:underline ml-1 inline-flex items-center gap-1">
                    Log Masuk <span class="text-xs">→</span>
                </a>
            </div>
        @endif

        <!-- Bottom branding -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-white/70 text-sm no-underline hover:text-white transition-colors">
                ← Kembali ke Laman Utama
            </a>
        </div>
        <div class="text-center mt-4 text-white/30 text-xs">
            © {{ date('Y') }} Kebun Digital
        </div>
    </div>
</body>

</html>