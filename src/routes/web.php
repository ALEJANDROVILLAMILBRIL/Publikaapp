<?php

use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrderActionController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin,customer,seller'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::bind('category', function ($value) {
    return Category::where('slug', $value)->firstOrFail();
});

Route::bind('product', function ($value) {
    return Product::where('slug', $value)->firstOrFail();
});

Route::bind('user', function ($value) {
    return User::where('slug', $value)->firstOrFail();
});

Route::bind('role', function ($value) {
    return Role::where('slug', $value)->firstOrFail();
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'role:seller,admin'])->group(function () {

    Route::prefix('seller')->name('seller.')->group(function () {
        Route::get('/orders', [OrdersController::class, 'ordersIndex'])->name('orders.index');
        Route::post('/orders/{order}/update', [OrdersController::class, 'updateOrderStatus'])->name('orders.updateStatus');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/orders', [OrdersController::class, 'ordersIndex'])->name('orders.index');
        Route::post('/orders/{order}/update', [OrdersController::class, 'updateOrderStatus'])->name('orders.updateStatus');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::resource('carts', CartController::class)
        ->only(['index', 'store', 'update', 'destroy']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'processPayment'])->name('checkout.process');
    Route::get('/checkout/paypal/success', [CheckoutController::class, 'paypalSuccess'])->name('checkout.paypal.success');
    Route::get('/checkout/paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('checkout.paypal.cancel');

    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
});

Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::post('/orders/{order}/return', [OrderActionController::class, 'returnRequest'])
        ->name('orders.returnRequest');

    Route::post('/orders/{order}/incident', [OrderActionController::class, 'incidentReport'])
        ->name('orders.incidentReport');
});

Route::get('/', [ProductController::class, 'homepage'])->name('homepage');

Route::get('lang/{lang}', [LanguageController::class, 'switch'])->name('lang.switch');

require __DIR__ . '/auth.php';
