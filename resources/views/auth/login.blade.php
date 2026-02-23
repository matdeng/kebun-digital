<x-guest-layout>
    @if (session('status'))
        <div class="alert-status">{{ session('status') }}</div>
    @endif

    <h2>🔑 Log Masuk</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username" placeholder="email@contoh.com">
            @error('email') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="password">Kata Laluan</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                placeholder="••••••••">
            @error('password') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label class="remember-me" style="cursor:pointer;">
                <input type="checkbox" name="remember">
                <span>Ingat saya</span>
            </label>
        </div>

        <div class="auth-actions">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Lupa kata laluan?</a>
            @endif
            <button type="submit" class="btn-auth">Log Masuk →</button>
        </div>
    </form>
</x-guest-layout>