<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// route::get('admin/dashboard', [HomerController::class, 'index']);
// route::get('admin/dashboard', [HomerController::class, 'index'])->middleware(['auth', 'admin']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', [HomerController::class, 'index']);

    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin/products');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin/products/create');
    Route::post('/admin/products/save', [ProductController::class, 'save'])->name('admin/products/save');
    Route::get('/admin/products/edit/{id}', [ProductController::class, 'edit'])->name('admin/products/edit');
    Route::put('/admin/products/edit/{id}', [ProductController::class, 'update'])->name('admin/products/update');
    Route::delete('/admin/products/delete/{id}', [ProductController::class, 'delete'])->name('admin/products/delete');

    // Rute untuk Kategori
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin/categories');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin/categories/create');
    Route::post('/admin/categories/save', [CategoryController::class, 'save'])->name('admin/categories/save');
    Route::get('/admin/categories/edit/{id}', [CategoryController::class, 'edit'])->name('admin/categories/edit');
    Route::put('/admin/categories/edit/{id}', [CategoryController::class, 'update'])->name('admin/categories/update');
    Route::delete('/admin/categories/delete/{id}', [CategoryController::class, 'delete'])->name('admin/categories/delete');
});

require __DIR__ . '/auth.php';
