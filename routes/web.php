<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserHomeController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RegisteredController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\VerifyEmailController;

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
    return view('home');
});

// Admin Dashboard Route
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware(['auth', 'verified', 'admin']);

// User Home Route
Route::get('/user/home', [UserHomeController::class, 'index'])
    ->name('user.home')
    ->middleware(['auth']);

// Original Dashboard Route (kept for compatibility, but you can remove if not needed)
Route::get('/dashboard', function () {
    return auth()->user()->role === 'admin' 
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.home');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile.edit');
    
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});
// Login routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// User Home Controller Route
Route::get('/userHome', [UserHomeController::class, 'index'])->name('user.home')->middleware('auth');

require __DIR__.'/auth.php';

Route::prefix('admin/products')->name('admin.products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');  // This handles saving a new product
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    
    // Image deletion route
    Route::delete('/images/{image}', [ProductController::class, 'destroyImage'])->name('images.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});


Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');

Route::post('/users/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');

Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');

Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
Route::put('/admin/products/{id}', [ProductController::class, 'update']);
Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');

Route::post('/admin/products', [ProductController::class, 'store']);

Route::put('/admin/products/{id}', [ProductController::class, 'update']);

Route::prefix('admin')->group(function() {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Checkout routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/{order}', [CheckoutController::class, 'show'])->name('checkout.show');
});

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin', 'AdminController@index');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
});