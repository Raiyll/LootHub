@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @foreach($categories as $category)
        @if($category->products->count() > 0)
            
            <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
                <h3 class="fw-bold m-0 text-uppercase">
                    @if(Str::contains(strtolower($category->name), ['voucher', 'top up', 'game']))
                        {{ $category->name }}
                    @else
                        {{ $category->name }}
                    @endif
                </h3>
                <span class="badge bg-secondary">{{ $category->products->count() }} Produk</span>
            </div>

            <div class="row">
                @foreach($category->products as $p)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            {{-- Label Kategori --}}
                            <small class="text-muted fw-bold text-uppercase d-block mb-2">{{ $category->name }}</small>
                            
                            <h5 class="fw-bold mb-1">{{ $p->name }}</h5>
                            
                            {{-- Detail Tambahan (Nama Game) --}}
                            @if($p->game_name)
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-controller"></i> {{ $p->game_name }}
                                </p>
                            @else
                                <p class="text-success small mb-2">
                                    <i class="bi bi-patch-check"></i> Gear Original
                                </p>
                            @endif

                            <h5 class="text-primary fw-bold">Rp {{ number_format($p->price) }}</h5>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">Stok: {{ $p->stock }}</small>
                                
                                {{-- Tombol Beli / Habis --}}
                                @if($p->stock > 0)
                                    <a href="{{ route('cart.add', $p->id) }}" class="btn btn-dark btn-sm">
                                        + Keranjang
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-danger" disabled>Habis</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        @endif
    @endforeach

    @if($categories->every(fn($cat) => $cat->products->count() == 0))
        <div class="text-center py-5">
            <h4 class="text-muted">Abis...</h4>
        </div>
    @endif
</div>
@endsection