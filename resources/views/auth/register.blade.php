<x-guest-layout>
    <h2>📝 Daftar Akaun</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name">Nama Penuh</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                placeholder="Nama anda">
            @error('name') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                placeholder="email@contoh.com">
            @error('email') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="password">Kata Laluan</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Minimum 8 aksara">
            @error('password') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Sahkan Kata Laluan</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" placeholder="Taip semula kata laluan">
        </div>

        <button type="submit" class="btn-auth btn-auth-full" style="margin-top:8px;">Daftar Sekarang →</button>
    </form>
</x-guest-layout>