<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;



// --- PUBLIC ROUTES (Bisa diakses tanpa login) ---
// Homepage pake HomeController biar kategori di sidebar sinkron
Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/category/{name}', [HomeController::class, 'category'])->name('category.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// --- AUTH ROUTES (Harus Login) ---
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Fitur Keranjang & Belanja User
    Route::get('/cart', [TransactionController::class, 'showCart'])->name('cart.index');
    Route::get('/add-to-cart/{id}', [TransactionController::class, 'addToCart'])->name('cart.add');
    Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::get('/my-orders', [TransactionController::class, 'myOrders'])->name('orders.index');
    Route::get('/receipt/{id}', [TransactionController::class, 'receipt'])->name('transaction.receipt');
    Route::get('/clear-cart', [TransactionController::class, 'clearCart'])->name('cart.clear');

    // --- ADMIN ONLY (Role: admin) ---
    Route::middleware('role:admin')->group(function () {
        // Dashboard Statistik
        Route::get('/dashboard', [TransactionController::class, 'dashboard'])->name('dashboard');
        
        // Manajemen Stok & Kategori (Otomatis index, create, store, edit, update, destroy)
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        
        // Riwayat Transaksi Global untuk Admin
        Route::get('/history', [TransactionController::class, 'history'])->name('transaction.history');
    });
});