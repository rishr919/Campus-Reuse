<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GreetController;
use App\Http\Controllers\MyProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index']);
Route::get('/hello/{name}', [GreetController::class, 'greet']);
Route::view('/hello', 'greet');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/barang', [ProductController::class, 'index'])->name('products.index');
Route::get('/cari', [SearchController::class, 'index'])->name('products.search');

Route::middleware('auth')->prefix('barang-saya')->name('products.')->group(function () {
    Route::get('/', [MyProductController::class, 'index'])->name('mine');
    Route::get('/buat', [MyProductController::class, 'create'])->name('create');
    Route::post('/', [MyProductController::class, 'store'])->name('store');
    Route::get('/{product}/edit', [MyProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [MyProductController::class, 'update'])->name('update');
    Route::patch('/{product}/status', [MyProductController::class, 'updateStatus'])->name('status');
    Route::delete('/{product}', [MyProductController::class, 'destroy'])->name('destroy');
});
