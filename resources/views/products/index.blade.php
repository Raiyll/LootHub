@extends('layouts.app')

@section('title', 'Stok Gaming Gear - LootHub Premium')

@push('styles')
<style>
    .glass-card {
        background: white;
        border: 1px solid rgba(229, 231, 235, 0.5);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }

    .table thead th {
        background: #f9fafb;
        padding: 18px 20px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6b7280;
        border: none;
    }

    .table tbody td {
        padding: 18px 20px;
        border-bottom: 1px solid #f3f4f6;
    }

    .product-box {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .product-icon {
        width: 45px;
        height: 45px;
        background: #f3f4f6;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #6366f1;
    }

    .btn-add {
        background: #111827;
        color: white;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        border: none;
        transition: 0.3s;
    }

    .btn-add:hover {
        background: #000;
        color: #fff;
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-5">
    <div class="search-placeholder">
        <span class="text-muted fw-medium small">GUDANG LOOTHUB</span>
    </div>
    <div class="user-profile d-flex align-items-center gap-3">
        <span class="fw-bold small">{{ Auth::user()->name ?? 'Admin LootHub' }}</span>
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
            <i class="bi bi-person-fill"></i>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-0">Stok Produk</h2>
            <p class="text-muted mb-0">Total {{ count($products) }} item tersedia di gudang.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-add shadow-lg text-decoration-none">
            <i class="bi bi-plus-circle-fill me-2"></i> Produk Baru
        </a>
    </div>

    <div class="glass-card mt-2">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Price Tag</th>
                        <th>Stock Status</th>
                        <th class="text-center">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <span class="fw-bold">{{ $product->name }}</span>
                        </td>

                        <td>
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </td>

                        <td>
                            Rp {{ number_format($product->price) }}
                        </td>

                        <td>
                            @if($product->trashed())
                            <span class="badge bg-secondary opacity-50">Diarsipkan</span>
                            @else
                            <span class="badge bg-success">Aktif</span>
                            <div class="small text-muted">Sisa: {{ $product->stock }}</div>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($product->trashed())
                            {{-- Tombol Restore --}}
                            <form action="{{ route('products.restore', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info text-white rounded-pill px-3">
                                    <i class="bi bi-arrow-counterclockwise"></i> Pulihkan
                                </button>
                            </form>
                            @else
                            {{-- Tombol Edit (Opsional jika lu ada) --}}
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning rounded-pill px-3">
                                <i class="bi bi-pencil"></i>
                            </a>

                            {{-- Tombol Delete --}}
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Arsipkan produk ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection