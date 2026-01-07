<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand">GAMING POS - History</span>
            <a href="{{ route('kasir.index') }}" class="btn btn-outline-light">Kembali ke Kasir</a>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-primary text-white"><h5>Laporan Transaksi</h5></div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No. Invoice</th>
                            <th>Total Belanja</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $o)
                        <tr>
                            <td>{{ $o->created_at->format('d M Y H:i') }}</td>
                            <td><span class="badge bg-secondary">{{ $o->invoice_number }}</span></td>
                            <td>Rp {{ number_format($o->total_price) }}</td>
                            <td>
                                <a href="{{ route('transaction.receipt', $o->id) }}" class="btn btn-sm btn-info text-white">Lihat Struk</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>