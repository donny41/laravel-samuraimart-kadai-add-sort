<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

require __DIR__.'/auth.php';

// Route::resource('products', ProductController::class);

// Route::resource('reviews', ReviewController::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('products', ProductController::class);

    Route::resource('reviews', ReviewController::class);

    Route::post('favorites/{product_id}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('favorites/{product_id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});
