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
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price
            ];
        }

        session()->put('cart', $cart);
        // Lempar langsung ke halaman keranjang
        return redirect()->route('cart.index')->with('success', 'Produk masuk keranjang!');
    }

    // Proses Bayar
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
    if (!$cart) return redirect()->back()->with('error', 'Keranjang kosong!');

    // Tambahkan validasi payment_method
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
        'payment_method' => $request->payment_method, // SIMPAN DISINI
        'pay_amount'     => $totalPrice,
        'change_amount'  => 0,
    ]);

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $id,
                'qty'        => $details['quantity'], // GANTI DISINI: dari 'quantity' jadi 'qty'
                'price'      => $details['price'],
            ]);

            // Potong stok
            \App\Models\Product::find($id)->decrement('stock', $details['quantity']);
        }

        // Di akhir fungsi checkout
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
        return view('user.cart', compact('cart'));
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
