<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LootHub - Gaming Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @stack('styles')
    <style>
        :root {
            --dark-sidebar: #0f172a;
            --accent-color: #6366f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Syne', sans-serif;
            background-color: #f1f5f9;
            color: #1a1a1a;
            overflow-x: hidden;
        }

        /* --- SIDEBAR BASE --- */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background-color: var(--dark-sidebar);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem 1.5rem;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        /* --- MINI SIDEBAR STATE --- */
        .sidebar.mini {
            width: 85px;
            padding: 2rem 0.75rem;
        }

        .sidebar.mini .sidebar-brand img {
            max-width: 45px;
        }

        .sidebar.mini .sidebar-nav-link span,
        .sidebar.mini .nav-label,
        .sidebar.mini .user-details,
        .sidebar.mini .sidebar-nav-link i::after {
            display: none;
        }

        .sidebar.mini .sidebar-nav-link i {
            margin-right: 0;
            font-size: 1.3rem;
            width: 100%;
            text-align: center;
        }

        .sidebar.mini .user-info {
            justify-content: center;
            padding: 0.75rem 0;
        }

        .sidebar.mini .user-avatar {
            margin-right: 0;
        }

        .sidebar.mini .btn-logout span {
            display: none;
        }

        /* --- TOGGLE BUTTON --- */
        .toggle-sidebar-btn {
            position: absolute;
            right: -15px;
            top: 2.25rem;
            width: 30px;
            height: 30px;
            background: var(--accent-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid #f1f5f9;
            z-index: 1001;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .toggle-sidebar-btn:hover {
            background: #4f46e5;
            transform: scale(1.1);
        }

        .sidebar.mini .toggle-sidebar-btn {
            transform: rotate(180deg);
        }

        .sidebar.mini .toggle-sidebar-btn:hover {
            transform: rotate(180deg) scale(1.1);
        }

        /* --- BRAND --- */
        .sidebar-brand {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 2rem;
            text-decoration: none;
            width: 100%;
        }

        .sidebar-brand img {
            max-width: 180px;
            height: auto;
            transition: all 0.3s ease;
            filter: drop-shadow(0 0 10px rgba(99, 102, 241, 0.3));
        }

        /* --- NAVIGASI --- */
        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .sidebar-nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .sidebar-nav-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #ffffff;
        }

        .sidebar-nav-link.active {
            background-color: var(--accent-color);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .nav-label {
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            padding: 0 1rem;
            font-size: 0.65rem;
            color: #475569;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* --- FOOTER --- */
        .sidebar-footer {
            margin-top: auto;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background-color: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: var(--accent-color);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .btn-logout {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid rgba(220, 38, 38, 0.5);
            background: transparent;
            color: #f87171;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background-color: #dc2626;
            color: white;
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            margin-left: 280px;
            padding: 2.5rem;
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content.expanded {
            margin-left: 85px;
        }

        /* --- MOBILE --- */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 1.2rem;
            left: 1rem;
            z-index: 1001;
            background: #fff;
            border: 1px solid #ddd;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
                width: 280px !important;
            }

            .sidebar.show .toggle-sidebar-btn {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }

            .main-content {
                margin-left: 0 !important;
                padding-top: 5rem;
            }

            .overlay.show {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="mobile-toggle" id="mobileToggle"><i class="bi bi-list"></i></div>
    <div class="overlay" id="overlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="toggle-sidebar-btn" id="toggleSidebar">
            <i class="bi bi-chevron-left"></i>
        </div>

        <a href="{{ route('homepage') }}" class="sidebar-brand">
            <img src="{{ asset('images/iconLootPutih.png') }}" alt="Logo">
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ route('homepage') }}" class="sidebar-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> <span>Beranda</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('category.hub') }}" class="sidebar-nav-link {{ request()->is('category-hub') ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3-gap-fill"></i> <span>Kategori</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('cart.index') }}" class="sidebar-nav-link {{ request()->is('cart') ? 'active' : '' }}">
                    <i class="bi bi-cart-fill"></i> <span>Keranjang Saya</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('orders.index') }}" class="sidebar-nav-link {{ request()->is('my-orders') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> <span>Pesanan Saya</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('wishlist.index') }}" class="sidebar-nav-link {{ request()->is('wishlist') ? 'active' : '' }}">
                    <i class="bi bi-heart-fill"></i> <span>Wishlist</span>
                </a>
            </li>

            @auth
            @if(Auth::user()->role == 'admin')
            <li class="nav-label">Admin Panel</li>
            <li class="sidebar-nav-item">
                <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('products.index') }}" class="sidebar-nav-link {{ request()->is('products*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> <span>Kelola Produk</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('categories.index') }}" class="sidebar-nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> <span>Kelola Kategori</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('transaction.history') }}" class="sidebar-nav-link {{ request()->is('history*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> <span>Riwayat</span>
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
                    <div class="user-name text-white text-truncate" style="font-size: 0.85rem; font-weight:600;">{{ Auth::user()->name }}</div>
                    <div class="user-role text-white" style="font-size: 0.75rem;">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-dark w-100 py-2 fw-bold text-white border-secondary">
                <i class="bi bi-box-arrow-in-right"></i> <span>Login</span>
            </a>
            @endauth
        </div>
    </div>

    <div class="main-content" id="mainContent">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const mobileToggle = document.getElementById('mobileToggle');
        const overlay = document.getElementById('overlay');

        // Load saved sidebar state on page load
        window.addEventListener('DOMContentLoaded', () => {
            const sidebarState = localStorage.getItem('sidebarState');

            // Only apply mini state on desktop
            if (window.innerWidth > 991) {
                if (sidebarState === 'mini') {
                    sidebar.classList.add('mini');
                    mainContent.classList.add('expanded');
                }
            }
        });

        // Toggle Mini Sidebar (Desktop)
        toggleSidebar.onclick = () => {
            sidebar.classList.toggle('mini');
            mainContent.classList.toggle('expanded');

            // Save state to localStorage
            const isMini = sidebar.classList.contains('mini');
            localStorage.setItem('sidebarState', isMini ? 'mini' : 'full');
        }

        // Mobile Toggle
        mobileToggle.onclick = () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        overlay.onclick = () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }

        // Reset mini state on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth <= 991) {
                // Mobile: remove mini state
                sidebar.classList.remove('mini');
                mainContent.classList.remove('expanded');
            } else {
                // Desktop: restore saved state
                const sidebarState = localStorage.getItem('sidebarState');
                if (sidebarState === 'mini') {
                    sidebar.classList.add('mini');
                    mainContent.classList.add('expanded');
                }
            }
        });
    </script>
</body>

</html>
