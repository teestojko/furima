<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryEditController;
use App\Http\Controllers\Admin\AdminReportController;
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
use App\Http\Controllers\Admin\CouponCreateController;
use App\Http\Controllers\Favorite\FavoriteController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Report\ReportController;

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


Route::get('/home', [AuthController::class, 'index'])->name('home');
Route::get('/filter', [SearchController::class, 'filter'])->name('products-filter');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/coupons/create', [CouponCreateController::class, 'create'])->name('coupons-create');
        Route::post('/coupons/store', [CouponCreateController::class, 'store'])->name('coupons-store');

        Route::resource('/categories', CategoryEditController::class);

        Route::get('/admin/reports', [AdminReportController::class, 'index'])->name('reports.index');
    });
});



Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function (Request $request) {
        return view('auth.verify_email');
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
        Route::get('/', [AuthController::class, 'userIndex'])->name('user-index');

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

        Route::get('/cart', [CartController::class, 'view'])->name('cart-view');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart-add');
        Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart-remove');
        Route::post('/cart/purchase', [CartController::class, 'preparePayment'])->name('cart-purchase');

        Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment-show');
        Route::post('/payment/success', [PaymentController::class, 'payment'])->name('payment-process');

        Route::get('/messages/{receiver}', [MessageController::class, 'index'])->name('messages-index');
        Route::post('/messages/{receiver}/send-email', [MessageReceivedController::class, 'store'])->name('messages-send-email');

        Route::get('/coupons', [CouponController::class, 'index'])->name('coupons-index');
        Route::post('/apply_coupon', [CouponController::class, 'apply'])->name('coupon-apply');
        Route::post('/coupons/{id}/claim', [CouponController::class, 'claim'])->name('coupons.claim');

        Route::post('/point-apply', [PaymentController::class, 'applyPoints'])->name('point-apply');

        Route::get('/my_page', [FavoriteController::class, 'showFavorites'])->name('user-my-page');


        Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggleFavorite'])->name('favorites-toggle');


        // Route::post('/favorites/{product}', [FavoriteController::class, 'toggleFavorite'])->name('favorites-toggle-add');
        // Route::delete('/favorites/{product}', [FavoriteController::class, 'toggleFavorite'])->name('favorites-toggle-remove');

        Route::get('/order-history', [OrderController::class, 'orderIndex'])->name('order-history');

        Route::get('/sales-history', [SaleController::class, 'showSalesHistory'])->name('sale-history');

        Route::get('/notification/show', [NotificationController::class, 'showNotification'])->name('notifications-show');
        Route::get('/notifications/mark-read/{notificationId}', [NotificationController::class, 'markAsReadAndMessageDetail'])->name('notifications-mark-read-and-message-detail');
        Route::get('/notifications/message/{notificationId}', [NotificationController::class, 'messageDetail'])->name('notifications-message-detail');

        Route::get('/report/create', [ReportController::class, 'create'])->name('report-create');
        Route::post('/report', [ReportController::class, 'store'])->name('report-store');
    });
});

