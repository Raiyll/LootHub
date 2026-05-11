<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Total pendapatan semua waktu
        $totalRevenue = Order::sum('total_price');

        // ── Transaksi hari ini
        $todayTransactions = Order::whereDate('created_at', today())->count();

        // ── Total produk aktif
        $totalProducts = Product::count();

        // ── Total user
        $totalUsers = User::count();

        // ── Best seller (top 5) — kolom qty bukan quantity
        $topProducts = OrderItem::selectRaw('product_id, SUM(qty) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->limit(5)
            ->get();

        // ── Stok menipis (stok <= 5)
        $lowStockProducts = Product::where('stock', '<=', 5)
            ->orderBy('stock')
            ->get();

        // ── Revenue 7 hari terakhir untuk chart
        $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $revenueLabels = [];
        $revenueData   = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $revenueLabels[] = $days[$date->dayOfWeek];

            $revenueData[] = (int) Order::whereDate('created_at', $date)
                ->sum('total_price');
        }

        // Pastikan namanya sama persis
        return view('dashboard', compact(
            'totalRevenue',
            'todayTransactions',
            'totalProducts', // <-- Pastikan ini ada
            'totalUsers',
            'topProducts',
            'lowStockProducts',
            'revenueLabels',
            'revenueData'
        ));
    }
}
