    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\TransactionController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\GoogleController;
    use App\Http\Controllers\CheckoutController;
    use App\Http\Controllers\WishlistController;
    use App\Http\Controllers\DashboardController;

    // --- PUBLIC ROUTES ---
    Route::get('/', [HomeController::class, 'index'])->name('homepage');
    Route::get('/category/{name}', [HomeController::class, 'category'])->name('category.show');
    // Pindah ke sini biar semua bisa akses
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
        Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
    });

    // --- AUTH ROUTES ---
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/category-hub', [ProductController::class, 'categoryHub'])->name('category.hub');
        Route::get('/cart', [TransactionController::class, 'showCart'])->name('cart.index');
        Route::post('/add-to-cart/{id}', [TransactionController::class, 'addToCart'])->name('cart.add');
        Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
        Route::get('/my-orders', [TransactionController::class, 'myOrders'])->name('orders.index');
        Route::get('/receipt/{id}', [TransactionController::class, 'receipt'])->name('transaction.receipt');
        Route::post('/clear-cart', [TransactionController::class, 'clearCart'])->name('cart.clear');
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/add/{product_id}', [WishlistController::class, 'store'])->name('wishlist.add');
        Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'destroy'])->name('wishlist.remove');

        // --- ADMIN ONLY ---
            Route::middleware('role:admin')->group(function () {
                Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
                Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
                Route::resource('products', ProductController::class)->except(['show']);
                Route::resource('categories', CategoryController::class);
                Route::get('/history', [TransactionController::class, 'history'])->name('transaction.history');
            });
    });
