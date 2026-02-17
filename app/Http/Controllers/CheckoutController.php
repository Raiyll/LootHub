<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Tambahin ini biar panggil ID lebih aman
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        $paymentMethod = $request->query('payment_method');

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $total = 0;
        foreach ($cart as $details) {
            if (isset($details['product_id'])) {
                // Sesuai request lu pake soft deletes, kita pake withTrashed [cite: 2026-01-13]
                $product = Product::withTrashed()->find($details['product_id']);
                if ($product && !$product->trashed()) {
                    $total += $details['price'] * $details['quantity'];
                }
            }
        }

        return view('user.checkout', compact('cart', 'total', 'paymentMethod'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) return redirect()->route('homepage');

        $request->validate([
            'payment_method' => 'required'
        ]);

        try {
            DB::transaction(function () use ($cart, $request) {
                $userId = Auth::id();

                $totalPrice = array_sum(array_map(function($item) {
                    return ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
                }, $cart));

                // Simpan ke tabel orders (sesuai kolom pada migration)
                $order = Order::create([
                    'user_id' => $userId,
                    'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(uniqid()),
                    'total_price' => $totalPrice,
                    'payment_method' => $request->payment_method ?? 'cash',
                    'pay_amount' => $totalPrice,
                    'change_amount' => 0,
                ]);

                foreach ($cart as $key => $details) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $details['product_id'],
                        'qty' => $details['quantity'],
                        'price' => $details['price'],
                        'player_data' => $details['player_data'] ?? null,
                    ]);

                    $product = Product::find($details['product_id']);
                    if ($product) {
                        $product->decrement('stock', $details['quantity']);
                    }
                }
            });

            session()->forget('cart');

            return redirect()->route('homepage')->with('success', 'Transaksi berhasil. Stok berkurang dan pesanan disimpan.');

        } catch (\Exception $e) {
            Log::error('Checkout Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses pesanan.');
        }
    }
}