<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // Tambahin ini biar rapi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // WAJIB ADA ini buat hapus foto lama

class ProductController extends Controller
{
    public function index()
    {
        // Tanpa withTrashed(), barang yang dihapus gak bakal keliatan di tabel admin
        $products = \App\Models\Product::withTrashed()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            // game_name gak wajib, biar bisa buat barang fisik juga
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Produk Berhasil Ditambah!');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'name'        => 'required',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'game_name'   => 'nullable',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 1. Ambil data kecuali image
        $data = $request->except('image');

        // 2. Logika Update Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama kalau ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('products', $filename, 'public');
            $data['image'] = $path;
        }

        // 3. Update data ke database
        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil diarsipkan (Soft Delete)!');
    }

    public function restore($id)
    {
        // Mengambil data yang sudah di-soft delete berdasarkan ID
        $product = \App\Models\Product::withTrashed()->findOrFail($id);

        // Mengembalikan status delete-nya
        $product->restore();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dipulihkan!');
    }
}
