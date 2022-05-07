<?php

use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\Auth\ChangePasswordController;

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

Route::get('/lang/{locale}', [LanguageController::class, 'switchLanguage'])->name('lang');
Auth::routes();

Route::redirect('/', '/home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/search-product', [HomeController::class, 'search'])->name('search.product');
Route::get('/search-list-products/{key}', [HomeController::class, 'searchList'])->name('search.list.products');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('show');
Route::get(
    '/category/{category}/{childCategory:slug?}/{childCategory2?}',
    [HomeController::class, 'searchByCategory']
)->name('categories');

Route::group(['middleware' => ['auth', 'user']], function () {
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('addToCart');
    Route::put('/update-cart', [CartController::class, 'updateCart'])->name('updateCart');
    Route::delete('/delete-cart', [CartController::class, 'deleteCart'])->name('deleteCart');
    Route::get('/count-product', [CartController::class, 'countProduct'])->name('countProduct');
    Route::post('/add-more-product/{id}', [CartController::class, 'addMoreProduct'])->name('addMoreProduct');
    Route::post('/add-quantity/{id}', [CartController::class, 'addMoreProduct'])->name('addQuantity');
    Route::post('/carts/apply-voucher', [CartController::class, 'applyVoucher'])->name('carts.apply.voucher');
    Route::delete('/carts/delete-voucher', [CartController::class, 'deleteVoucher'])->name('carts.delete.voucher');
    Route::resource('/carts', CartController::class);
    Route::get('/checkout', [OrderController::class, 'infoCheckout'])->name('checkout');
    Route::resource('orders', OrderController::class)->only(['store']);
    Route::get('/voucher-wallet', [VoucherController::class, 'walletVoucher'])->name('user.voucher.wallet');
    Route::get('/use-voucher/{code}', [VoucherController::class, 'useVoucher'])->name('user.use.voucher');
    Route::get('/show-voucher', [VoucherController::class, 'showVoucher'])->name('user.show.voucher');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::resource('/categories', CategoryController::class);
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.update');

    Route::get('verify-email', [AdminController::class, 'verifyEmail'])->name('admin.verify.email');
    Route::post('verify-email', [AdminController::class, 'sendVerifyEmail'])->name('admin.send.verify.email');
    Route::get('active-email/{id}/{token}', [AdminController::class, 'activeEmail'])->name('admin.active.email');

    Route::resource('/brands', BrandController::class);
    Route::delete('/deleteimage/{id}', [ProductController::class, 'deleteimage'])->name('deleteimage');
    Route::resource('/products', ProductController::class);
    Route::get('/all-cancel-order', [OrderController::class, 'allCancelOrder'])->name('allCancelOrder');
    Route::get('/view-cancel-order/{id}', [OrderController::class, 'viewCancelOrder'])->name('viewCancelOrder');
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'edit', 'update']);
    Route::get('/statistic-by-order', [StatisticController::class, 'statisticByOrder'])->name('statistic.order');
    Route::get('/statistic-by-revenue', [StatisticController::class, 'statisticByRevenue'])->name('statistic.revenue');
    Route::post('/select-month-order', [StatisticController::class, 'selectMonthOrder'])
        ->name('statistic.selectMonthOrder');
    Route::post('/select-year-revenue', [StatisticController::class, 'selectYearRevenue'])
        ->name('statistic.selectYearRevenue');
});

Route::group(['prefix' => 'admin/vouchers', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [VoucherController::class, 'index'])->name('vouchers.index');
    Route::post('/', [VoucherController::class, 'store'])->name('vouchers.store');
    Route::get('/list', [VoucherController::class, 'fetch'])->name('voucher.fetch');
    Route::post('/edit', [VoucherController::class, 'edit'])->name('vouchers.edit');
    Route::patch('/update', [VoucherController::class, 'update'])->name('vouchers.update');
    Route::delete('/delete', [VoucherController::class, 'delete'])->name('vouchers.delete');
    Route::delete('/delete-list', [VoucherController::class, 'deleteList'])->name('vouchers.delete.list');
});

Route::group(['prefix' => 'profile', 'middleware' => ['auth', 'user']], function () {
    Route::put('/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::get('/password/{id}/edit', [ChangePasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password/{id}', [ChangePasswordController::class, 'change'])->name('password.change');
    Route::get('/orders/{id}', [UserController::class, 'viewOrders'])->name('viewOrders');
    Route::get('/view-order/{id}', [UserController::class, 'viewDetailOrder'])->name('viewDetailOrder');
    Route::get('/view-status-order/{idUser}/{idStatus}', [UserController::class, 'viewStatusOrder'])
        ->name('viewStatusOrder');
});
