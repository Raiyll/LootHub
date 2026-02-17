@extends('layouts.app')

@section('content')
<style>
    /* === ROOT & GLOBAL === */
    :root {
        --primary-mint: #4ee6b3;
        --secondary-pink: #ff3399;
        --accent-blue: #2563eb;
        --dark-bg: #0f172a;
        --glass-bg: rgba(255, 255, 255, 0.8);
    }

    /* === HERO SECTION === */
    .hero-section {
        position: relative;
        height: 400px;
        /* Gue naikin tingginya biar lebih lega */
        width: 100%;
        border-radius: 30px;
        overflow: hidden;
        z-index: 1;
        /* Hapus margin-bottom minus kalau lu gak mau konten bawah numpuk terlalu ekstrem */
        margin-bottom: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* object-position: center; Gue tambahin ini biar fokus ke tengah gambar */
        object-fit: cover;
        object-position: center;
        animation: zoomHero 20s infinite alternate ease-in-out;
    }

    @keyframes zoomHero {
        from {
            transform: scale(1);
        }

        to {
            transform: scale(1.15);
        }
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg,
                rgba(15, 23, 42, 0.2) 0%,
                rgba(15, 23, 42, 0.6) 50%,
                rgba(15, 23, 42, 0.9) 100%);
        backdrop-filter: blur(1px);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
    }

    .hero-title {
        font-weight: 800;
        font-size: 4rem;
        text-transform: uppercase;
        letter-spacing: -2px;
        margin-bottom: 0.5rem;
        text-shadow: 0 0 30px rgba(78, 230, 179, 0.5);
        background: linear-gradient(to right, #fff, #e2e8f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        max-width: 600px;
        color: #cbd5e1;
        font-weight: 500;
    }

    /* === NAVIGATION (Pink/Mint Preserved) === */
    .nav-container {
        position: relative;
        z-index: 10;
        margin-bottom: 40px;
        display: flex;
        justify-content: center;
    }

    .glass-nav {
        background: rgba(255, 51, 153, 0.95);
        /* Pink Base */
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 10px;
        border-radius: 60px;
        display: inline-flex;
        gap: 10px;
        box-shadow: 0 20px 50px rgba(255, 51, 153, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.4);
        transform: translateY(0);
        transition: transform 0.3s ease;
    }

    .glass-nav:hover {
        transform: translateY(-5px);
    }

    .nav-btn {
        color: #ffffff;
        padding: 12px 35px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
        letter-spacing: 0.5px;
    }

    .nav-btn:hover {
        background: #4ee6b3;
        /* Mint Hover */
        color: #0f172a;
        box-shadow: 0 0 20px rgba(78, 230, 179, 0.5);
        transform: scale(1.05) rotate(-1deg);
    }

    .nav-btn.active {
        background: #ffffff;
        color: #ff3399;
        /* Pink Text */
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        transform: scale(1.1);
        border-color: rgba(255, 51, 153, 0.2);
    }

    /* === GRID & LAYOUT === */
    .content-wrapper {
        min-height: 100vh;
        background-color: #f1f5f9;
        background-image:
            radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.05) 0%, transparent 20%),
            radial-gradient(circle at 90% 80%, rgba(255, 51, 153, 0.05) 0%, transparent 20%);
        padding-bottom: 5rem;
    }

    /* === PRODUCT CARD === */
    .product-card {
        background: var(--glass-bg);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        height: 100%;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.05);
    }

    .product-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.15);
        border-color: rgba(99, 102, 241, 0.4);
        z-index: 5;
    }

    .card-img-wrapper {
        position: relative;
        height: 260px;
        overflow: hidden;
        background: #f8fafc;
    }

    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .product-card:hover .card-img-wrapper img {
        transform: scale(1.15) rotate(2deg);
    }

    .overlay-actions {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.4s ease;
        gap: 15px;
    }

    .product-card:hover .overlay-actions {
        opacity: 1;
    }

    .action-btn {
        width: 50px;
        height: 50px;
        background: white;
        color: #0f172a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transform: translateY(20px);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-decoration: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .action-btn:hover {
        background: var(--accent-blue);
        color: white;
        transform: translateY(20px) scale(1.15) !important;
        /* Keep Y translate, enhance scale */
    }

    .product-card:hover .action-btn {
        transform: translateY(0);
    }

    .product-card:hover .action-btn:nth-child(2) {
        transition-delay: 0.1s;
    }

    /* === CARD CONTENT === */
    .card-content {
        padding: 24px;
        position: relative;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.8) 100%);
    }

    .category-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #64748b;
        font-weight: 800;
        margin-bottom: 8px;
        display: block;
    }

    .product-title {
        font-weight: 800;
        font-size: 1.15rem;
        margin-bottom: 15px;
        color: #1e293b;
        line-height: 1.35;
    }

    .product-desc {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 25px;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .price-tag {
        color: var(--accent-blue);
        font-weight: 900;
        font-size: 1.5rem;
        letter-spacing: -0.5px;
        text-shadow: 0 2px 10px rgba(37, 99, 235, 0.15);
    }

    .stock-pill {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
    }

    /* === ANIMATIONS === */
    .fade-enter-active {
        animation: fadeSlideUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
</style>

<div class="content-wrapper">
    <!-- Hero Banner -->
    <div class="hero-section">
        <img src="https://images.unsplash.com/photo-1636489951222-2af65c1d9ae3?q=80&w=1172&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="hero-bg" alt="Gaming Setup">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">LootHub Gallery</h1>
            <p class="hero-subtitle">Koleksi gear gaming premium untuk setup impianmu.</p>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container-fluid px-lg-5" x-data="{ activeTab: {{ $categories->first()->id ?? 0 }} }">

        <!-- Navigation -->
        <div class="nav-container">
            <nav class="glass-nav">
                @foreach($categories as $cat)
                <div
                    @click="activeTab = {{ $cat->id }}"
                    class="nav-btn"
                    :class="{ 'active': activeTab === {{ $cat->id }} }">
                    {{ $cat->name }}
                </div>
                @endforeach
            </nav>
        </div>

        <!-- Product Grid -->
        <div class="product-display pb-5">
            @foreach($categories as $category)
            <div
                x-show="activeTab === {{ $category->id }}"
                x-transition:enter="fade-enter-active"
                class="category-content">

                <div class="d-flex align-items-center justify-content-between mb-5 px-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white p-2 rounded-circle shadow-sm">
                            <i class="bi bi-grid-fill text-dark fs-5"></i>
                        </div>
                        <h3 class="fw-bold m-0 text-dark" style="letter-spacing: -0.5px;">{{ $category->name }}</h3>
                        <span class="badge rounded-pill bg-dark text-white px-3 py-2 ms-2">{{ $category->products->count() }} Items</span>
                    </div>
                </div>

                <div class="row g-4">
                    @forelse($category->products as $p)
                    <div class="col-xl-3 col-lg-4 col-md-6 text-decoration-none">
                        <div class="product-card h-100">
                            <div class="card-img-wrapper">
                                <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}">

                                <div class="overlay-actions">
                                    <a href="{{ route('product.show', $p->id) }}" class="action-btn" title="View Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>

                                <div class="position-absolute top-0 start-0 m-3 z-3">
                                    <span class="badge bg-white text-dark shadow-sm fw-bold px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle-fill text-success me-1"></i> Stock: {{ $p->stock }}
                                    </span>
                                </div>
                            </div>

                            <div class="card-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="category-label">{{ $category->name }}</span>
                                    <div class="d-flex gap-1">
                                        <i class="bi bi-star-fill text-warning" style="font-size: 0.7rem;"></i>
                                        <i class="bi bi-star-fill text-warning" style="font-size: 0.7rem;"></i>
                                        <i class="bi bi-star-fill text-warning" style="font-size: 0.7rem;"></i>
                                        <i class="bi bi-star-fill text-warning" style="font-size: 0.7rem;"></i>
                                        <i class="bi bi-star-fill text-secondary" style="font-size: 0.7rem; opacity: 0.3;"></i>
                                    </div>
                                </div>

                                <h6 class="product-title text-truncate">{{ $p->name }}</h6>
                                <p class="product-desc">{{ Str::limit($p->description, 60) }}</p>

                                <div class="d-flex justify-content-between align-items-end pt-3 border-top border-light">
                                    <div>
                                        <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600;">HARGA SPESIAL</small>
                                        <div class="price-tag">Rp {{ number_format($p->price) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-5 text-center">
                        <div class="bg-white rounded-5 p-5 shadow-sm d-inline-block border">
                            <div class="mb-4">
                                <i class="bi bi-controller text-secondary" style="font-size: 5rem; opacity: 0.2;"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-2">Oops! Kosong?</h3>
                            <p class="text-muted mb-0 fs-5">Sepertinya kategori ini belum ada isinya, Bre.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection