<x-guest-layout>
    <h2>📝 Daftar Akaun</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name">👤 Nama Penuh</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                placeholder="Nama anda">
            @error('name') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="email">📧 Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                placeholder="email@contoh.com">
            @error('email') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="password">🔒 Kata Laluan</label>
            <div style="position:relative;">
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Minimum 8 aksara" style="padding-right:44px;">
                <button type="button" onclick="togglePassword('password', this)"
                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:1.1rem;padding:4px;"
                    title="Tunjuk/Sembunyikan kata laluan">👁️</button>
            </div>
            @error('password') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">🔒 Sahkan Kata Laluan</label>
            <div style="position:relative;">
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Taip semula kata laluan" style="padding-right:44px;">
                <button type="button" onclick="togglePassword('password_confirmation', this)"
                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:1.1rem;padding:4px;"
                    title="Tunjuk/Sembunyikan kata laluan">👁️</button>
            </div>
        </div>

        <button type="submit" class="btn-auth btn-auth-full" style="margin-top: 8px;">Daftar Sekarang →</button>
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