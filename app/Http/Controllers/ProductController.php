<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil semua produk beserta nama kategorinya
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        // Ambil semua kategori dari database
        $categories = \App\Models\Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name'        => 'required',
            'game_name'   => 'nullable', // Ganti jadi nullable
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
        ]);

        \App\Models\Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Barang baru berhasil ditambah!');
    }

    // Menampilkan halaman form edit
    public function edit(Product $product)
    {
        $categories = \App\Models\Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Menyimpan perubahan data ke database
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'name'        => 'required',
            'game_name'   => 'nullable',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
{
    $product->delete();
    return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
}
}
