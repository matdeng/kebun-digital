@extends('layouts.app')
@section('content')
    <div class="container section">
        <h2 class="section-title" style="margin-bottom:24px;">💳 Pembayaran</h2>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 380px;gap:24px;">
                <!-- SHIPPING & PAYMENT -->
                <div>
                    <!-- SHIPPING INFO -->
                    <div class="card" style="margin-bottom:16px;">
                        <div class="card-header">📍 Maklumat Penghantaran</div>
                        <div class="form-group">
                            <label>Nama Penerima</label>
                            <input type="text" name="recipient_name"
                                value="{{ old('recipient_name', auth()->user()->name ?? '') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat Emel {{ auth()->check() ? '(Wajib)' : '(Untuk Resit & Notifikasi)' }}</label>
                            <input type="email" name="guest_email"
                                value="{{ old('guest_email', auth()->user()->email ?? '') }}" required {{ auth()->check() ? 'readonly' : '' }}>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label>No. Telefon</label>
                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                    placeholder="012-345 6789" required>
                            </div>
                            <div class="form-group">
                                <label>Alamat Penghantaran</label>
                                <textarea name="shipping_address" rows="3" required
                                    placeholder="No. Rumah, Jalan, Taman, Poskod, Bandar, Negeri">{{ old('shipping_address', optional(auth()->user())->address ?? '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Nota (Pilihan)</label>
                                <textarea name="notes" rows="2"
                                    placeholder="Contoh: Letak depan pintu">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <!-- PAYMENT METHOD -->
                        <div class="card">
                            <div class="card-header">💰 Kaedah Pembayaran</div>
                            <p style="font-size:0.8rem;color:var(--text-light);margin-bottom:12px;">
                                💡 COD: penghantaran RM5.00 &nbsp;|&nbsp; Online/E-Wallet: penghantaran RM8.00
                            </p>

                            <label class="payment-option"
                                style="display:flex;align-items:center;gap:12px;padding:16px;border:2px solid var(--border);border-radius:10px;margin-bottom:10px;cursor:pointer;transition:all 0.2s;">
                                <input type="radio" name="payment_method" value="cod" {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }} style="transform:scale(1.3);">
                                <div>
                                    <div style="font-weight:600;">💵 Cash on Delivery (COD)</div>
                                    <div style="font-size:0.8rem;color:var(--text-light);">Bayar tunai semasa terima pesanan
                                        · Penghantaran <strong>RM5.00</strong></div>
                                </div>
                            </label>

                            <label class="payment-option"
                                style="display:flex;align-items:center;gap:12px;padding:16px;border:2px solid var(--border);border-radius:10px;margin-bottom:10px;cursor:pointer;transition:all 0.2s;">
                                <input type="radio" name="payment_method" value="online_banking" {{ old('payment_method') == 'online_banking' ? 'checked' : '' }}
                                    style="transform:scale(1.3);">
                                <div>
                                    <div style="font-weight:600;">🏦 Online Banking (FPX)</div>
                                    <div style="font-size:0.8rem;color:var(--text-light);">Maybank, CIMB, RHB, Bank Islam,
                                        dll · Penghantaran <strong>RM8.00</strong></div>
                                </div>
                            </label>

                            <label class="payment-option"
                                style="display:flex;align-items:center;gap:12px;padding:16px;border:2px solid var(--border);border-radius:10px;margin-bottom:10px;cursor:pointer;transition:all 0.2s;">
                                <input type="radio" name="payment_method" value="ewallet" {{ old('payment_method') == 'ewallet' ? 'checked' : '' }} style="transform:scale(1.3);"
                                    id="ewallet-radio">
                                <div>
                                    <div style="font-weight:600;">📱 E-Wallet</div>
                                    <div style="font-size:0.8rem;color:var(--text-light);">Touch 'n Go, GrabPay, ShopeePay,
                                        dll · Penghantaran <strong>RM8.00</strong></div>
                                </div>
                            </label>

                            <div id="ewallet-options"
                                style="display:none;padding:12px;background:#f8f9fa;border-radius:8px;margin-top:8px;">
                                <label style="font-size:0.85rem;font-weight:600;margin-bottom:8px;display:block;">Pilih
                                    E-Wallet:</label>
                                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                                    <label
                                        style="display:flex;align-items:center;gap:6px;padding:8px 16px;background:white;border-radius:6px;border:1px solid #ddd;cursor:pointer;">
                                        <input type="radio" name="ewallet_provider" value="Touch n Go"> Touch 'n Go
                                    </label>
                                    <label
                                        style="display:flex;align-items:center;gap:6px;padding:8px 16px;background:white;border-radius:6px;border:1px solid #ddd;cursor:pointer;">
                                        <input type="radio" name="ewallet_provider" value="GrabPay"> GrabPay
                                    </label>
                                    <label
                                        style="display:flex;align-items:center;gap:6px;padding:8px 16px;background:white;border-radius:6px;border:1px solid #ddd;cursor:pointer;">
                                        <input type="radio" name="ewallet_provider" value="ShopeePay"> ShopeePay
                                    </label>
                                    <label
                                        style="display:flex;align-items:center;gap:6px;padding:8px 16px;background:white;border-radius:6px;border:1px solid #ddd;cursor:pointer;">
                                        <input type="radio" name="ewallet_provider" value="Boost"> Boost
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ORDER SUMMARY -->
                    <div>
                        <div class="card" style="position:sticky;top:80px;">
                            <div class="card-header">📋 Ringkasan Pesanan</div>

                            @foreach($cart->items as $item)
                                <div style="display:flex;gap:10px;margin-bottom:12px;align-items:center;">
                                    <div
                                        style="width:50px;height:50px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0;">
                                        🍊</div>
                                    <div style="flex:1;">
                                        <p style="font-size:0.85rem;font-weight:600;">{{ $item->product->name }}</p>
                                        <p style="font-size:0.75rem;color:var(--text-light);">{{ $item->quantity }} x RM
                                            {{ number_format($item->price, 2) }}</p>
                                    </div>
                                    <p style="font-weight:600;font-size:0.9rem;">RM
                                        {{ number_format($item->price * $item->quantity, 2) }}</p>
                                </div>
                            @endforeach

                            <hr style="border:1px solid var(--border);margin:16px 0;">

                            @php
                                $subtotal = $cart->total;
                            @endphp

                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.9rem;">
                                <span>Subtotal</span>
                                <span>RM {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.9rem;">
                                <span>Penghantaran</span>
                                <span id="shipping-fee" style="font-weight:600;">RM 5.00</span>
                            </div>
                            <hr style="border:1px solid var(--border);margin:12px 0;">
                            <div style="display:flex;justify-content:space-between;font-size:1.2rem;font-weight:700;">
                                <span>Jumlah Bayaran</span>
                                <span style="color:var(--accent);" id="total-amount">RM
                                    {{ number_format($subtotal + 5, 2) }}</span>
                            </div>

                            <button type="submit" class="btn btn-primary"
                                style="width:100%;justify-content:center;margin-top:20px;padding:14px;">
                                ✅ Buat Pesanan
                            </button>

                            <p style="text-align:center;font-size:0.75rem;color:var(--text-light);margin-top:8px;">
                                Dengan membuat pesanan, anda bersetuju dengan terma & syarat kami
                            </p>
                        </div>
                    </div>
                </div>
        </form>
    </div>

    <script>
        const subtotal = {{ $subtotal }};
        const shippingFeeEl = document.getElementById('shipping-fee');
        const totalEl = document.getElementById('total-amount');

        function updateTotals(method) {
            const shipping = method === 'cod' ? 5.00 : 8.00;
            const total = subtotal + shipping;
            shippingFeeEl.textContent = 'RM ' + shipping.toFixed(2);
            totalEl.textContent = 'RM ' + total.toFixed(2);
        }

        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function () {
                updateTotals(this.value);

                document.getElementById('ewallet-options').style.display =
                    this.value === 'ewallet' ? 'block' : 'none';

                document.querySelectorAll('.payment-option').forEach(opt => {
                    opt.style.borderColor = '#e8f5e9';
                });
                this.closest('.payment-option').style.borderColor = '#2ECC71';
            });
        });

        // Set initial state
        const checked = document.querySelector('input[name="payment_method"]:checked');
        if (checked) {
            checked.closest('.payment-option').style.borderColor = '#2ECC71';
            updateTotals(checked.value);
            if (checked.value === 'ewallet') {
                document.getElementById('ewallet-options').style.display = 'block';
            }
        }
    </script>

    <style>
        @media (max-width: 768px) {
            .container.section form>div {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection