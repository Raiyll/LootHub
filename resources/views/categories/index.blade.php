@extends('layouts.app')
<style>
    body {
        background-color: #f8fafc;
        color: #334155;
    }

    .card-custom {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .form-label {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #e2e8f0;
        background-color: #fdfdfd;
    }

    .form-control:focus {
        border-color: #4ee6b3;
        box-shadow: 0 0 0 3px rgba(78, 230, 179, 0.1);
    }

    .btn-save {
        background: #4ee6b3;
        color: #000;
        font-weight: 700;
        border: none;
        border-radius: 10px;
        padding: 12px;
        transition: 0.3s;
    }

    .btn-save:hover {
        background: #3cc99b;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(78, 230, 179, 0.3);
    }

    .table thead th {
        background: #ffffff;
        padding: 18px 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        border-bottom: 2px solid #f1f5f9;
    }

    .table tbody td {
        padding: 18px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .badge-count {
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 6px;
    }

    .btn-delete {
        color: #ef4444;
        background: transparent;
        border: 1px solid #fee2e2;
        padding: 6px 12px;
        border-radius: 8px;
        transition: 0.2s;
    }

    .btn-delete:hover {
        background: #fee2e2;
        color: #dc2626;
    }
</style>

@section('content')
<div class="container py-5">
    <div class="mb-5">
        <h2 class="fw-bold tracking-tight">Manajemen Kategori</h2>
        <p class="text-muted">Kelola kategori produk gaming Gear dan Top Up lu di sini.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card-custom p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-light rounded-3 p-2 me-3">
                        <i class="bi bi-tag-fill text-dark"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Tambah Baru</h5>
                </div>

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <button class="btn btn-save w-100 shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Simpan Kategori
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card-custom overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle border-0 mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Nama Kategori</th>
                                <th class="text-center">Jumlah Produk</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $cat->name }}</div>
                                    <small class="text-muted small">CAT-ID: {{ $cat->id }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge-count">{{ $cat->products->count() }} Items</span>
                                </td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn-delete" onclick="return confirm('Hapus kategori ini?')">
                                            <i class="bi bi-trash3 me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($categories->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-folder2-open display-4 text-muted"></i>
                    <p class="mt-2 text-muted">Belum ada kategori yang dibuat.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection