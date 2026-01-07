<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TransactionController extends Controller
{
    // Tampilan Halaman Kasir
    public function index()
    {
        $products = \App\Models\Product::all();
        return view('transactions.index', compact('products'));
    }

    // Masukin barang ke keranjang (simpen di session)
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "game_name" => $product->game_name
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back();
    }

    // Proses Bayar
    public function checkout(Request $request)
{
    $cart = session()->get('cart');
    if(!$cart) return redirect()->back();

    $totalPrice = 0;
    foreach($cart as $details) {
        $totalPrice += $details['price'] * $details['quantity'];
    }

    // Ambil uang bayar dari request
    $payAmount = $request->pay_amount;
    $changeAmount = $payAmount - $totalPrice;

    // Simpan Data Order dengan nominal asli
    $order = Order::create([
        'invoice_number' => 'INV-' . date('YmdHis'),
        'total_price' => $totalPrice,
        'pay_amount' => $payAmount,
        'change_amount' => $changeAmount,
    ]);

    // ... (sisanya sama kayak kodingan sebelumnya: simpan detail & kurangi stok) ...
    foreach($cart as $id => $details) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $id,
            'qty' => $details['quantity'],
            'price' => $details['price'],
        ]);
        Product::find($id)->decrement('stock', $details['quantity']);
    }

    session()->forget('cart');
    return redirect()->route('transaction.receipt', $order->id);
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
}