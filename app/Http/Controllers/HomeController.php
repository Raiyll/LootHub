<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Halaman utama (Nampilin semua kategori & produk)
    public function index()
    {
        $categories = Category::with('products')->get();
        return view('user.homepage', compact('categories'));
    }

    // Halaman Filter (Cuma nampilin produk dari 1 kategori)
    public function category($name)
{
    $category = Category::where('name', $name)->firstOrFail();
    $products = Product::where('category_id', $category->id)->get();
    return view('categories.category_view', compact('category', 'products'));
}
}