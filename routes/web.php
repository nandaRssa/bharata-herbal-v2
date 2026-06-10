<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReviewAdminController;

// ===================== PUBLIC ROUTES =====================
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/tentang', [PublicController::class, 'about'])->name('about');
Route::get('/kontak', [PublicController::class, 'contact'])->name('contact');

// Products
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');

// Cart
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
Route::post('/keranjang/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/keranjang/hapus', [CartController::class, 'remove'])->name('cart.remove');

// Orders
Route::get('/pesan', [OrderController::class, 'form'])->name('order.form');
Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');
Route::get('/pesanan/{orderNumber}/sukses', [OrderController::class, 'success'])->name('order.success');

// Order tracking (public, no login)
Route::get('/pesanan/{orderNumber}/status', [OrderTrackingController::class, 'show'])->name('order.track.show');
Route::post('/pesanan/{orderNumber}/status', [OrderTrackingController::class, 'verify'])->name('order.track.verify');
Route::post('/pesanan/{orderNumber}/ulasan', [OrderTrackingController::class, 'submitReview'])->name('order.track.review');
Route::get('/riwayat-pesanan', [OrderTrackingController::class, 'historyForm'])->name('order.history');
Route::post('/riwayat-pesanan', [OrderTrackingController::class, 'historyCheck'])->name('order.history.check');

// Payment (Midtrans)
// Catatan: route /payment/notification dikecualikan dari CSRF via bootstrap/app.php
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
Route::get('/pesanan/{order}/snap-token', [PaymentController::class, 'getSnapToken'])->name('payment.snap-token');
// ===================== AUTH ROUTES =====================
require __DIR__.'/auth.php';

Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'))
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================== ADMIN ROUTES =====================
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::get('/produk', [ProductAdminController::class, 'index'])->name('products.index');
    Route::get('/produk/tambah', [ProductAdminController::class, 'create'])->name('products.create');
    Route::post('/produk', [ProductAdminController::class, 'store'])->name('products.store');
    Route::get('/produk/{product}/edit', [ProductAdminController::class, 'edit'])->name('products.edit');
    Route::put('/produk/{product}', [ProductAdminController::class, 'update'])->name('products.update');
    Route::delete('/produk/{product}', [ProductAdminController::class, 'destroy'])->name('products.destroy');
    Route::post('/produk/{product}/toggle', [ProductAdminController::class, 'toggleActive'])->name('products.toggle');
    Route::delete('/produk/gambar/{image}', [ProductAdminController::class, 'deleteImage'])->name('products.image.delete');

    // Orders
    Route::get('/pesanan', [OrderAdminController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderAdminController::class, 'show'])->name('orders.show');
    Route::put('/pesanan/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('orders.status');

    // Stock
    Route::get('/stok', [StockController::class, 'index'])->name('stock.index');
    Route::put('/stok/{product}', [StockController::class, 'update'])->name('stock.update');

    // Reports
    Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/laporan/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::get('/laporan/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');

    // Settings
    Route::get('/pengaturan', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/pengaturan', [SettingController::class, 'update'])->name('settings.update');

    // Reviews
    Route::get('/ulasan', [ReviewAdminController::class, 'index'])->name('reviews.index');
    Route::get('/ulasan/tambah', [ReviewAdminController::class, 'create'])->name('reviews.create');
    Route::post('/ulasan', [ReviewAdminController::class, 'store'])->name('reviews.store');
    Route::get('/ulasan/{review}/edit', [ReviewAdminController::class, 'edit'])->name('reviews.edit');
    Route::put('/ulasan/{review}', [ReviewAdminController::class, 'update'])->name('reviews.update');
    Route::delete('/ulasan/{review}', [ReviewAdminController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/ulasan/{review}/toggle', [ReviewAdminController::class, 'toggle'])->name('reviews.toggle');
});
