<?php

use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDeliveryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - NAYAN MART
|--------------------------------------------------------------------------
*/

// Public Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{id}/review', [ProductController::class, 'submitReview'])->name('product.review');
Route::get('/check-pincode', [ProductController::class, 'checkPincode'])->name('pincode.check');
Route::get('/search-suggestions', [HomeController::class, 'searchSuggestions'])->name('search.suggestions');

Route::get('/offers', [HomeController::class, 'offers'])->name('offers');
Route::get('/best-sellers', [HomeController::class, 'bestSellers'])->name('best_sellers');
Route::get('/new-arrivals', [HomeController::class, 'newArrivals'])->name('new_arrivals');
Route::get('/deals', [HomeController::class, 'offers'])->name('deals');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply_coupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove_coupon');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place_order');
Route::get('/order-success/{order_number}', [CheckoutController::class, 'success'])->name('order.success');
Route::get('/invoice/{order_number}', [CheckoutController::class, 'invoice'])->name('order.invoice');

// Order Tracking & Cancellation
Route::get('/track-order/{order_number?}', [OrderController::class, 'track'])->name('order.track');
Route::post('/order/{order_number}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');

// Wishlist
Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('wishlist.index');
Route::post('/wishlist/toggle', [CustomerController::class, 'toggleWishlist'])->name('wishlist.toggle');

// Customer Authentication
Route::get('/login', [CustomerController::class, 'showLogin'])->name('login');
Route::post('/login', [CustomerController::class, 'login'])->name('login.submit');
Route::get('/register', [CustomerController::class, 'showRegister'])->name('register');
Route::post('/register', [CustomerController::class, 'register'])->name('register.submit');
Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');

// Customer Account (Protected)
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::post('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::post('/password', [CustomerController::class, 'changePassword'])->name('password.change');
});

// Static & Support Pages
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/policy/{type}', [HomeController::class, 'policy'])->name('policy.show');

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::delete('/products/gallery-image/{id}', [AdminProductController::class, 'deleteGalleryImage'])->name('products.gallery.delete');
    Route::resource('products', AdminProductController::class);

    // Categories
    Route::resource('categories', AdminCategoryController::class);

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{id}/payment', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.payment');

    // Customers
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [AdminCustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers/{id}/toggle-status', [AdminCustomerController::class, 'toggleStatus'])->name('customers.toggle_status');

    // Coupons
    Route::get('/coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
    Route::post('/coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
    Route::post('/coupons/{id}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');
    Route::delete('/coupons/{id}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');

    // Banners
    Route::get('/banners', [AdminBannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [AdminBannerController::class, 'store'])->name('banners.store');
    Route::post('/banners/{id}/toggle', [AdminBannerController::class, 'toggle'])->name('banners.toggle');
    Route::delete('/banners/{id}', [AdminBannerController::class, 'destroy'])->name('banners.destroy');

    // Delivery & PIN codes
    Route::get('/delivery', [AdminDeliveryController::class, 'index'])->name('delivery.index');
    Route::post('/delivery', [AdminDeliveryController::class, 'store'])->name('delivery.store');
    Route::post('/delivery/rules', [AdminDeliveryController::class, 'updateRules'])->name('delivery.rules');
    Route::post('/delivery/{id}/toggle', [AdminDeliveryController::class, 'toggle'])->name('delivery.toggle');
    Route::delete('/delivery/{id}', [AdminDeliveryController::class, 'destroy'])->name('delivery.destroy');

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});
