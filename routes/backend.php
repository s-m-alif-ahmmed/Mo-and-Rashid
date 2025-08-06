<?php

use App\Http\Controllers\Web\Backend\CountryController;
use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\Web\Backend\UserController;
use App\Http\Controllers\Web\Backend\Product\CategoryController;
use App\Http\Controllers\Web\Backend\Product\BrandController;
use App\Http\Controllers\Web\Backend\Product\ColorController;
use App\Http\Controllers\Web\Backend\Product\SizeController;
use App\Http\Controllers\Web\Backend\FaqController;
use App\Http\Controllers\Web\Backend\Product\ProductController;
use App\Http\Controllers\Web\Backend\Query\NewsletterController;
use App\Http\Controllers\Web\Backend\Query\ContactController;
use App\Http\Controllers\Web\Backend\Product\WishlistController;
use App\Http\Controllers\Web\Backend\Settings\SocialController;
use App\Http\Controllers\Web\Backend\Product\BackendProductReviewController;
use App\Http\Controllers\Web\Backend\Order\OrderController;
use App\Http\Controllers\Web\Backend\VacationController;
use App\Http\Controllers\Web\Backend\Product\BackendReviewReportController;
use Illuminate\Support\Facades\Route;

//! Route for Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//! Route for Users Page
Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')->name('user.index');
    Route::get('/user/status/{id}', 'status')->name('user.status');
    Route::delete('/user/destroy/{id}', 'destroy')->name('user.destroy');
});

//! Route for Users Page
Route::controller(NewsletterController::class)->name('queries.')->group(function () {
    Route::get('/queries/newsletter', 'index')->name('newsletter.index');
    Route::delete('/queries/newsletter/destroy/{id}', 'destroy')->name('newsletter.destroy');
});

//! Route for Users Page
Route::controller(ContactController::class)->name('queries.')->group(function () {
    Route::get('/queries/contact', 'index')->name('contact.index');
    Route::get('/queries/contact/detail/{id}', 'show')->name('contact.show');
    Route::get('/queries/contact/status/{id}', 'status')->name('contact.status');
    Route::patch('/queries/contact/update/{id}', 'update')->name('contact.update');
    Route::delete('/queries/contact/destroy/{id}', 'destroy')->name('contact.destroy');
});

//! Route for Countries Page
Route::controller(CountryController::class)->name('user.')->group(function () {
    Route::get('/country', 'index')->name('country.index');
    Route::get('/country/create', 'create')->name('country.create');
    Route::post('/country/store', 'store')->name('country.store');
    Route::get('/country/edit/{id}', 'edit')->name('country.edit');
    Route::patch('/country/update/{id}', 'update')->name('country.update');
    Route::get('/country/status/{id}', 'status')->name('country.status');
    Route::delete('/country/delete/{id}', 'destroy')->name('country.destroy');
});

//! Route for Products Page
Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::get('/products/create', 'create')->name('products.create');
    Route::post('/products/store', 'store')->name('products.store');
    Route::get('/products/edit/{id}', 'edit')->name('products.edit');
    Route::patch('/products/update/{id}', 'update')->name('products.update');
    Route::get('/products/status/{id}', 'status')->name('products.status');
    Route::delete('/products/delete/{id}', 'destroy')->name('products.destroy');
});

//! Route for Categories Page
Route::controller(CategoryController::class)->name('product.')->group(function () {
    Route::get('/category', 'index')->name('category.index');
    Route::get('/category/create', 'create')->name('category.create');
    Route::post('/category/store', 'store')->name('category.store');
    Route::get('/category/edit/{id}', 'edit')->name('category.edit');
    Route::patch('/category/update/{id}', 'update')->name('category.update');
    Route::get('/category/status/{id}', 'status')->name('category.status');
    Route::delete('/category/delete/{id}', 'destroy')->name('category.destroy');
});

//! Route for Brands Page
Route::controller(BrandController::class)->name('product.')->group(function () {
    Route::get('/brand', 'index')->name('brand.index');
    Route::get('/brand/create', 'create')->name('brand.create');
    Route::post('/brand/store', 'store')->name('brand.store');
    Route::get('/brand/edit/{id}', 'edit')->name('brand.edit');
    Route::patch('/brand/update/{id}', 'update')->name('brand.update');
    Route::get('/brand/status/{id}', 'status')->name('brand.status');
    Route::delete('/brand/delete/{id}', 'destroy')->name('brand.destroy');
});

//! Route for Colors Page
Route::controller(ColorController::class)->name('product.')->group(function () {
    Route::get('/color', 'index')->name('color.index');
    Route::get('/color/create', 'create')->name('color.create');
    Route::post('/color/store', 'store')->name('color.store');
    Route::get('/color/edit/{id}', 'edit')->name('color.edit');
    Route::patch('/color/update/{id}', 'update')->name('color.update');
    Route::get('/color/status/{id}', 'status')->name('color.status');
    Route::delete('/color/delete/{id}', 'destroy')->name('color.destroy');
});

//! Route for Sizes Page
Route::controller(SizeController::class)->name('product.')->group(function () {
    Route::get('/size', 'index')->name('size.index');
    Route::get('/size/create', 'create')->name('size.create');
    Route::post('/size/store', 'store')->name('size.store');
    Route::get('/size/edit/{id}', 'edit')->name('size.edit');
    Route::patch('/size/update/{id}', 'update')->name('size.update');
    Route::get('/size/status/{id}', 'status')->name('size.status');
    Route::delete('/size/delete/{id}', 'destroy')->name('size.destroy');
});

//! Route for FAQs Page
Route::controller(FaqController::class)->group(function () {
    Route::get('/faq', 'index')->name('faq.index');
    Route::get('/faq/create', 'create')->name('faq.create');
    Route::post('/faq/store', 'store')->name('faq.store');
    Route::get('/faq/edit/{id}', 'edit')->name('faq.edit');
    Route::patch('/faq/update/{id}', 'update')->name('faq.update');
    Route::get('/faq/status/{id}', 'status')->name('faq.status');
    Route::delete('/faq/delete/{id}', 'destroy')->name('faq.destroy');
});

//! Route for Wishlist Page
Route::controller(WishlistController::class)->name('product.')->group(function () {
    Route::get('/product/wishlist', 'index')->name('wishlist.index');
    Route::delete('/product/wishlist/delete/{id}', 'destroy')->name('wishlist.destroy');
});

//! Route for Social Media
Route::controller(SocialController::class)->group(function () {
    Route::get('/social', 'index')->name('social.index');
    Route::get('/social/create', 'create')->name('social.create');
    Route::post('/social/store', 'store')->name('social.store');
    Route::get('/social/edit/{id}', 'edit')->name('social.edit');
    Route::patch('/social/update/{id}', 'update')->name('social.update');
    Route::get('/social/status/{id}', 'status')->name('social.status');
    Route::delete('/social/delete/{id}', 'destroy')->name('social.destroy');
});

//! Route for Order
Route::controller(OrderController::class)->name('order.')->group(function () {
    Route::get('/orders', 'index')->name('index');
    Route::get('/order/pending-payment', 'pendingPayment')->name('index.pending.payment');
    Route::get('/order/payment-failed', 'paymentFailed')->name('index.payment.failed');
    Route::get('/order/all-orders', 'allOrders')->name('index.all.orders');
    Route::get('/order/Completed', 'indexComplete')->name('index.completed');
    Route::get('/order/Return', 'indexReturn')->name('index.return');
    Route::get('/order/Canceled', 'indexCanceled')->name('index.canceled');
    Route::get('/order/detail/{id}', 'show')->name('show');
    Route::get('/order/invoice/{id}', 'invoice')->name('invoice');
    Route::post('/order/status/{id}', 'status')->name('status');
    Route::delete('/order/delete/{id}', 'destroy')->name('destroy');
});

//! Route for Product Reviews and Report
Route::controller(BackendProductReviewController::class)->name('product.')->group(function () {
//    Product Reviews
    Route::get('/review/product', 'index')->name('review.index');
    Route::get('/review/product/status/{id}', 'status')->name('review.status');
    Route::delete('/review/product/delete/{id}', 'destroy')->name('review.destroy');
});

//! Route for Product Reviews and Report
Route::controller(BackendReviewReportController::class)->name('product.')->group(function () {
//    Product Review Reports
    Route::get('/review/product/report', 'index')->name('review.report.index');
    Route::get('/review/product/report/status/{id}', 'status')->name('review.report.status');
    Route::delete('/review/product/report/delete/{id}', 'destroy')->name('review.report.destroy');
});


//Vacation
Route::get('/vacation', [VacationController::class, 'index'])->name('vacations');

Route::post('/vacation/store', [VacationController::class, 'store'])->name('vacation.store');

