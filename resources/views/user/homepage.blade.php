@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div id="steamCarousel" class="carousel slide shadow-sm mb-5" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#steamCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#steamCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#steamCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner rounded-4 shadow">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=2070" class="d-block w-100 banner-img">
                <div class="carousel-caption d-none d-md-block text-start p-4">
                    <span class="badge bg-danger mb-2">HOT DEALS</span>
                    <h2 class="fw-bold display-5 text-uppercase">Summer Sale Is Here!</h2>
                    <p class="fs-5">Dapatkan diskon gila-gilaan sampai 80% untuk semua gaming gear.</p>
                    <a href="#produk-kategori" class="btn btn-primary rounded-pill px-4 fw-bold">Cek Sekarang</a>
                </div>
            </div>

            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1593305841991-05c297ba4575?q=80&w=2057" class="d-block w-100 banner-img">
                <div class="carousel-caption d-none d-md-block text-start p-4 text-white">
                    <span class="badge bg-primary mb-2">NEW ARRIVAL</span>
                    <h2 class="fw-bold display-5 text-uppercase">Ultimate Setup 2026</h2>
                    <p class="fs-5">Upgrade setup gaming lu dengan gear paling gahar tahun ini.</p>
                    <a href="#produk-kategori" class="btn btn-light rounded-pill px-4 fw-bold">Lihat Koleksi</a>
                </div>
            </div>

            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1571716846252-df1324ce17bb?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100 banner-img">
                <div class="carousel-caption d-none d-md-block text-start p-4">
                    <span class="badge bg-warning text-dark mb-2">LIMITED EDITION</span>
                    <h2 class="fw-bold display-5 text-uppercase">Controller Pro</h2>
                    <p class="fs-5">Precision gaming. Feel the vibration, dominate the game.</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#steamCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon p-3 bg-dark rounded-circle"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#steamCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon p-3 bg-dark rounded-circle"></span>
        </button>
    </div>

    <div id="produk-kategori">
        @foreach($categories as $category)
        @if($category->products->count() > 0)
        <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
            <h3 class="fw-bold text-uppercase border-start border-4 border-primary ps-3">
                {{ $category->name }}
            </h3>
            <span class="badge bg-secondary rounded-pill shadow-sm">{{ $category->products->count() }} Produk</span>
        </div>

        <div class="product-wrapper">
            <button class="scroll-btn left shadow" onclick="scrollRow('{{ $category->id }}', -1)">‹</button>

            <div class="product-row" id="row-{{ $category->id }}">
                @foreach($category->products as $p)
                <div class="product-card">
                    <div class="card h-100 shadow-sm border-0 card-hover">
                        <div class="card-body text-center d-flex flex-column">

                            <a href="{{ route('product.show', $p->id) }}" class="mb-3 d-block overflow-hidden rounded-3">
                                @if($p->image)
                                <img src="{{ asset('storage/' . $p->image) }}" class="product-img">
                                @else
                                <img src="https://images.unsplash.com/photo-1612287230202-1ff1d85d1bdf?q=80&w=500" class="product-img">
                                @endif
                            </a>

                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">{{ $category->name }}</small>
                            <h6 class="fw-bold mt-2 text-truncate">{{ $p->name }}</h6>

                            @if($p->game_name)
                            <p class="text-muted small mb-2"><i class="bi bi-controller"></i> {{ $p->game_name }}</p>
                            @else
                            <p class="text-success small mb-2"><i class="bi bi-patch-check"></i> Gear Original</p>
                            @endif

                            <h5 class="text-primary fw-bold mt-auto mb-3">
                                Rp {{ number_format($p->price) }}
                            </h5>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <small class="text-muted">Stok: {{ $p->stock }}</small>
                                @if($p->stock > 0)
                                <form action="{{ route('product.show', $p->id) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-sm rounded-pill px-3 shadow-sm" style="background-color: #4ee6b3; border: none;">
                                        + <i class="bi bi-cart text-dark"></i>
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm" style="background-color: #ff3399; border: none;" disabled>Habis</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <button class="scroll-btn right shadow" onclick="scrollRow('{{ $category->id }}', 1)">›</button>
        </div>
        @endif
        @endforeach
    </div>

    {{-- Fallback Kalau Kosong --}}
    @if($categories->every(fn($cat) => $cat->products->count() == 0))
    <div class="text-center py-5">
        <i class="bi bi-emoji-frown display-1 text-muted"></i>
        <h4 class="text-muted mt-3">Wah, belum ada produk nih Bre...</h4>
    </div>
    @endif
</div>

<style>
    .banner-img {
        height: 450px;
        object-fit: cover;
        filter: brightness(0.7);
    }

    .carousel-caption {
        bottom: 15%;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 20px;
        backdrop-filter: blur(5px);
        border-left: 5px solid #0d6efd;
    }

    /* === PRODUCT SLIDER === */
    .product-wrapper {
        position: relative;
    }

    .product-row {
        display: flex;
        gap: 1.2rem;
        overflow-x: hidden;
        scroll-behavior: smooth;
        padding: 15px 5px 25px;
    }

    .product-card {
        min-width: 260px;
        max-width: 260px;
        flex-shrink: 0;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .product-img {
        height: 180px;
        width: 100%;
        object-fit: contain;
        background-color: #ffffff;
        padding: 15px;
        transition: transform 0.3s ease;
    }

    .product-img:hover {
        transform: scale(1.05);
    }

    /* Update Scroll Button ke Warna Tema Baru */
    .scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 5;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 2px solid #4ee6b3;
        /* Pake warna tema lu #4ee6b3 dengan sedikit transparansi */
        background: rgba(78, 230, 179, 0.9);
        color: #111827;
        /* Icon panah warna gelap biar kontras */
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(78, 230, 179, 0.4);
        backdrop-filter: blur(4px);
    }

    .scroll-btn:hover {
        background: #ff3399;
        /* Full warna pas hover */
        border: solid 2px #ff3399;
        color: #4ee6b3;
        transform: translateY(-50%) scale(1.15);
        box-shadow: 0 0 20px rgba(78, 230, 179, 0.8);
        /* Efek Glow */
    }

    /* Biar tombol gak mentok banget ke pinggir */
    .scroll-btn.left {
        left: -10px;
    }

    .scroll-btn.right {
        right: -10px;
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
    }

    /* Hilangkan scrollbar manual untuk kenyamanan visual */
    .product-row::-webkit-scrollbar {
        display: none;
    }
</style>

<script>
    function scrollRow(categoryId, direction) {
        const row = document.getElementById('row-' + categoryId);
        // Geser sejauh 2 card sekali klik
        const shiftWidth = 280 * 2;
        row.scrollBy({
            left: direction * shiftWidth,
            behavior: 'smooth'
        });
    }
</script>

@endsection