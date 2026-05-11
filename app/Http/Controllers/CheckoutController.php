<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        if (empty($cart)) return redirect()->route('homepage');

        $request->validate([
            'payment_method' => 'required',
            'pay_amount' => 'required_if:payment_method,Tunai|numeric'
        ]);

        try {
            $orderId = null;

            DB::transaction(function () use ($cart, $request, &$orderId) {
                $totalPrice = array_sum(array_map(function ($item) {
                    return ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
                }, $cart));

                $received = ($request->payment_method === 'Tunai') ? $request->pay_amount : $totalPrice;
                $change = $received - $totalPrice;

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(uniqid()),
                    'total_price' => $totalPrice,
                    'payment_method' => $request->payment_method,
                    'pay_amount' => $received,
                    'change_amount' => $change,
                ]);

                $orderId = $order->id;

                foreach ($cart as $details) {
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

            // Gunakan route name yang konsisten: transaction.receipt
            return redirect()->route('transaction.receipt', $orderId)
                ->with('success', 'Transaksi Berhasil!');

        } catch (\Exception $e) {
            Log::error('Checkout Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses pesanan.');
        }
    }

    /**
     * Method Receipt Pindahan dari TransactionController
     */
    public function receipt($id)
    {
        // Load relasi product termasuk yang di-soft delete agar struk tetap lengkap
        $order = Order::with(['items.product' => function($query) {
            $query->withTrashed();
        }])->findOrFail($id);

        // Security: Hanya pemilik order atau Admin yang bisa akses struk ini
        if ($order->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        // Sesuaikan nama view dengan lokasi file struk lu
        // Kalau di resources/views/transactions/receipt.blade.php gunakan:
        return view('transactions.receipt', compact('order'));
    }
}
