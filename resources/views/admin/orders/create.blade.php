@extends('layouts.admin')
@section('title', 'Buat Pesanan Baru')
@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <h2>📝 Buat Pesanan Baru (Bagi Pihak Pelanggan)</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger"
            style="background:#fdecea;color:#c0392b;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.orders.store') }}" method="POST" id="admin-order-form">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 380px;gap:24px;">
            <div>
                <!-- Customer Selection -->
                <div class="card" style="margin-bottom:16px;">
                    <div class="card-header">👤 Pilih Pelanggan</div>
                    <div class="form-group">
                        <label>Pelanggan</label>
                        <select name="customer_id" required
                            style="width:100%;padding:10px;border:2px solid #e8f5e9;border-radius:8px;"
                            id="customer-select">
                            <option value="">-- Pilih pelanggan --</option>
                            <option value="guest" {{ old('customer_id') == 'guest' ? 'selected' : '' }}>-- TETAMU (GUEST) --
                            </option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}
                                    data-name="{{ $customer->name }}" data-phone="{{ $customer->phone ?? '' }}"
                                    data-address="{{ $customer->address ?? '' }}">
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id') <p style="color:#e74c3c;font-size:0.8rem;">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group" id="guest-email-box"
                        style="{{ old('customer_id') == 'guest' ? '' : 'display:none;' }}">
                        <label>Emel Tetamu (Wajib untuk Guest)</label>
                        <input type="email" name="guest_email" value="{{ old('guest_email') }}"
                            placeholder="emel@contoh.com">
                        @error('guest_email') <p style="color:#e74c3c;font-size:0.8rem;">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="card" style="margin-bottom:16px;">
                    <div class="card-header">📍 Maklumat Penghantaran</div>
                    <div class="form-group">
                        <label>Nama Penerima</label>
                        <input type="text" name="recipient_name" id="recipient-name" value="{{ old('recipient_name') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label>No. Telefon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="012-345 6789"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Alamat Penghantaran</label>
                        <textarea name="shipping_address" id="shipping-address" rows="3" required
                            placeholder="No. Rumah, Jalan, Poskod, Bandar, Negeri">{{ old('shipping_address') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Nota (Pilihan)</label>
                        <textarea name="notes" rows="2">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Products -->
                <div class="card" style="margin-bottom:16px;">
                    <div class="card-header">🍊 Produk</div>
                    <div id="product-rows">
                        <div class="product-row" style="display:flex;gap:10px;align-items:center;margin-bottom:10px;">
                            <select name="products[0][id]" required
                                style="flex:2;padding:10px;border:2px solid #e8f5e9;border-radius:8px;"
                                class="product-select" onchange="updatePrice(this)">
                                <option value="">-- Pilih produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                        data-stock="{{ $product->stock }}">
                                        {{ $product->name }} — RM{{ number_format($product->price, 2) }} (Stok:
                                        {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="products[0][quantity]" min="1" value="1"
                                style="flex:0.5;padding:10px;border:2px solid #e8f5e9;border-radius:8px;text-align:center;"
                                class="qty-input" onchange="recalculate()">
                            <span class="row-subtotal" style="flex:0.8;font-weight:600;text-align:right;">RM 0.00</span>
                            <button type="button" onclick="removeRow(this)"
                                style="background:#e74c3c;color:white;border:none;border-radius:6px;padding:8px 12px;cursor:pointer;">✕</button>
                        </div>
                    </div>
                    <button type="button" onclick="addProductRow()"
                        style="background:#2ecc71;color:white;border:none;border-radius:8px;padding:10px 20px;cursor:pointer;font-weight:600;margin-top:8px;">
                        ＋ Tambah Produk
                    </button>
                </div>

                <!-- Payment -->
                <div class="card">
                    <div class="card-header">💰 Kaedah Pembayaran</div>
                    <p style="font-size:0.8rem;color:#7f8c8d;margin-bottom:12px;">COD: penghantaran RM5 | Online/E-Wallet:
                        penghantaran RM8</p>
                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                        <label
                            style="display:flex;align-items:center;gap:8px;padding:12px 20px;border:2px solid #e8f5e9;border-radius:8px;cursor:pointer;"
                            class="pay-opt">
                            <input type="radio" name="payment_method" value="cod" {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }} onchange="recalculate()"> 💵 COD (RM5)
                        </label>
                        <label
                            style="display:flex;align-items:center;gap:8px;padding:12px 20px;border:2px solid #e8f5e9;border-radius:8px;cursor:pointer;"
                            class="pay-opt">
                            <input type="radio" name="payment_method" value="online_banking" {{ old('payment_method') == 'online_banking' ? 'checked' : '' }} onchange="recalculate()"> 🏦 FPX
                            (RM8)
                        </label>
                        <label
                            style="display:flex;align-items:center;gap:8px;padding:12px 20px;border:2px solid #e8f5e9;border-radius:8px;cursor:pointer;"
                            class="pay-opt">
                            <input type="radio" name="payment_method" value="ewallet" {{ old('payment_method') == 'ewallet' ? 'checked' : '' }} onchange="recalculate()"> 📱 E-Wallet (RM8)
                        </label>
                    </div>
                    <div id="ewallet-box" style="display:none;margin-top:10px;">
                        <select name="ewallet_provider" style="padding:10px;border:2px solid #e8f5e9;border-radius:8px;">
                            <option value="">-- Pilih e-wallet --</option>
                            <option value="Touch n Go">Touch 'n Go</option>
                            <option value="GrabPay">GrabPay</option>
                            <option value="ShopeePay">ShopeePay</option>
                            <option value="Boost">Boost</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div>
                <div class="card" style="position:sticky;top:80px;">
                    <div class="card-header">📋 Ringkasan</div>
                    <div id="summary-items" style="min-height:40px;color:#7f8c8d;font-size:0.85rem;">
                        <p>Sila tambah produk...</p>
                    </div>
                    <hr style="border:1px solid #eee;margin:12px 0;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:0.9rem;">
                        <span>Subtotal</span><span id="sum-subtotal">RM 0.00</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:0.9rem;">
                        <span>Penghantaran</span><span id="sum-shipping">RM 5.00</span>
                    </div>
                    <hr style="border:1px solid #eee;margin:12px 0;">
                    <div style="display:flex;justify-content:space-between;font-size:1.2rem;font-weight:700;">
                        <span>Jumlah</span><span id="sum-total" style="color:#e74c3c;">RM 0.00</span>
                    </div>
                    <button type="submit" class="btn btn-primary"
                        style="width:100%;justify-content:center;margin-top:20px;padding:14px;">
                        ✅ Buat Pesanan
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        let rowIndex = 1;

        // Auto-fill customer details
        document.getElementById('customer-select').addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            const isGuest = this.value === 'guest';

            document.getElementById('guest-email-box').style.display = isGuest ? 'block' : 'none';

            if (isGuest) {
                // Clear fields for manual entry
                document.getElementById('recipient-name').value = '';
                document.getElementById('phone').value = '';
                document.getElementById('shipping-address').value = '';
            } else {
                document.getElementById('recipient-name').value = opt.dataset.name || '';
                document.getElementById('phone').value = opt.dataset.phone || '';
                document.getElementById('shipping-address').value = opt.dataset.address || '';
            }
        });

        // E-wallet toggle
        document.querySelectorAll('input[name="payment_method"]').forEach(r => {
            r.addEventListener('change', function () {
                document.getElementById('ewallet-box').style.display = this.value === 'ewallet' ? 'block' : 'none';
            });
        });

        function addProductRow() {
            const container = document.getElementById('product-rows');
            const row = document.createElement('div');
            row.className = 'product-row';
            row.style.cssText = 'display:flex;gap:10px;align-items:center;margin-bottom:10px;';
            row.innerHTML = `
                            <select name="products[${rowIndex}][id]" required style="flex:2;padding:10px;border:2px solid #e8f5e9;border-radius:8px;" class="product-select" onchange="updatePrice(this)">
                                <option value="">-- Pilih produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                        {{ $product->name }} — RM{{ number_format($product->price, 2) }} (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="products[${rowIndex}][quantity]" min="1" value="1" style="flex:0.5;padding:10px;border:2px solid #e8f5e9;border-radius:8px;text-align:center;" class="qty-input" onchange="recalculate()">
                            <span class="row-subtotal" style="flex:0.8;font-weight:600;text-align:right;">RM 0.00</span>
                            <button type="button" onclick="removeRow(this)" style="background:#e74c3c;color:white;border:none;border-radius:6px;padding:8px 12px;cursor:pointer;">✕</button>`;
            container.appendChild(row);
            rowIndex++;
        }

        function removeRow(btn) {
            const rows = document.querySelectorAll('.product-row');
            if (rows.length > 1) {
                btn.closest('.product-row').remove();
                recalculate();
            }
        }

        function updatePrice(select) { recalculate(); }

        function recalculate() {
            let subtotal = 0;
            let summaryHtml = '';
            document.querySelectorAll('.product-row').forEach(row => {
                const sel = row.querySelector('.product-select');
                const qty = parseInt(row.querySelector('.qty-input').value) || 0;
                const opt = sel.options[sel.selectedIndex];
                const price = parseFloat(opt?.dataset?.price) || 0;
                const rowTotal = price * qty;
                subtotal += rowTotal;
                row.querySelector('.row-subtotal').textContent = 'RM ' + rowTotal.toFixed(2);
                if (sel.value) {
                    summaryHtml += `<div style="display:flex;justify-content:space-between;margin-bottom:4px;"><span>${opt.text.split('—')[0].trim()} x${qty}</span><span>RM ${rowTotal.toFixed(2)}</span></div>`;
                }
            });

            const method = document.querySelector('input[name="payment_method"]:checked')?.value || 'cod';
            const shipping = method === 'cod' ? 5.00 : 8.00;
            const total = subtotal + shipping;

            document.getElementById('summary-items').innerHTML = summaryHtml || '<p>Sila tambah produk...</p>';
            document.getElementById('sum-subtotal').textContent = 'RM ' + subtotal.toFixed(2);
            document.getElementById('sum-shipping').textContent = 'RM ' + shipping.toFixed(2);
            document.getElementById('sum-total').textContent = 'RM ' + total.toFixed(2);
        }
    </script>
@endsection