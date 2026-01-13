@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-uppercase mb-0">Kategori: {{ $category->name }}</h2>
            <p class="text-muted">Menampilkan semua produk dalam kategori ini</p>
        </div>
        <a href="{{ route('homepage') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="row">
        @forelse($products as $p)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="fw-bold mb-1">{{ $p->name }}</h5>
                    
                    @if($p->game_name)
                        <p class="text-muted small mb-2"><i class="bi bi-controller"></i> {{ $p->game_name }}</p>
                    @endif

                    <h5 class="text-primary fw-bold">Rp {{ number_format($p->price) }}</h5>
                    
                    <div class="mt-3">
                        @if($p->stock > 0)
                            <a href="{{ route('cart.add', $p->id) }}" class="btn btn-dark btn-sm w-100 rounded-pill">
                                + Keranjang
                            </a>
                        @else
                            <button class="btn btn-sm btn-danger w-100 rounded-pill" disabled>Habis</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="card border-0 shadow-sm p-5">
                <i class="bi bi-cart-x display-1 text-muted"></i>
                <h4 class="mt-3 text-muted">Belum ada produk di kategori ini, Bre.</h4>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection