<?php

use App\Http\Controllers\Web\Frontend\CartController;
use App\Http\Controllers\Web\Frontend\HomeController;
use App\Http\Controllers\Web\Frontend\HomeProductController;
use App\Http\Controllers\Web\Frontend\HomeProductOrderController;
use App\Http\Controllers\Web\Frontend\HomeProductReviewController;
use App\Http\Controllers\Web\Frontend\HomeProductWishlistController;
use App\Http\Controllers\Web\Frontend\LoginController;
use App\Http\Controllers\Web\Frontend\SearchController;
use App\Http\Controllers\Web\Frontend\UserAddressController;
use App\Http\Controllers\Web\Frontend\FilteringController;
use Illuminate\Support\Facades\Route;

//! Route for Landing Pages
//Vacation
Route::get('/vacation', [HomeController::class, 'vacation'])->name('vacation');

//Newsletter Store
Route::post('/newsletter/store', [HomeController::class, 'newsletterStore'])->name('newsletter.store');

Route::middleware(['vacation'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

    //Dynamic Pages
    Route::get('/{page_slug}', [HomeController::class, 'dynamicPage'])->name('dynamic.page');

    //Contact Store
    Route::post('/contact/store', [HomeController::class, 'contactStore'])->name('contact.store');

    // Product Filtering
    Route::post('/filter-products', [FilteringController::class, 'filterProducts'])->name('products.filter');

    //Product Pages
    Route::get('/collection/category/{category_slug}', [HomeController::class, 'categoryProduct'])->name('category-product');
    Route::get('/collection/brand/{brand_slug}', [HomeController::class, 'brandProduct'])->name('brand-product');
    Route::get('/collections/all', [HomeController::class, 'catalogCollections'])->name('collections.catalog.all');
    Route::get('/collections/lookbook/all', [HomeController::class, 'lookBookCollections'])->name('collections.lookbook.all');

    //Product Detail Pages
    Route::get('/collection/{brand_slug}/products/{product_slug}', [HomeProductController::class, 'brandProductDetail'])->name('product.detail.brand');
    Route::get('/collection/{category_slug}/products/{product_slug}', [HomeProductController::class, 'categoryProductDetail'])->name('product.detail.category');
    Route::get('/collection/products/{product_slug}', [HomeProductController::class, 'productDetail'])->name('product.detail');

    //Review Percentages
    Route::get('/rating/percentages/{productID}', [HomeProductReviewController::class, 'getRatingPercentages'])->name('getRatingPercentages');

    //Google login
    Route::get('/auth/google', [LoginController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [LoginController::class, 'callback'])->name('auth.google-callback');

    //Login modal popup
    Route::get('/check-authentication', [LoginController::class, 'check_auth'])->name('user.check_authentication');

    //Live Search
    Route::get('/contact/search', [SearchController::class, 'search'])->name('search');

    //Session Country
    Route::post('/session/country', [UserAddressController::class, 'store'])->name('session.country.store');

    //    Product Review
    Route::post('/product/reviews/{productID}', [HomeProductReviewController::class, 'addReview'])->name('product.review.store');

    Route::post('/clear-session', function () {
        session()->forget('review');
        return redirect()->back();
    })->name('clear.session');

    //  Guest Session Wishlist
    Route::post('/guest/product/wishlist/{productID}', [HomeProductWishlistController::class, 'addOrRemoveGuest'])->name('product.wishlist.guest');
    Route::post('/guest/wishlist/item/remove', [HomeProductWishlistController::class, 'removeWishlistItemGuest'])->name('wishlist.item.remove.guest');
    Route::post('/guest/wishlist/move-to-cart', [HomeProductWishlistController::class, 'moveToCartGuest'])->name('wishlist.move.cart.guest');
    Route::post('/guest/wishlist/move-all-to-cart', [HomeProductWishlistController::class, 'moveAllToCartGuest'])->name('wishlist.move.all.cart.guest');

    //  Session Guest cart
    Route::controller(CartController::class)->group(function () {
        Route::get('/guest/cart/add', 'addToCartGuest')->name('cart.add.guest');
        Route::post('/guest/cart/remove', 'guestCartRemove')->name('cart.remove.guest');
        Route::post('/guest/carts/update', 'updateGuestCart')->name('cart.update.guest');
        Route::post('/guest/cart/move-to-wishlist', 'moveToWishlistGuest')->name('cart.move.wishlist.guest');
    });

    //Checkout Page
    Route::get('/guest/order/checkout', [HomeProductOrderController::class, 'checkoutGuest'])->name('checkout.guest');
    Route::post('/guest/order/complete', [HomeProductOrderController::class, 'newOrderGuest'])->name('order.new.guest');

    Route::middleware(['auth', 'verified'])->group(function () {

        // Wishlist
        Route::post('/product/wishlist/{productID}', [HomeProductWishlistController::class, 'addOrRemove'])->name('product.wishlist');
        Route::delete('/wishlist/item/remove/{id}', [HomeProductWishlistController::class, 'removeWishlistItem'])->name('wishlist.item.remove');
        Route::get('/wishlist/move-to-cart/{wishlistItemId}', [HomeProductWishlistController::class, 'moveToCart'])->name('wishlist.move.cart');
        Route::post('/wishlist/move-all-to-cart', [HomeProductWishlistController::class, 'moveAllToCart'])->name('wishlist.move.all.cart');

        // Product Review
        Route::post('/user/product/review/{productID}', [HomeProductReviewController::class, 'addReviewUser'])->name('user.product.review.store');
        Route::post('/user/clear-session', function () {
            session()->forget('review');
            return redirect()->back();
        })->name('user.clear.session');

        // Product Review Report
        Route::post('/user/product/review/report/{reviewID}', [HomeProductReviewController::class, 'addReviewReportUser'])->name('user.product.review.report.store');
        Route::post('/user/report/clear-session', function () {
            session()->forget('review-report');
            return redirect()->back();
        })->name('user.report.clear.session');

        // Review Like
        Route::post('/product/{reviewID}/saveLikes/', [HomeProductReviewController::class, 'saveLike'])->name('save.like');

        // User Country Update
        Route::patch('/user/country/update/{userId}', [UserAddressController::class, 'update'])->name('user.country.address.update');

        //  Route for add to cart
        Route::controller(CartController::class)->group(function () {
            Route::post('/cart/add', 'addToCart')->name('cart.add');
            Route::delete('/cart/item/remove/{id}', 'removeCartItem')->name('cart.item.remove');
            Route::post('/cart/update', 'update')->name('cart.update');
            Route::post('/cart/move-to-wishlist/{cartItemId}', 'moveToWishlist')->name('cart.move.wishlist');
        });

        //Checkout Page
        Route::get('/order/checkout', [HomeProductOrderController::class, 'checkout'])->name('checkout');
        Route::post('/order/complete', [HomeProductOrderController::class, 'newOrder'])->name('order.new');

        // Stripe Payment
        // Order
        Route::get('/order/success', [HomeProductOrderController::class, 'checkoutSuccess'])->name('order.success');
        Route::get('/order/cancel', [HomeProductOrderController::class, 'checkoutCancel'])->name('order.cancel');

        // Paypal payment
        Route::get('/paypal/success', [HomeProductOrderController::class, 'paypalSuccess'])->name('paypal.success');

    });

}); // Close vacation middleware group

require __DIR__ . '/auth.php';
