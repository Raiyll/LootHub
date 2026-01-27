<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    // Masukin barang ke keranjang (simpen di session)
    // Tambahkan "Request $request" di dalam kurung
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Ambil data player dari form
        $playerData = $request->input('player_data');

        // Buat KEY unik agar user bisa beli produk yang sama tapi untuk ID game berbeda
        // Kalau nggak pakai key unik, ID game yang pertama bakal ketiban
        $cartKey = $id . ($playerData ? '_' . md5($playerData) : '');

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = [
                "product_id" => $id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "game_name" => $product->game_name,
                "player_data" => $playerData // Simpan ID game di sini
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Produk masuk keranjang!');
    }
    // Proses Bayar
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart) return redirect()->back()->with('error', 'Keranjang kosong!');

        $request->validate([
            'payment_method' => 'required'
        ]);

        $totalPrice = 0;
        foreach ($cart as $details) {
            $totalPrice += $details['price'] * $details['quantity'];
        }

        $order = Order::create([
            'user_id'        => Auth::id(),
            'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(uniqid()),
            'total_price'    => $totalPrice,
            'payment_method' => $request->payment_method,
            'pay_amount'     => $totalPrice,
            'change_amount'  => 0,
        ]);

        foreach ($cart as $key => $details) {
            $realProductId = $details['product_id'];

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $realProductId,
                'qty'        => $details['quantity'],
                'price'      => $details['price'],
                // Simpan ID Player di sini agar Admin tahu akun mana yang harus di-top up
                'player_data' => $details['player_data'] ?? null,
            ]);

            // Potong stok dengan aman
            $product = \App\Models\Product::find($realProductId);
            if ($product) {
                $product->decrement('stock', $details['quantity']);
            }
        }

        session()->forget('cart');

        if (Auth::user() && Auth::user()->role == 'admin') {
            return redirect()->route('dashboard')->with('success', 'Transaksi Berhasil dicatat!');
        }

        return redirect()->route('homepage')->with('success', 'Pesanan lo berhasil, Bre!');
    }
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back();
    }

    public function receipt($id)
    {
        $order = \App\Models\Order::with('items.product')->findOrFail($id);
        return view('transactions.receipt', compact('order'));
    }

    public function history()
    {
        // Ambil semua order, urutkan dari yang terbaru
        $orders = \App\Models\Order::orderBy('created_at', 'desc')->get();
        return view('transactions.history', compact('orders'));
    }

    public function dashboard()
    {
        // 1. Total Pendapatan & Transaksi (Sudah ada)
        $totalRevenue = \App\Models\Order::sum('total_price');
        $todayTransactions = \App\Models\Order::whereDate('created_at', date('Y-m-d'))->count();

        // 2. Produk Terlaris (Top 5 berdasarkan total QTY terjual)
        $topProducts = \App\Models\OrderItem::with('product')
            ->select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        // 3. Stok Menipis (Produk yang stoknya di bawah 5)
        $lowStockProducts = \App\Models\Product::where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->get();

        return view('dashboard', compact('totalRevenue', 'todayTransactions', 'topProducts', 'lowStockProducts'));
    }

    public function homepage()
    {
        $gameProducts = Product::whereNotNull('game_name')->get();
        $physicalProducts = Product::whereNull('game_name')->get();
        $categories = Category::with('products')->get();

        return view('user.homepage', compact('gameProducts', 'physicalProducts', 'categories'));
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);

        // Hitung total di sini biar lebih aman
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('user.cart', compact('cart', 'total'));
    }
    public function myOrders()
    {
        // Mengambil data order milik user yang login, diurutkan dari yang terbaru
        $orders = \App\Models\Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('orders.index', compact('orders'));
    }
}
