<!DOCTYPE html>
<html lang="id">

<head>
    <title>Dashboard LootHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">LootHub</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('kasir.index') ? 'active' : '' }}" href="{{ route('kasir.index') }}">Kasir</a>
                <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">Stok Barang</a>
                <a class="nav-link {{ request()->routeIs('transaction.history') ? 'active' : '' }}" href="{{ route('transaction.history') }}">Riwayat</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
    <div class="mb-5">
        <h2 class="fw-bold text-dark mb-0">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="text-muted">Ini dashboard ceunah</p>
    </div>

    <h2 class="mb-4 text-uppercase fw-bold h5">Statistik Toko</h2>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-success text-white shadow border-0">
                <div class="card-body">
                    <h6 class="text-uppercase small">Total Pendapatan</h6>
                    <h2 class="fw-bold">Rp {{ number_format($totalRevenue) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-primary text-white shadow border-0">
                <div class="card-body">
                    <h6 class="text-uppercase small">Transaksi Hari Ini</h6>
                    <h2 class="fw-bold">{{ $todayTransactions }} Pesanan</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white fw-bold">
                    Best Seller Produk
                </div>
                <div class="card-body">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th class="text-center">Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-warning text-dark">{{ $item->total_qty }} Unit</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-danger text-white fw-bold">
                 Stok Menipis
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($lowStockProducts as $p)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $p->name }}
                            <span class="badge bg-danger rounded-pill">{{ $p->stock }}</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted">Semua stok aman! ✅</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>