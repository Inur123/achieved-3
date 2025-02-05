<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminTransaksiController;

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\ApprovedTransactionController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductSalesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
//auth
Route::middleware('auth')->group(function () {
    // User Dashboard Route
    Route::get('user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // Admin Dashboard Route
    Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});



Route::prefix('admin')->middleware('auth')->group(function () {
    // Authors Routes
    Route::get('/authors', [AuthorController::class, 'index'])->name('blog.authors.index');
    Route::get('/authors/create', [AuthorController::class, 'create'])->name('blog.authors.create');
    Route::post('/authors', [AuthorController::class, 'store'])->name('blog.authors.store');
    Route::get('/authors/{author}/edit', [AuthorController::class, 'edit'])->name('blog.authors.edit');
    Route::put('/authors/{author}', [AuthorController::class, 'update'])->name('blog.authors.update');
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('blog.authors.destroy');

    // Categories Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('blog.categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('blog.categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('blog.categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('blog.categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('blog.categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('blog.categories.destroy');

    // Posts Routes
    Route::get('/posts', [PostController::class, 'index'])->name('blog.posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('blog.posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('blog.posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('blog.posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('blog.posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('blog.posts.destroy');
    // Tags Routes
    Route::post('/tags', [TagController::class, 'store'])->name('blog.tags.store');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('blog.tags.destroy');
    Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('blog.tags.edit');
    Route::put('/tags/{tag}', [TagController::class, 'update'])->name('blog.tags.update');
    Route::get('/tags/create', [TagController::class, 'create'])->name('blog.tags.create');
    Route::get('/tags', [TagController::class, 'index'])->name('blog.tags.index');

    //products
    Route::resource('products', ProductController::class);
    Route::get('/admin/product-sales', [ProductSalesController::class, 'index'])->name('product.sales');



    //approved transactions
    Route::get('approved_transactions', [ApprovedTransactionController::class, 'index'])->name('approved_transactions.index');
    Route::post('approved_transactions/{id}', [ApprovedTransactionController::class, 'approve'])->name('approved_transactions.approve');
    Route::delete('approved_transactions/{id}', [ApprovedTransactionController::class, 'destroy'])->name('approved_transactions.destroy');
    Route::get('approved_transactions/{id}', [ApprovedTransactionController::class, 'show'])->name('approved_transactions.show');

    //transaksi
    Route::get('transaksi', [AdminTransaksiController::class, 'index'])->name('admin.transaksi.index');
    Route::get('transaksi/{userId}/detail', [AdminTransaksiController::class, 'showDetail'])->name('admin.transaksi.detail');
    Route::delete('transaksi/{transaction}', [AdminTransaksiController::class, 'destroy'])->name('admin.transaksi.destroy');

    // User Routes
    Route::get('user/data', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('user/data/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('user/data', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('user/data/{user}', [UserController::class, 'show'])->name('admin.user.show');
    Route::delete('user/data/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('user/data/{user}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('user/data/{user}', [UserController::class, 'update'])->name('admin.user.update');



});



// routes/web.php
Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
});

//laravel-socialite
Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);

Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);
