<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TaxeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\SeoSettingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReturnProdctController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\UserActivitieController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\ShippingMethodController;
use App\Http\Controllers\AffiliateProgramController;
use App\Http\Controllers\ExternalIntegrationController;

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
    return view('welcome');
});

Route::middleware(['auth'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name(
        'profile.edit'
    );
    Route::patch('/profile', [ProfileController::class, 'update'])->name(
        'profile.update'
    );
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name(
        'profile.destroy'
    );
});

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('users', UserController::class);
        Route::resource(
            'affiliate-programs',
            AffiliateProgramController::class
        );
        Route::resource('customers', CustomerController::class);
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategorieController::class);
        Route::resource('carts', CartController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('payment-methods', PaymentMethodController::class);
        Route::resource('seo-settings', SeoSettingController::class);
        Route::resource('shipments', ShipmentController::class);
        Route::resource('shipping-methods', ShippingMethodController::class);
        Route::resource('user-activities', UserActivitieController::class);
        Route::resource('discounts', DiscountController::class);
        Route::resource('settings', SettingController::class);
        Route::resource('taxes', TaxeController::class);
        Route::resource('pages', PageController::class);
        Route::resource('banners', BannerController::class);
        Route::resource('email-templates', EmailTemplateController::class);
        Route::resource(
            'external-integrations',
            ExternalIntegrationController::class
        );
        Route::resource('return-prodcts', ReturnProdctController::class);
    });
