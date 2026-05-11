<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penjualan - LootHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Syne', sans-serif;
            background-color: #f1f5f9;
            /* Abu-abu lebih soft */
            color: #1e293b;
        }

        .navbar {
            background: #0f172a !important;
            /* Biru gelap premium */
            padding: 0.5rem 0;
            border-bottom: 3px solid #4ee6b3;
            /* Aksen neon lu */
        }

        .navbar-brand img {
            height: 105px;
            width: auto;
            object-fit: contain;
            margin-top: -10px;
            margin-bottom: -10px;
            filter: drop-shadow(0 0 10px rgba(78, 230, 179, 0.2));
            transition: transform 0.3s ease;
        }

        .navbar-brand img:hover {
            transform: scale(1.05);
            /* Efek zoom dikit pas di-hover biar dapet feel gamingnya */
        }

        /* Sesuaikan tinggi Navbarnya juga biar gak sesak */
        .navbar {
            min-height: 80px;
            padding: 0.5rem 0;
        }

        .main-container {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        /* Table Styling */
        .table thead th {
            background-color: #f8fafc;
            padding: 20px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            border-top: none;
        }

        .table tbody td {
            padding: 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Invoice Badge */
        .invoice-id {
            font-family: 'Courier New', Courier, monospace;
            font-weight: 700;
            color: #0f172a;
            background: #f1f5f9;
            padding: 5px 10px;
            border-radius: 6px;
        }

        /* Player Data Styling */
        .player-box {
            background: #ecfdf5;
            color: #059669;
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 4px;
        }

        /* Total Styling */
        .total-amount {
            font-weight: 700;
            color: #1e293b;
        }

        /* Button Styling */
        .btn-receipt {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            color: #475569;
            border-radius: 10px;
            font-weight: 600;
            padding: 8px 16px;
            transition: all 0.2s;
        }

        .btn-receipt:hover {
            background-color: #0f172a;
            color: #ffffff;
            border-color: #0f172a;
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/iconLootPutih.png') }}" alt="LootHub Logo">
            </a>
            <div class="ms-auto">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill px-3 fw-600">
                    <i class="bi bi-grid-fill me-2"></i> Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container main-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Riwayat Penjualan</h3>
                <p class="text-muted small mb-0">Memantau seluruh transaksi masuk di LootHub</p>
            </div>
            <div class="bg-white p-2 px-3 rounded-4 shadow-sm border">
                <span class="text-muted small">Total Transaksi: </span>
                <span class="fw-bold text-dark">{{ $orders->count() }}</span>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">No. Invoice</th>
                                <th>Item Terjual</th>
                                <th>Total Bayar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td class="ps-4">
                                    <span class="invoice-id">#{{ $order->invoice_number }}</span>
                                    <div class="small text-muted mt-1">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td>
                                    @foreach($order->items as $item)
                                    <div class="mb-2">
                                        <div class="fw-600 text-dark">{{ $item->product->name }}</div>
                                        @if($item->player_data)
                                        <div class="player-box">
                                            <i class="bi bi-controller me-1"></i> ID: {{ $item->player_data }}
                                        </div>
                                        @else
                                        <span class="small text-muted">Produk Fisik</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="total-amount">Rp {{ number_format($order->total_price) }}</span>
                                    <div class="small text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Paid</div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('transaction.receipt', $order->id) }}" class="btn btn-receipt btn-sm">
                                        <i class="bi bi-printer me-2"></i> Cetak Struk
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($orders->isEmpty())
        <div class="text-center mt-5">
            <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
            <p class="mt-3 text-muted">Belum ada transaksi yang tercatat.</p>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
