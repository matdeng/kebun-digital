<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — Log Masuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f4c25 0%, #1a7d42 40%, #2ecc71 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-logo a {
            text-decoration: none;
            color: white;
            font-size: 2rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .auth-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            padding: 36px;
        }

        .auth-card h2 {
            text-align: center;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 24px;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: #2c3e50;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e8f5e9;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: #2ECC71;
        }

        .error-text {
            color: #E74C3C;
            font-size: 0.8rem;
            margin-top: 4px;
        }

        .auth-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
        }

        .auth-actions a {
            color: #2ECC71;
            font-size: 0.85rem;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-actions a:hover {
            text-decoration: underline;
        }

        .btn-auth {
            background: linear-gradient(135deg, #2ECC71, #27AE60);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
        }

        .btn-auth:hover {
            background: linear-gradient(135deg, #27AE60, #1e8c4e);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-auth-full {
            width: 100%;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input {
            width: auto;
            transform: scale(1.2);
        }

        .remember-me label {
            font-size: 0.85rem;
            color: #555;
            margin: 0;
        }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .auth-footer a {
            color: white;
            font-weight: 700;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert-status {
            background: #d4edda;
            color: #155724;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-logo">
            <a href="{{ route('home') }}">🌿 Kebun Digital</a>
        </div>
        <div class="auth-card">
            {{ $slot }}
        </div>
        @if(request()->routeIs('login'))
            <div class="auth-footer">
                Belum ada akaun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        @elseif(request()->routeIs('register'))
            <div class="auth-footer">
                Sudah ada akaun? <a href="{{ route('login') }}">Log Masuk</a>
            </div>
        @endif
    </div>
</body>

</html>