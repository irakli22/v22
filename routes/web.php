<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProductUploadController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\ImageUploadController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

// Route::resource('productUpload', ProductUploadController::class)
//     ->only(['index', 'store'])
//     ->middleware(['auth', 'verified']);


Route::get('/product-upload', [ProductUploadController::class, 'index'])->name('productUpload.index');
Route::get('/product-upload/{product}', [ProductUploadController::class, 'show'])->name('productUpload.show');
Route::post('/product-upload', [ProductUploadController::class, 'store'])->name('productUpload.store');

Route::resource('products', ProductsController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);
    
Route::get('/product/{product}', [ProductController::class, 'show']);

Route::get('/image-upload/{product}', [ImageUploadController::class, 'show']);



Route::get('/product-list', [ProductListController::class, 'show']);

require __DIR__ . '/auth.php';
