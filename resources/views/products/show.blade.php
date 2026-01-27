@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">LootHub</a></li>
            <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden shadow-hover">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid main-product-img" alt="{{ $product->name }}">
                @else
                    <img src="https://images.unsplash.com/photo-1612287230202-1ff1d85d1bdf?q=80&w=1000" class="img-fluid main-product-img" alt="default">
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="ps-md-4">
                {{-- Badge Kategori Safe --}}
                <span class="badge bg-primary mb-2 px-3 rounded-pill text-uppercase">
                    {{ $product->category->name ?? 'Uncategorized' }}
                </span>
                
                <h1 class="fw-bold mb-1 text-dark display-5">{{ $product->name }}</h1>
                
                @if($product->game_name)
                    <p class="text-muted fs-5 mb-4"><i class="bi bi-controller me-2"></i>Edisi Khusus: <strong>{{ $product->game_name }}</strong></p>
                @else
                    <p class="text-success fs-5 mb-4"><i class="bi bi-patch-check-fill me-2"></i>Authentic Gaming Gear</p>
                @endif

                <div class="p-4 bg-light rounded-4 border-start border-4 border-primary mb-4">
                    <small class="text-muted d-block">Harga:</small>
                    <h2 class="text-primary fw-bold display-6 mb-0">Rp {{ number_format($product->price) }}</h2>
                </div>

                <div class="card border-0 bg-white shadow-sm p-4 mb-4 rounded-4">
                    <h6 class="fw-bold text-dark mb-3">Informasi Stok</h6>
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <small class="text-muted d-block">Tersedia</small>
                            <span class="fw-bold fs-5">{{ $product->stock }} Unit</span>
                        </div>
                        <div class="vr mx-3"></div>
                        <div>
                            <small class="text-muted d-block">Status</small>
                            <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                {{ $product->stock > 0 ? 'Ready Stock' : 'Out of Stock' }}
                            </span>
                        </div>
                    </div>
                </div>

              {{-- Bagian Interaksi: Form Beli --}}
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        
                        {{-- KONDISI KHUSUS TOP UP: Muncul kalo ada game_name --}}
                        @if($product->game_name)
                            <div class="card border-0 bg-primary bg-opacity-10 p-4 mb-4 rounded-4 border-start border-4 border-primary">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-person-badge-fill me-2"></i>Data Akun {{ $product->game_name }}
                                </h6>
                                <div class="mb-2">
                                    <label class="small fw-bold text-muted mb-1">User ID & Server</label>
                                    <input type="text" name="player_data" class="form-control form-control-lg rounded-3 border-0 shadow-sm" 
                                           placeholder="Contoh: 12345678 (2026)" required>
                                </div>
                                <small class="text-muted" style="font-size: 0.8rem;">
                                    *Pastikan ID sudah benar. Kesalahan pengisian bukan tanggung jawab LootHub.
                                </small>
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg rounded-pill py-3 fw-bold shadow-sm hover-up">
                                <i class="bi bi-cart-plus-fill me-2"></i> Masukkan ke Keranjang
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-danger rounded-4 border-0 p-4 d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-3 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Stok Habis Bre!</h6>
                            <small>Produk ini lagi kosong, pantau terus restock-nya ya.</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .main-product-img { 
        width: 100%; 
        height: 500px; 
        object-fit: contain; /* Pake contain biar gear lu kelihat utuh gak kepotong */
        background-color: #f8f9fa;
        transition: transform 0.5s ease; 
    }
    .shadow-hover:hover .main-product-img { transform: scale(1.05); }
    .hover-up:hover { transform: translateY(-3px); transition: 0.3s; }
</style>

<style>
    .main-product-img { width: 100%; height: 500px; object-fit: cover; transition: transform 0.5s ease; }
    .shadow-hover:hover .main-product-img { transform: scale(1.05); }
</style>
@endsection