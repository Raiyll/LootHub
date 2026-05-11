<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->with('product')->get();
        return view('user.wishlist', compact('wishlists'));
    }

    public function store($product_id)
    {
        // Cek dulu udah ada di wishlist belum
        $exists = Wishlist::where('user_id', Auth::id())->where('product_id', $product_id)->first();

        if (!$exists) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $product_id
            ]);
            return redirect()->back()->with('success', 'Barang berhasil dipantau, Bre!');
        }

        return redirect()->back()->with('error', 'Barang udah ada di wishlist lu!');
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->findOrFail($id);
        $wishlist->delete();

        return redirect()->back()->with('success', 'Barang dibuang dari wishlist.');
    }
}
