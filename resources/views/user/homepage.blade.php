@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Enhanced Carousel with Parallax Effect --}}
        <div id="steamCarousel" class="carousel slide shadow-lg mb-5 position-relative overflow-hidden" data-bs-ride="carousel"
            data-bs-interval="4000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#steamCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#steamCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#steamCarousel" data-bs-slide-to="2"></button>
            </div>

            <div class="carousel-inner rounded-4">
                <div class="carousel-item active">
                    <div class="parallax-wrapper">
                        <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=2070"
                            class="d-block w-100 banner-img parallax-img">
                        <div class="gradient-overlay"></div>
                    </div>
                    <div class="carousel-caption d-none d-md-block text-start p-4 slide-in-left">
                        <span class="badge bg-danger mb-2 pulse-badge">
                            <i class="bi bi-fire"></i> HOT DEALS
                        </span>
                        <h2 class="fw-bold display-5 text-uppercase glow-text">Summer Sale Is Here!</h2>
                        <p class="fs-5 mb-4">Dapatkan diskon gila-gilaan sampai <span class="highlight-text">80%</span>
                            untuk semua gaming gear.</p>
                        <a href="#produk-kategori" class="btn btn-primary btn-glow rounded-pill px-4 py-2 fw-bold">
                            Cek Sekarang <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="parallax-wrapper">
                        <img src="https://images.unsplash.com/photo-1593305841991-05c297ba4575?q=80&w=2057"
                            class="d-block w-100 banner-img parallax-img">
                        <div class="gradient-overlay"></div>
                    </div>
                    <div class="carousel-caption d-none d-md-block text-start p-4 text-white slide-in-right">
                        <span class="badge bg-primary mb-2 pulse-badge">
                            <i class="bi bi-star-fill"></i> NEW ARRIVAL
                        </span>
                        <h2 class="fw-bold display-5 text-uppercase glow-text">Ultimate Setup 2026</h2>
                        <p class="fs-5 mb-4">Upgrade setup gaming lu dengan gear paling <span
                                class="highlight-text">gahar</span> tahun ini.</p>
                        <a href="#produk-kategori" class="btn btn-light btn-glow rounded-pill px-4 py-2 fw-bold">
                            Lihat Koleksi <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="parallax-wrapper">
                        <img src="https://images.unsplash.com/photo-1571716846252-df1324ce17bb?q=80&w=1170"
                            class="d-block w-100 banner-img parallax-img">
                        <div class="gradient-overlay"></div>
                    </div>
                    <div class="carousel-caption d-none d-md-block text-start p-4 slide-in-bottom">
                        <span class="badge bg-warning text-dark mb-2 pulse-badge">
                            <i class="bi bi-lightning-charge-fill"></i> LIMITED EDITION
                        </span>
                        <h2 class="fw-bold display-5 text-uppercase glow-text">Controller Pro</h2>
                        <p class="fs-5 mb-4">Precision gaming. Feel the vibration, <span
                                class="highlight-text">dominate</span> the game.</p>
                        <a href="#produk-kategori" class="btn btn-dark btn-glow rounded-pill px-4 py-2 fw-bold">
                            Pre-Order Now <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#steamCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon p-3 bg-dark rounded-circle shadow-lg"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#steamCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon p-3 bg-dark rounded-circle shadow-lg"></span>
            </button>
        </div>

        {{-- Floating Particles Background --}}
        <div class="particles-container">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <div id="produk-kategori">
            @foreach ($categories as $category)
                @if ($category->products->count() > 0)
                    <div class="category-section fade-in-up">
                        <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
                            <h3 class="fw-bold text-uppercase border-start border-5 border-primary ps-3 category-title">
                                <i class="bi bi-grid-fill me-2"></i>{{ $category->name }}
                            </h3>
                            <span class="badge bg-gradient-primary rounded-pill shadow-lg px-3 py-2 count-badge">
                                {{ $category->products->count() }} Produk
                            </span>
                        </div>

                        <div class="product-wrapper">
                            <button class="scroll-btn left shadow-lg" onclick="scrollRow('{{ $category->id }}', -1)">
                                <i class="bi bi-chevron-left"></i>
                            </button>

                            <div class="product-row" id="row-{{ $category->id }}">
                                @foreach ($category->products as $p)
                                    <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                        <div class="card h-100 border-0 card-hover glass-effect">
                                            {{-- Stock Badge --}}
                                            @if ($p->stock > 0 && $p->stock < 5)
                                                <div class="stock-badge low-stock">
                                                    <i class="bi bi-exclamation-triangle-fill"></i> Hampir Habis!
                                                </div>
                                            @elseif($p->stock == 0)
                                                <div class="stock-badge sold-out">
                                                    <i class="bi bi-x-circle-fill"></i> Sold Out
                                                </div>
                                            @endif

                                            <div class="card-body text-center d-flex flex-column p-3">
                                                <a href="{{ route('product.show', $p->id) }}"
                                                    class="mb-3 d-block overflow-hidden rounded-3 img-container">
                                                    @if ($p->image)
                                                        <img src="{{ asset('storage/' . $p->image) }}" class="product-img"
                                                            loading="lazy">
                                                    @else
                                                        <img src="https://images.unsplash.com/photo-1612287230202-1ff1d85d1bdf?q=80&w=500"
                                                            class="product-img" loading="lazy">
                                                    @endif
                                                    <div class="img-overlay">
                                                        <i class="bi bi-eye-fill fs-3"></i>
                                                    </div>
                                                </a>

                                                <small class="category-badge">{{ $category->name }}</small>
                                                <h6 class="fw-bold mt-2 mb-2 product-title">{{ $p->name }}</h6>

                                                @if ($p->game_name)
                                                    <p class="text-muted small mb-2 game-tag">
                                                        <i class="bi bi-controller"></i> {{ $p->game_name }}
                                                    </p>
                                                @else
                                                    <p class="text-success small mb-2 verified-tag">
                                                        <i class="bi bi-patch-check-fill"></i> Gear Original
                                                    </p>
                                                @endif

                                                <h5 class="price-tag mt-auto mb-3">
                                                    Rp {{ number_format($p->price) }}
                                                </h5>

                                                <div
                                                    class="d-flex justify-content-between align-items-center pt-2 border-top action-bar">
                                                    <small class="stock-info">
                                                        <i class="bi bi-box-seam"></i> Stok:
                                                        <strong>{{ $p->stock }}</strong>
                                                    </small>

                                                    <div class="d-flex gap-2"> {{-- Tambahin wrapper biar tombol jejer --}}

                                                        {{-- TOMBOL WISHLIST DI SINI --}}
                                                        <form action="{{ route('wishlist.add', $p->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger rounded-circle shadow-sm">
                                                                <i class="bi bi-heart"></i>
                                                            </button>
                                                        </form>

                                                        @if ($p->stock > 0)
                                                            <form action="{{ route('product.show', $p->id) }}"
                                                                method="GET">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-cart rounded-pill px-3 shadow-sm">
                                                                    <i class="bi bi-cart-plus-fill"></i> Beli
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button class="btn-habis btn-sm rounded-pill px-3 shadow-sm"
                                                                disabled>
                                                                <i class="bi bi-x-circle text-white"></i> Habis
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button class="scroll-btn right shadow-lg" onclick="scrollRow('{{ $category->id }}', 1)">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Enhanced Empty State --}}
        @if ($categories->every(fn($cat) => $cat->products->count() == 0))
            <div class="text-center py-5 empty-state">
                <div class="empty-animation">
                    <i class="bi bi-emoji-frown display-1 text-muted"></i>
                    <div class="empty-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <h4 class="text-muted mt-4">Wah, belum ada produk nih Bre...</h4>
                <p class="text-muted">Stay tuned untuk koleksi gaming gear terbaru!</p>
            </div>
        @endif
    </div>

    <style>
        :root {
            --primary-color: #4ee6b3;
            --secondary-color: #ff3399;
            --dark-bg: #111827;
            --card-bg: rgba(255, 255, 255, 0.95);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        /* === CAROUSEL === */
        .parallax-wrapper {
            position: relative;
            overflow: hidden;
        }

        .banner-img {
            height: 500px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .carousel-item.active .parallax-img {
            animation: zoomIn 8s ease forwards;
        }

        @keyframes zoomIn {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.1);
            }
        }

        .gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(78, 230, 179, 0.3) 0%, rgba(255, 51, 153, 0.3) 100%);
            pointer-events: none;
        }

        .carousel-caption {
            bottom: 10%;
            background: rgba(17, 24, 39, 0.85);
            border-radius: 24px;
            backdrop-filter: blur(10px);
            border-left: 6px solid var(--primary-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        /* === ini animasi === */
        .slide-in-left {
            animation: slideInLeft 0.8s ease-out;
        }

        .slide-in-right {
            animation: slideInRight 0.8s ease-out;
        }

        .slide-in-bottom {
            animation: slideInBottom 0.8s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInBottom {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* === efek glowing === */
        .glow-text {
            text-shadow: 0 0 20px rgba(78, 230, 179, 0.5),
                0 0 40px rgba(78, 230, 179, 0.3);
        }

        .highlight-text {
            color: var(--primary-color);
            font-weight: bold;
            text-shadow: 0 0 10px rgba(78, 230, 179, 0.8);
        }

        .pulse-badge {
            animation: pulse 2s infinite;
            font-weight: bold;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 0 20px 5px rgba(255, 255, 255, 0);
            }
        }

        .btn-glow {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-glow:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(78, 230, 179, 0.4);
        }

        /* === partikel loh ya === */
        .particles-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 8px;
            height: 8px;
            background: var(--primary-color);
            border-radius: 50%;
            opacity: 0.3;
            animation: float 15s infinite;
        }

        .particle:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
            animation-duration: 12s;
        }

        .particle:nth-child(2) {
            left: 30%;
            animation-delay: 2s;
            animation-duration: 15s;
        }

        .particle:nth-child(3) {
            left: 50%;
            animation-delay: 4s;
            animation-duration: 18s;
        }

        .particle:nth-child(4) {
            left: 70%;
            animation-delay: 6s;
            animation-duration: 14s;
        }

        .particle:nth-child(5) {
            left: 90%;
            animation-delay: 8s;
            animation-duration: 16s;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.3;
            }

            90% {
                opacity: 0.3;
            }

            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* === section category mas === */
        .category-section {
            position: relative;
            z-index: 1;
        }

        .category-title {
            position: relative;
            display: inline-block;
            animation: fadeInUp 0.6s ease;
        }

        .category-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transition: width 0.5s ease;
        }

        .category-title:hover::after {
            width: 100%;
        }

        .count-badge {
            background: var(--secondary-color);
            animation: fadeIn 0.8s ease;
            font-size: 0.85rem;
        }

        /* === card produk woi === */
        .product-wrapper {
            position: relative;
            padding: 0 50px;
        }

        .product-row {
            display: flex;
            gap: 1.5rem;
            overflow-x: hidden;
            scroll-behavior: smooth;
            padding: 20px 5px 30px;
        }

        .product-card {
            min-width: 280px;
            max-width: 280px;
            flex-shrink: 0;
        }

        .glass-effect {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-hover {
            position: relative;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
        }

        .card-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(78, 230, 179, 0.1), transparent);
            transition: left 0.5s;
        }

        .card-hover:hover::before {
            left: 100%;
        }

        .card-hover:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 20px 40px rgba(78, 230, 179, 0.3),
                0 0 30px rgba(255, 51, 153, 0.2);
        }

        /* === image product === */
        .img-container {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .product-img {
            height: 200px;
            width: 100%;
            object-fit: contain;
            padding: 20px;
            transition: all 0.4s ease;
        }

        .img-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(78, 230, 179, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .img-overlay i {
            color: white;
            transform: scale(0);
            transition: transform 0.3s ease;
        }

        .img-container:hover .img-overlay {
            opacity: 1;
        }

        .img-container:hover .img-overlay i {
            transform: scale(1);
        }

        .img-container:hover .product-img {
            transform: scale(1.1);
        }

        /* === BADGES & TAGS === */
        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: bold;
            z-index: 10;
            animation: bounceIn 0.5s;
        }

        .low-stock {
            background: linear-gradient(135deg, #ffd700, #ffa500);
            color: #000;
        }

        .sold-out {
            background: #ff3399;
            color: white;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .category-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-color), #2dd4ac);
            color: var(--dark-bg);
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .product-title {
            color: #1f2937;
            min-height: 40px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .game-tag,
        .verified-tag {
            font-weight: 600;
        }

        .price-tag {
            background: #ff3399;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
            font-size: 1.4rem;
        }

        /* === ACTION BAR === */
        .action-bar {
            margin-top: auto;
        }

        .stock-info {
            color: #6b7280;
            font-weight: 600;
        }

        .btn-cart {
            background:  #ff3399;
            border: none;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-habis {
            background: #ff3399;
            border: none;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-cart:hover {
            background: linear-gradient(135deg, #2dd4ac, var(--primary-color));
            transform: scale(1.1);
            color: var(--dark-bg);
            box-shadow: 0 5px 20px rgba(78, 230, 179, 0.4);
        }

        /* === tombol scroll === */
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 3px solid var(--primary-color);
            background: rgba(17, 24, 39, 0.9);
            color: var(--primary-color);
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            backdrop-filter: blur(8px);
        }

        .scroll-btn:hover {
            background: var(--secondary-color);
            border: 3px solid var(--secondary-color);
            color: var(--dark-bg);
            transform: translateY(-50%) scale(1.2);
            box-shadow: 0 0 30px rgba(78, 230, 179, 0.8),
                0 0 60px rgba(78, 230, 179, 0.4);
        }

        .scroll-btn.left {
            left: 0;
        }

        .scroll-btn.right {
            right: 0;
        }

        /* === EMPTY STATE === */
        .empty-state {
            animation: fadeIn 1s ease;
        }

        .empty-animation {
            position: relative;
            display: inline-block;
        }

        .empty-dots {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 20px;
        }

        .empty-dots span {
            width: 12px;
            height: 12px;
            background: var(--primary-color);
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out;
        }

        .empty-dots span:nth-child(1) {
            animation-delay: -0.32s;
        }

        .empty-dots span:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes bounce {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* === SCROLLBAR STYLING === */
        .product-row::-webkit-scrollbar {
            display: none;
        }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .banner-img {
                height: 350px;
            }

            .product-card {
                min-width: 220px;
                max-width: 220px;
            }

            .scroll-btn {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }

            .product-wrapper {
                padding: 0 35px;
            }
        }
    </style>

    <script>
        function scrollRow(categoryId, direction) {
            const row = document.getElementById('row-' + categoryId);
            const cardWidth = 280;
            const gap = 24;
            const scrollAmount = (cardWidth + gap) * 2;

            row.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }

        // Add parallax effect on scroll
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.parallax-img');
            if (parallax) {
                parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.category-section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'all 0.6s ease';
            observer.observe(section);
        });
    </script>
@endsection
