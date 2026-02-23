<x-guest-layout>
    <h2>🔒 Lupa Kata Laluan</h2>
    <p style="font-size:0.85rem;color:#7f8c8d;margin-bottom:20px;text-align:center;">Masukkan email anda dan kami akan
        hantar pautan untuk reset kata laluan.</p>

    @if (session('status'))
        <div class="alert-status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                placeholder="email@contoh.com">
            @error('email') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-auth btn-auth-full">📧 Hantar Pautan Reset</button>
    </form>
</x-guest-layout>