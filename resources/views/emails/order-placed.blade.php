<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f4f4;
            padding: 0;
            margin: 0;
        }

        .wrapper {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: linear-gradient(135deg, #2ECC71, #27AE60);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 1.4rem;
        }

        .header p {
            margin: 8px 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .content {
            padding: 30px;
        }

        .info-box {
            background: #f0faf4;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            border-left: 4px solid #2ECC71;
        }

        .info-box p {
            margin: 4px 0;
            font-size: 0.9rem;
        }

        .info-box strong {
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }

        th {
            background: #f8f9fa;
            padding: 10px 12px;
            text-align: left;
            font-size: 0.8rem;
            color: #7f8c8d;
            border-bottom: 2px solid #e8f5e9;
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.85rem;
        }

        .total-row td {
            font-weight: 700;
            font-size: 1rem;
            border-top: 2px solid #2ECC71;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 0.8rem;
            color: #7f8c8d;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <h1>🌿 Kebun Digital</h1>
            <p>Pesanan Anda Berjaya Dibuat!</p>
        </div>
        <div class="content">
            <p style="font-size:0.95rem;">Salam <strong>{{ $order->recipient_name }}</strong>,</p>
            <p style="font-size:0.9rem;color:#555;margin-bottom:20px;">Terima kasih kerana membeli di Kebun Digital.
                Berikut adalah butiran pesanan anda:</p>

            <div class="info-box">
                <p><strong>No. Pesanan:</strong> {{ $order->order_number }}</p>
                <p><strong>No. Resit:</strong> {{ $order->receipt_number }}</p>
                <p><strong>Tarikh:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                <p><strong>Status:</strong> <span class="badge"
                        style="background:#e8f5e9;color:#27ae60;">{{ $order->status_label }}</span></p>
            </div>

            <h3 style="font-size:0.95rem;margin-bottom:8px;">📋 Item Pesanan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kuantiti</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>RM {{ number_format($item->product_price, 2) }}</td>
                            <td>RM {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table style="margin-top:0;">
                <tr>
                    <td>Subtotal</td>
                    <td style="text-align:right;">RM {{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Penghantaran ({{ $order->payment?->method_label }})</td>
                    <td style="text-align:right;">RM {{ number_format($order->shipping_fee, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Jumlah Bayaran</td>
                    <td style="text-align:right;color:#E74C3C;">RM {{ number_format($order->total, 2) }}</td>
                </tr>
            </table>

            <div class="info-box" style="border-left-color:#3498db;">
                <p><strong>📍 Alamat:</strong> {{ $order->shipping_address }}</p>
                <p><strong>📞 Telefon:</strong> {{ $order->phone }}</p>
                @if($order->payment)
                    <p><strong>💰 Kaedah Bayaran:</strong> {{ $order->payment->method_label }}</p>
                @endif
            </div>

            @if($order->notes)
                <p style="font-size:0.85rem;color:#555;"><strong>Nota:</strong> {{ $order->notes }}</p>
            @endif
        </div>
        <div class="footer">
            <p>🌿 Kebun Digital — Buah Segar Terus ke Rumah Anda</p>
            <p>Email ini dihantar secara automatik. Sila jangan balas.</p>
        </div>
    </div>
</body>

</html>