<x-guest-layout>
    @if (session('status'))
        <div class="alert-status">{{ session('status') }}</div>
    @endif

    <h2>🔑 Log Masuk</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">📧 Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username" placeholder="email@contoh.com">
            @error('email') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="password">🔒 Kata Laluan</label>
            <div style="position:relative;">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••" style="padding-right:44px;">
                <button type="button" onclick="togglePassword('password', this)"
                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:1.1rem;padding:4px;"
                    title="Tunjuk/Sembunyikan kata laluan">👁️</button>
            </div>
            @error('password') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label class="remember-me">
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

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = '🙈';
            } else {
                input.type = 'password';
                btn.textContent = '👁️';
            }
        }
    </script>
</x-guest-layout>