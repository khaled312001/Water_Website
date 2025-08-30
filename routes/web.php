<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Role Detection API
Route::post('/api/detect-role', [AuthController::class, 'detectRole'])->name('api.detect-role');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/suppliers', [HomeController::class, 'suppliers'])->name('suppliers');
Route::get('/supplier/{id}', [HomeController::class, 'supplierDetails'])->name('supplier.details');

// Products Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // User Profile
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Orders Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/track', [OrderController::class, 'track'])->name('orders.track');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Users Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
        
        // Suppliers Management
        Route::get('/suppliers', [AdminController::class, 'suppliers'])->name('suppliers');
        Route::get('/suppliers/create', [AdminController::class, 'createSupplier'])->name('suppliers.create');
        Route::post('/suppliers', [AdminController::class, 'storeSupplier'])->name('suppliers.store');
        Route::get('/suppliers/{id}', [AdminController::class, 'showSupplier'])->name('suppliers.show');
        Route::get('/suppliers/{id}/edit', [AdminController::class, 'editSupplier'])->name('suppliers.edit');
        Route::put('/suppliers/{id}', [AdminController::class, 'updateSupplier'])->name('suppliers.update');
        Route::delete('/suppliers/{id}', [AdminController::class, 'deleteSupplier'])->name('suppliers.delete');
        
        // Delivery Men Management
        Route::get('/delivery-men', [AdminController::class, 'deliveryMen'])->name('delivery-men');
        Route::get('/delivery-men/create', [AdminController::class, 'createDeliveryMan'])->name('delivery-men.create');
        Route::post('/delivery-men', [AdminController::class, 'storeDeliveryMan'])->name('delivery-men.store');
        Route::get('/delivery-men/{id}', [AdminController::class, 'showDeliveryMan'])->name('delivery-men.show');
        Route::get('/delivery-men/{id}/edit', [AdminController::class, 'editDeliveryMan'])->name('delivery-men.edit');
        Route::put('/delivery-men/{id}', [AdminController::class, 'updateDeliveryMan'])->name('delivery-men.update');
        Route::delete('/delivery-men/{id}', [AdminController::class, 'deleteDeliveryMan'])->name('delivery-men.delete');
        
        // Orders Management
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
        Route::get('/orders/{id}/edit', [AdminController::class, 'editOrder'])->name('orders.edit');
        Route::put('/orders/{id}', [AdminController::class, 'updateOrder'])->name('orders.update');
        Route::delete('/orders/{id}', [AdminController::class, 'deleteOrder'])->name('orders.delete');
        
        // Products Management
        Route::get('/products', [AdminController::class, 'products'])->name('products');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{id}', [AdminController::class, 'showProduct'])->name('products.show');
        Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
        Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');
        
        // Reviews Management
        Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
        Route::get('/reviews/{id}', [AdminController::class, 'showReview'])->name('reviews.show');
        Route::get('/reviews/{id}/edit', [AdminController::class, 'editReview'])->name('reviews.edit');
        Route::put('/reviews/{id}', [AdminController::class, 'updateReview'])->name('reviews.update');
        Route::delete('/reviews/{id}', [AdminController::class, 'deleteReview'])->name('reviews.delete');
        
        // Reports
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    });

    // Supplier Routes
    Route::middleware(['supplier'])->prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'supplierDashboard'])->name('dashboard');
        Route::get('/products', [AdminController::class, 'supplierProducts'])->name('products');
        Route::get('/orders', [AdminController::class, 'supplierOrders'])->name('orders');
        Route::get('/earnings', [AdminController::class, 'supplierEarnings'])->name('earnings');
    });

    // Delivery Routes
    Route::middleware(['delivery'])->prefix('delivery')->name('delivery.')->group(function () {
        Route::get('/dashboard', [DeliveryController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [DeliveryController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [DeliveryController::class, 'orderDetails'])->name('order.details');
        Route::post('/orders/{id}/status', [DeliveryController::class, 'updateOrderStatus'])->name('order.status');
        Route::post('/location', [DeliveryController::class, 'updateLocation'])->name('update-location');
        Route::post('/status', [DeliveryController::class, 'updateStatus'])->name('update-status');
        Route::get('/earnings', [DeliveryController::class, 'earnings'])->name('earnings');
        Route::get('/profile', [DeliveryController::class, 'profile'])->name('profile');
    });

    // Customer Routes
    Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'customerDashboard'])->name('dashboard');
    });
}); 