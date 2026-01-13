<!DOCTYPE html>
<html>

<head>
    <title>Struk Pembayaran - {{ $order->invoice_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 300px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
        }

        .text-center {
            text-align: center;
        }

        .line {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            font-size: 12px;
        }

        .total {
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h3>LOOTHUB</h3>
        <p>Invoice: {{ $order->invoice_number }}</p>
        <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="line"></div>

    <table>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }} ({{ $item->qty }}x)</td>
            <td style="text-align: right;">{{ number_format($item->price * $item->qty) }}</td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>

   <table>
        <tr class="total">
            <td>TOTAL</td>
            <td align="right">Rp {{ number_format($order->total_price) }}</td>
        </tr>
        <tr>
            <td>BAYAR</td>
            <td align="right">{{ number_format($order->pay_amount) }}</td>
        </tr>
        <tr>
            <td>KEMBALI</td>
            <td align="right">{{ number_format($order->change_amount) }}</td>
        </tr>
    </table>

    <div class="line"></div>
    <p class="text-center">-- TERIMA KASIH --</p>

    <div class="no-print text-center" style="margin-top: 20px;">
        <button onclick="window.print()">Cetak (Print)</button>
        <br><br>
        <a href="{{ route('homepage') }}">Kembali ke Beranda?</a>
    </div>
</body>

</html>