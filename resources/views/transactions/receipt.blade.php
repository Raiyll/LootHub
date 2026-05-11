<!DOCTYPE html>
<html>

<head>
    <title>Struk Pembayaran - {{ $order->invoice_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary-color: #4ee6b3;
            --secondary-color: #ff3399;
            --dark-bg: #111827;
            --card-bg: rgba(255, 255, 255, 0.95);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        body {
            background: #F4F3F0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 16px;
            font-family: 'DM Sans', sans-serif;
        }

        .receipt {
            width: 320px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 24px rgba(0, 0, 0, 0.08);
        }

        /* HEAD */
        .rc-head {
            padding: 28px 28px 24px;
            border-bottom: 1px solid #F0F0EE;
        }

        .brand-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .brand {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-color);
            letter-spacing: -0.01em;
        }

        .brand span {
            color: var(--secondary-color);
        }

        .status-badge {
            background: #ECFDF5;
            color: #059669;
            font-size: 10px;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 99px;
        }

        .inv {
            font-size: 12px;
            color: #999;
            margin-bottom: 4px;
            font-family: 'DM Mono', monospace;
        }

        .inv strong {
            color: #444;
            font-weight: 500;
        }

        .date {
            font-size: 11px;
            color: #bbb;
            font-family: 'DM Mono', monospace;
        }

        /* BODY */
        .rc-body {
            padding: 20px 28px;
        }

        .sec-title {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.08em;
            color: #bbb;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 9px 0;
            border-bottom: 1px solid #F7F7F6;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-size: 13px;
            color: #222;
            font-weight: 500;
        }

        .item-qty {
            font-size: 11px;
            color: #bbb;
            margin-top: 2px;
        }

        .item-price {
            font-size: 13px;
            color: #444;
            font-family: 'DM Mono', monospace;
        }

        .divider {
            border: none;
            border-top: 1px solid #F0F0EE;
            margin: 16px 0;
        }

        .summary {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .srow {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .srow .sl {
            color: #aaa;
        }

        .srow .sv {
            color: #666;
            font-family: 'DM Mono', monospace;
        }

        .srow.total {
            margin-top: 4px;
            padding-top: 12px;
            border-top: 1px solid #F0F0EE;
        }

        .srow.total .sl {
            font-size: 14px;
            font-weight: 600;
            color: #111;
        }

        .srow.total .sv {
            font-size: 14px;
            font-weight: 600;
            color: #111;
        }

        .srow.change .sv {
            color: #059669;
        }

        /* FOOTER */
        .rc-foot {
            padding: 16px 28px 24px;
            text-align: center;
            border-top: 1px solid #F7F7F6;
        }

        .thanks {
            font-size: 11px;
            color: #ccc;
            letter-spacing: 0.06em;
            margin-bottom: 16px;
        }

        .btn-print {
            display: block;
            width: 100%;
            padding: 11px;
            background: #111;
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .btn-print:hover {
            background: #333;
        }

        .link-back {
            font-size: 12px;
            color: #bbb;
            text-decoration: none;
        }

        .link-back:hover {
            color: #111;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .no-print {
                display: none;
            }

            .receipt {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="rc-head">
            <div class="brand-row">
                <span class="brand">Loot<span>Hub</span></span>
                <span class="status-badge">✓ Lunas</span>
            </div>
            <div class="inv">No. Invoice &nbsp;<strong>{{ $order->invoice_number }}</strong></div>
            <div class="date">{{ $order->created_at->translatedFormat('d F Y') }} &nbsp;·&nbsp;
                {{ $order->created_at->format('H:i') }} WIB</div>
        </div>

        <div class="rc-body">
            <p class="sec-title">Pesanan</p>

            @foreach ($order->items as $item)
                <div class="item">
                    <div>
                        <div class="item-name">{{ $item->product->name }}</div>
                        <div class="item-qty">{{ $item->qty }} item</div>
                    </div>
                    <div class="item-price">{{ number_format($item->price * $item->qty) }}</div>
                </div>
            @endforeach

            <hr class="divider">

            <div class="summary">
                <div class="srow total">
                    <span class="sl">Total</span>
                    <span class="sv">Rp {{ number_format($order->total_price) }}</span>
                </div>
                <div class="srow">
                    <span class="sl">Bayar</span>
                    <span class="sv">Rp {{ number_format($order->pay_amount) }}</span>
                </div>
                <div class="srow change">
                    <span class="sl">Kembalian</span>
                    <span class="sv">Rp {{ number_format($order->change_amount) }}</span>
                </div>
            </div>
        </div>

        <div class="rc-foot no-print">
            <p class="thanks">— Terima kasih —</p>
            <button class="btn-print" onclick="window.print()">Cetak Struk</button>
            <a class="link-back" href="{{ route('homepage') }}">← Kembali ke Beranda</a>
        </div>
    </div>

    <script>
        window.onload = () => window.print();
    </script>
</body>

</html>
