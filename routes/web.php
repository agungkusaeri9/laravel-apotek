<?php

use App\Services\WhatsappService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeCategoryController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductInController;
use App\Http\Controllers\ProductOutController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UnitController;

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

// Route::get('/', [HomeController::class, 'index']);
// Route::get('/', [HomeController::class, 'search'])->name('search');

// Route::get('/product/{id}', [HomeController::class, 'show'])->name('produk.show');
// Route::post('/product/{id}', [OrderController::class, 'order'])->name('produk.order');


Auth::routes();

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

Route::prefix('dashboard')->group(function () {
    //* Section Payment
    Route::get('/payment', [OrderDetailController::class, 'checkUserPayment'])->middleware('adminKaryawan')->name('payment.check');
    Route::put('/payment/{orderdetails:id}', [OrderDetailController::class, 'changeStatusPayment'])->middleware('adminKaryawan')->name('payment.change');
    Route::get('/payment/order/{orderdetails:id}', [PaymentController::class, 'show'])->middleware('adminKaryawan')->name('payment.showUser');
    Route::get('/payment/history', [OrderDetailController::class, 'userHistory'])->name('payment.history');
    Route::get('/payment/history/{orderdetails:id}', [OrderDetailController::class, 'createUploadPembayaran'])->name('payment.createpayment');
    Route::post('/payment/history/', [OrderDetailController::class, 'uploadPembayaran'])->middleware('adminKaryawan')->name('payment.uploadpayment');

    //* Section Product
    Route::get('/product/getById', [ProductController::class, 'getById'])->name('product.getById');
    Route::resource('product', ProductController::class)->middleware('adminKaryawan');

    //*Section Users
    Route::resource('users', UserController::class)->middleware('IsAdmin');

    // *Section Category
    Route::get('/category', [CategoryController::class, 'index'])->middleware('IsAdmin')->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->middleware('IsAdmin')->name('category.create');
    Route::post('/category/create', [CategoryController::class, 'store'])->middleware('IsAdmin')->name('category.store');
    Route::delete('/category/{category:id}', [CategoryController::class, 'delete'])->middleware('IsAdmin')->name('category.destroy');

    Route::resource('unit', UnitController::class);


    // product in
    Route::resource('product-in', ProductInController::class);
    Route::resource('product-out', ProductOutController::class);

    // report
    Route::get('report/product', [ReportController::class, 'product_index'])->name('report.product.index');
    Route::post('report/product', [ReportController::class, 'product_print'])->name('report.product.print');

    Route::get('report/product-in', [ReportController::class, 'product_in_index'])->name('report.product-in.index');
    Route::post('report/product-in', [ReportController::class, 'product_in_print'])->name('report.product-in.print');

    Route::get('report/product-out', [ReportController::class, 'product_out_index'])->name('report.product-out.index');
    Route::post('report/product-out', [ReportController::class, 'product_out_print'])->name('report.product-out.print');

    Route::get('report/transaksi', [ReportController::class, 'transaksi_index'])->name('report.transaksi.index');
    Route::post('report/transaksi', [ReportController::class, 'transaksi_print'])->name('report.transaksi.print');

    Route::resource('transaksi', TransaksiController::class);
});


//* Wishlist
Route::get('/cart', [WishlistController::class, 'index'])->name('cart.index');
Route::get('/cart/total', [WishlistController::class, 'addToOrder'])->name('cart.addToOrder');
Route::post('/product', [WishlistController::class, 'addToWishlist'])->name('cart.addToWishlist');
Route::put('/cart/{wishlist:id}', [WishlistController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::delete('/cart/{wishlist:id}', [WishlistController::class, 'destroy'])->name('cart.delete');

// * Category
Route::get('/categories', [HomeCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [HomeCategoryController::class, 'show'])->name('categories.show');
