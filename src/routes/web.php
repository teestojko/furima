<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Products\SearchController;
use App\Http\Controllers\Products\ShowController;
use App\Http\Controllers\Products\UpdateController;
use App\Http\Controllers\UserEditController;
use App\Http\Controllers\Products\ReviewController;
use App\Http\Controllers\ProfileController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', [AuthController::class, 'index']);

Route::get('/home', [AuthController::class, 'index'])->name('home');
Route::get('/filter', [SearchController::class, 'filter'])->name('products-filter');

Route::prefix('admin')->name('admin-')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function (Request $request) {
        return view('Auth.verify_email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->intended(RouteServiceProvider::HOME);
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'メールを再送信しました');
    })->middleware('throttle:6,1')->name('verification.send');

    Route::middleware('verified')->group(function () {
        Route::get('/', [AuthController::class, 'userMyPage'])->name('user-my-page');

        Route::get('/products/{product}/show', [ShowController::class, 'show'])->name('products-show');

        Route::get('/products/{product}/edit', [UpdateController::class, 'edit'])->name('products-edit');
        Route::put('/products/{product}/update', [UpdateController::class, 'update'])->name('products-update');

        Route::get('/products/create', [ProductController::class, 'create'])->name('products-create');
        Route::post('/products', [ProductController::class, 'store'])->name('products-store');

        Route::get('/review/{product}', [ReviewController::class, 'review'])->name('reviews-review');
        Route::get('/products/{product}/reviews', [ReviewController::class, 'index'])->name('reviews-index');
        Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews-store');
        Route::delete('/reviews/index/{review}', [ReviewController::class, 'destroy'])->name('reviews-destroy');

        Route::get('/user/edit', [UserEditController::class, 'edit'])->name('user-edit');
        Route::post('/user/update', [UserEditController::class, 'update'])->name('user-update');

        Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile-show');
    });
});


