@extends('layouts.app')

@section('title', 'Dashboard - LootHub')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}!</h2>
            <p class="text-muted">Pantau performa tokomu.</p>
        </div>
        <a href="{{ route('categories.index') }}" class="btn btn-primary shadow-sm fw-medium">
            <i class="bi bi-folder-plus"></i> Tambah Kategori
        </a>
    </div>

    <h2 class="mb-3 text-uppercase fw-bold h6 text-secondary" style="letter-spacing: 1px;">Statistik Toko</h2>
    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card text-white shadow-sm border-0" style="background-color:#00d78f;">
                <div class="card-body p-4">
                    <h6 class="text-uppercase small text-white">Total Pendapatan</h6>
                    <h2 class="fw-bold mb-0">Rp {{ number_format($totalRevenue) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white shadow-sm border-0" style="background-color:#ff3399;">
                <div class="card-body p-4">
                    <h6 class="text-uppercase small text-white">Transaksi Hari Ini</h6>
                    <h2 class="fw-bold mb-0">{{ $todayTransactions }} Pesanan</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-graph-up-arrow text-primary me-2"></i>Best Seller Produk
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
                                    <td class="fw-medium text-dark">{{ $item->product->name ?? 'Produk Telah Dihapus' }}</td>
                                    <td class="text-center">
                                        <span class="badge text-white px-3" style="background-color:#0d6efd">{{ $item->total_qty }} Unit</span>
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
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Stok Menipis
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($lowStockProducts as $p)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-dark fw-medium">{{ $p->name }}</span>
                            <span class="badge bg-danger rounded-pill">{{ $p->stock }}</span>
                        </li>
                        @empty
                        <div class="text-center py-4">
                            <i class="bi bi-check-circle text-success d-block h1"></i>
                            <p class="text-muted mb-0">Semua stok aman! ✅</p>
                        </div>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection