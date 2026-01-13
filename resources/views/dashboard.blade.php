<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard LootHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">LootHub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto align-items-center">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Kelola Kategori</a>
                    <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">Stok Barang</a>
                    <a class="nav-link {{ request()->routeIs('transaction.history') ? 'active' : '' }}" href="{{ route('transaction.history') }}">Riwayat</a>
                    <a class="nav-link" href="{{ route('homepage') }}">Lihat Toko</a>
                    
                    <form action="{{ route('logout') }}" method="POST" class="ms-lg-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm fw-bold">LOGOUT</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-0">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}!</h2>
                <p class="text-muted">Pantau performa tokomu di sini.</p>
            </div>
            <a href="{{ route('categories.index') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-folder-plus"></i> Tambah Kategori
            </a>
        </div>

        <h2 class="mb-3 text-uppercase fw-bold h6 text-secondary">Statistik Toko</h2>
        <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="card bg-success text-white shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="text-uppercase small opacity-75">Total Pendapatan</h6>
                        <h2 class="fw-bold mb-0">Rp {{ number_format($totalRevenue) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-primary text-white shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="text-uppercase small opacity-75">Transaksi Hari Ini</h6>
                        <h2 class="fw-bold mb-0">{{ $todayTransactions }} Pesanan</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold py-3">
                        <i class="bi bi-graph-up-arrow text-primary"></i> Best Seller Produk
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
                                        <td class="fw-medium">{{ $item->product->name }}</td>
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
            </div>

            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold py-3 text-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i> Stok Menipis
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($lowStockProducts as $p)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>{{ $p->name }}</span>
                                <span class="badge bg-danger rounded-pill">{{ $p->stock }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-center text-muted border-0 py-4">
                                <i class="bi bi-check-circle text-success d-block h1"></i>
                                Semua stok aman! ✅
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>