<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LootHub - Gaming Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --dark-sidebar: #0f172a; /* Warna biru gelap pekat */
            --accent-color: #6366f1;  /* Indigo Neon */
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: #1a1a1a; }

        /* Sidebar Navigation - DARK VERSION */
        .sidebar {
            position: fixed; left: 0; top: 0; height: 100vh; width: 280px;
            background-color: var(--dark-sidebar); /* Ganti jadi GELAP */
            border-right: 1px solid rgba(255,255,255,0.1);
            padding: 2rem 1.5rem; z-index: 1000; transition: transform 0.3s ease;
            display: flex; flex-direction: column;
        }

        .sidebar-brand {
            display: flex; justify-content: center; align-items: center;
            margin-bottom: 2rem; text-decoration: none; width: 100%;
        }

        .sidebar-brand img {
            max-width: 180px;
            height: auto;
            display: block;
            filter: drop-shadow(0 0 10px rgba(99, 102, 241, 0.3));
        }

        /* BAGIAN NAVIGASI */
        .sidebar-nav { 
            list-style: none; padding: 0; margin: 0; 
            flex-grow: 1; overflow-y: auto; scrollbar-width: none; 
        }

        .sidebar-nav::-webkit-scrollbar { display: none; }

        .sidebar-nav-item { margin-bottom: 0.25rem; }
        
        .sidebar-nav-link {
            display: flex; align-items: center; padding: 0.75rem 1rem;
            color: #94a3b8; /* Text abu-abu terang */
            text-decoration: none; border-radius: 8px;
            font-weight: 500; font-size: 0.95rem; transition: all 0.2s ease;
        }

        .sidebar-nav-link i { margin-right: 0.75rem; font-size: 1.1rem; }
        
        .sidebar-nav-link:hover { 
            background-color: rgba(255, 255, 255, 0.05); 
            color: #ffffff; 
        }

        .sidebar-nav-link.active { 
            background-color: var(--accent-color); 
            color: #ffffff; 
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        /* LABEL KATEGORI */
        .nav-label {
            margin-top: 1.5rem; margin-bottom: 0.5rem; padding: 0 1rem;
            font-size: 0.65rem; color: #475569; /* Warna label dipertegas */
            text-uppercase: uppercase; font-weight: 700; letter-spacing: 1px;
        }

        /* FOOTER & USER INFO */
        .sidebar-footer { 
            margin-top: auto; padding-top: 1.5rem; 
            border-top: 1px solid rgba(255,255,255,0.1); 
        }

        .user-info { 
            display: flex; align-items: center; padding: 0.75rem; 
            background-color: rgba(255, 255, 255, 0.03); 
            border-radius: 10px; margin-bottom: 1rem; 
        }

        .user-avatar { 
            width: 35px; height: 35px; border-radius: 50%; 
            background-color: var(--accent-color); 
            color: #ffffff; display: flex; align-items: center; 
            justify-content: center; font-weight: 600; 
            margin-right: 0.75rem; font-size: 0.8rem; 
        }

        .user-name { font-weight: 600; font-size: 0.85rem; color: #ffffff; margin-bottom: 0; }
        .user-role { font-size: 0.75rem; color: #64748b; }

        .btn-logout { 
            width: 100%; padding: 0.6rem; border: 1px solid rgba(220, 38, 38, 0.5); 
            background-color: transparent; color: #f87171; 
            border-radius: 8px; font-weight: 600; font-size: 0.85rem; 
            transition: all 0.2s ease; cursor: pointer; 
        }
        .btn-logout:hover { background-color: #dc2626; color: white; border-color: #dc2626; }

        /* Mobile Adjustments */
        .mobile-toggle { display: none; position: fixed; top: 1.2rem; left: 1rem; z-index: 1001; background: #fff; border: 1px solid #ddd; padding: 5px 10px; border-radius: 5px; }
        .main-content { margin-left: 280px; padding: 2.5rem; min-height: 100vh; }
        .overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 999; }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .mobile-toggle { display: block; }
            .main-content { margin-left: 0; padding-top: 5rem; }
            .overlay.show { display: block; }
        }
    </style>
</head>

<body>
    <div class="mobile-toggle" id="mobileToggle"><i class="bi bi-list"></i></div>
    <div class="overlay" id="overlay"></div>

    <div class="sidebar" id="sidebar">
        <a href="{{ route('homepage') }}" class="sidebar-brand">
            {{-- Pastikan logo ini yang versi putih/terang biar kelihatan --}}
            <img src="{{ asset('images/iconLootPutih.png') }}" alt="LootHub Logo">
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ route('homepage') }}" class="sidebar-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> Beranda
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('cart.index') }}" class="sidebar-nav-link {{ request()->is('cart') ? 'active' : '' }}">
                    <i class="bi bi-cart-fill"></i> Keranjang Saya
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('orders.index') }}" class="sidebar-nav-link {{ request()->is('my-orders') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> Pesanan Saya
                </a>
            </li>

            <li class="nav-label text-white">Kategori Produk</li>
            @foreach(\App\Models\Category::all() as $cat)
            <li class="sidebar-nav-item">
                <a href="{{ route('category.show', $cat->name) }}"
                    class="sidebar-nav-link {{ request()->is('category/'.$cat->name) ? 'active' : '' }}">
                    <i class="bi bi-tag"></i> {{ $cat->name }}
                </a>
            </li>
            @endforeach

            @auth
                @if(Auth::user()->role == 'admin')
                <li class="nav-label text-info">Admin Panel</li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill me-2"></i> Dashboard
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('products.index') }}" class="sidebar-nav-link {{ request()->is('products*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> Kelola Produk
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('categories.index') }}" class="sidebar-nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> Kelola Kategori
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('transaction.history') }}" class="sidebar-nav-link {{ request()->is('history*') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i> Riwayat Penjualan
                    </a>
                </li>
                @endif
            @endauth
        </ul>

        <div class="sidebar-footer">
            @auth
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-details overflow-hidden">
                    <div class="user-name text-truncate">{{ Auth::user()->name }}</div>
                    <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-dark w-100 py-2 fw-bold text-white border-secondary">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </a>
            @endauth
        </div>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        mobileToggle.onclick = () => { sidebar.classList.toggle('show'); overlay.classList.toggle('show'); }
        overlay.onclick = () => { sidebar.classList.remove('show'); overlay.classList.remove('show'); }
    </script>
</body>
</html>