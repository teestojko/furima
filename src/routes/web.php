<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\SearchController;
use App\Http\Controllers\Product\ShowController;
use App\Http\Controllers\Product\UpdateController;
use App\Http\Controllers\Product\ReviewController;
use App\Http\Controllers\Profile\UserEditController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Mail\MessageReceivedController;
use App\Http\Controllers\Coupon\CouponController;



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

        Route::post('/cart/add', [CartController::class, 'add'])->name('cart-add');
        Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart-remove');
        Route::get('/cart', [CartController::class, 'view'])->name('cart-view');
        Route::post('/cart/purchase', [CartController::class, 'preparePayment'])->name('cart-purchase');

        Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment-show');
        Route::post('/payment/success', [PaymentController::class, 'payment'])->name('payment-process');

        Route::get('/messages/{receiver}', [MessageController::class, 'index'])->name('messages-index');
        Route::post('/messages/{receiver}', [MessageController::class, 'store'])->name('messages-store');

        Route::post('/messages/{receiver}/send-email', [MessageReceivedController::class, 'store'])->name('messages-send-email');

        Route::get('/coupons', [CouponController::class, 'index'])->name('coupons-index');
        Route::post('/apply-coupon', [CouponController::class, 'apply'])->name('coupon-apply');


    });
});


