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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #fafafa; color: #1a1a1a; }

        /* Sidebar Navigation */
        .sidebar {
            position: fixed; left: 0; top: 0; height: 100vh; width: 280px;
            background-color: #ffffff; border-right: 1px solid #e5e7eb;
            padding: 2rem 1.5rem; z-index: 1000; transition: transform 0.3s ease;
            display: flex; flex-direction: column; /* Biar footer nempel bawah */
        }

        .sidebar-brand {
            font-size: 1.75rem; font-weight: 700; color: #1a1a1a;
            text-decoration: none; display: block; margin-bottom: 2rem; letter-spacing: -0.5px;
        }

        .sidebar-nav { list-style: none; padding: 0; margin: 0; flex-grow: 1; overflow-y: auto; }
        .sidebar-nav-item { margin-bottom: 0.25rem; }
        
        .sidebar-nav-link {
            display: flex; align-items: center; padding: 0.75rem 1rem;
            color: #6b7280; text-decoration: none; border-radius: 8px;
            font-weight: 500; font-size: 0.95rem; transition: all 0.2s ease;
        }

        .sidebar-nav-link i { margin-right: 0.75rem; font-size: 1.1rem; }
        .sidebar-nav-link:hover { background-color: #f3f4f6; color: #1a1a1a; }
        .sidebar-nav-link.active { background-color: #1a1a1a; color: #ffffff; }

        .sidebar-footer { margin-top: auto; padding-top: 1.5rem; border-top: 1px solid #f3f4f6; }
        .user-info { display: flex; align-items: center; padding: 0.75rem; background-color: #f9fafb; border-radius: 10px; margin-bottom: 1rem; }
        .user-avatar { width: 35px; height: 35px; border-radius: 50%; background-color: #1a1a1a; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 600; margin-right: 0.75rem; font-size: 0.8rem; }
        .user-name { font-weight: 600; font-size: 0.85rem; color: #1a1a1a; margin-bottom: 0; }
        .user-role { font-size: 0.75rem; color: #6b7280; }

        .btn-logout { width: 100%; padding: 0.6rem; border: 1px solid #e5e7eb; background-color: #ffffff; color: #dc2626; border-radius: 8px; font-weight: 600; font-size: 0.85rem; transition: all 0.2s ease; cursor: pointer; }
        .btn-logout:hover { background-color: #fef2f2; border-color: #dc2626; }
        .btn-login { width: 100%; padding: 0.75rem; background-color: #1a1a1a; color: #ffffff; border-radius: 8px; font-weight: 600; text-align: center; text-decoration: none; display: block; }

        /* Mobile Adjustments */
        .mobile-toggle { display: none; position: fixed; top: 1.2rem; left: 1rem; z-index: 1001; background: #fff; border: 1px solid #ddd; padding: 5px 10px; border-radius: 5px; }
        .main-content { margin-left: 280px; padding: 2rem; min-height: 100vh; }
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
        <a href="{{ route('homepage') }}" class="sidebar-brand">LootHub</a>

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

            <li class="mt-4 mb-2 px-3 small text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">
                Kategori Produk
            </li>
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
                <li class="mt-4 mb-2 px-3 small text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">
                    Admin Panel
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('products.index') }}" class="sidebar-nav-link {{ request()->is('products*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> Kelola Produk
                    </a>
                </li>
                @endif
            @endauth
        </ul>

        <div class="sidebar-footer">
            @auth
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn-login"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
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