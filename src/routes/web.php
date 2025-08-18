<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
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

Route::middleware(['auth', 'role:admin,customer'])->group(function () {
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

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/', [ProductController::class, 'homepage']);

Route::get('lang/{lang}', [LanguageController::class, 'switch'])->name('lang.switch');

require __DIR__.'/auth.php';
