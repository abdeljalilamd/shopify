<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\TaxeController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\RefundController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\SeoMetaController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\ShipmentController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\ProductTagController;
use App\Http\Controllers\Api\SeoSettingController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\ReturnProdctController;
use App\Http\Controllers\Api\UserCustomersController;
use App\Http\Controllers\Api\CustomerCartsController;
use App\Http\Controllers\Api\ProductReviewController;
use App\Http\Controllers\Api\CartCartItemsController;
use App\Http\Controllers\Api\OrderPaymentsController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\UserActivitieController;
use App\Http\Controllers\Api\EmailTemplateController;
use App\Http\Controllers\Api\CustomerOrdersController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\Api\OrderShipmentsController;
use App\Http\Controllers\Api\ShippingMethodController;
use App\Http\Controllers\Api\OrderOrderItemsController;
use App\Http\Controllers\Api\SocialMediaLinkController;
use App\Http\Controllers\Api\AffiliateProgramController;
use App\Http\Controllers\Api\ProductCartItemsController;
use App\Http\Controllers\Api\ProductAttributeController;
use App\Http\Controllers\Api\CustomerWishlistController;
use App\Http\Controllers\Api\UserNotificationsController;
use App\Http\Controllers\Api\ProductOrderItemsController;
use App\Http\Controllers\Api\CategorieProductsController;
use App\Http\Controllers\Api\UserUserActivitiesController;
use App\Http\Controllers\Api\ProductProductTagsController;
use App\Http\Controllers\Api\ProductInventoriesController;
use App\Http\Controllers\Api\OrderReturnProdctsController;
use App\Http\Controllers\Api\SeoSettingSeoMetasController;
use App\Http\Controllers\Api\AffiliateCommissionController;
use App\Http\Controllers\Api\ExternalIntegrationController;
use App\Http\Controllers\Api\ReturnProdctRefundsController;
use App\Http\Controllers\Api\ProductProductImagesController;
use App\Http\Controllers\Api\ProductProductReviewsController;
use App\Http\Controllers\Api\PaymentMethodPaymentsController;
use App\Http\Controllers\Api\CustomerProductReviewsController;
use App\Http\Controllers\Api\ProductProductVariantsController;
use App\Http\Controllers\Api\ShippingMethodShipmentsController;
use App\Http\Controllers\Api\SettingSocialMediaLinksController;
use App\Http\Controllers\Api\ProductCustomerWishlistsController;
use App\Http\Controllers\Api\ProductProductAttributesController;
use App\Http\Controllers\Api\CustomerCustomerWishlistsController;
use App\Http\Controllers\Api\CustomerAffiliateProgramsController;
use App\Http\Controllers\Api\AffiliateProgramAffiliateCommissionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('users', UserController::class);

        // User Notifications
        Route::get('/users/{user}/notifications', [
            UserNotificationsController::class,
            'index',
        ])->name('users.notifications.index');
        Route::post('/users/{user}/notifications', [
            UserNotificationsController::class,
            'store',
        ])->name('users.notifications.store');

        // User User Activities
        Route::get('/users/{user}/user-activities', [
            UserUserActivitiesController::class,
            'index',
        ])->name('users.user-activities.index');
        Route::post('/users/{user}/user-activities', [
            UserUserActivitiesController::class,
            'store',
        ])->name('users.user-activities.store');

        // User Customers
        Route::get('/users/{user}/customers', [
            UserCustomersController::class,
            'index',
        ])->name('users.customers.index');
        Route::post('/users/{user}/customers', [
            UserCustomersController::class,
            'store',
        ])->name('users.customers.store');

        Route::apiResource(
            'affiliate-programs',
            AffiliateProgramController::class
        );

        // AffiliateProgram Affiliate Commissions
        Route::get(
            '/affiliate-programs/{affiliateProgram}/affiliate-commissions',
            [AffiliateProgramAffiliateCommissionsController::class, 'index']
        )->name('affiliate-programs.affiliate-commissions.index');
        Route::post(
            '/affiliate-programs/{affiliateProgram}/affiliate-commissions',
            [AffiliateProgramAffiliateCommissionsController::class, 'store']
        )->name('affiliate-programs.affiliate-commissions.store');

        Route::apiResource('customers', CustomerController::class);

        // Customer Customer Wishlists
        Route::get('/customers/{customer}/customer-wishlists', [
            CustomerCustomerWishlistsController::class,
            'index',
        ])->name('customers.customer-wishlists.index');
        Route::post('/customers/{customer}/customer-wishlists', [
            CustomerCustomerWishlistsController::class,
            'store',
        ])->name('customers.customer-wishlists.store');

        // Customer Product Reviews
        Route::get('/customers/{customer}/product-reviews', [
            CustomerProductReviewsController::class,
            'index',
        ])->name('customers.product-reviews.index');
        Route::post('/customers/{customer}/product-reviews', [
            CustomerProductReviewsController::class,
            'store',
        ])->name('customers.product-reviews.store');

        // Customer Carts
        Route::get('/customers/{customer}/carts', [
            CustomerCartsController::class,
            'index',
        ])->name('customers.carts.index');
        Route::post('/customers/{customer}/carts', [
            CustomerCartsController::class,
            'store',
        ])->name('customers.carts.store');

        // Customer Orders
        Route::get('/customers/{customer}/orders', [
            CustomerOrdersController::class,
            'index',
        ])->name('customers.orders.index');
        Route::post('/customers/{customer}/orders', [
            CustomerOrdersController::class,
            'store',
        ])->name('customers.orders.store');

        // Customer Affiliate Programs
        Route::get('/customers/{customer}/affiliate-programs', [
            CustomerAffiliateProgramsController::class,
            'index',
        ])->name('customers.affiliate-programs.index');
        Route::post('/customers/{customer}/affiliate-programs', [
            CustomerAffiliateProgramsController::class,
            'store',
        ])->name('customers.affiliate-programs.store');

        // Customer Referral Programs
        Route::get('/customers/{customer}/affiliate-programs', [
            CustomerAffiliateProgramsController::class,
            'index',
        ])->name('customers.affiliate-programs.index');
        Route::post('/customers/{customer}/affiliate-programs', [
            CustomerAffiliateProgramsController::class,
            'store',
        ])->name('customers.affiliate-programs.store');

        Route::apiResource('products', ProductController::class);

        // Product Customer Wishlists
        Route::get('/products/{product}/customer-wishlists', [
            ProductCustomerWishlistsController::class,
            'index',
        ])->name('products.customer-wishlists.index');
        Route::post('/products/{product}/customer-wishlists', [
            ProductCustomerWishlistsController::class,
            'store',
        ])->name('products.customer-wishlists.store');

        // Product Product Variants
        Route::get('/products/{product}/product-variants', [
            ProductProductVariantsController::class,
            'index',
        ])->name('products.product-variants.index');
        Route::post('/products/{product}/product-variants', [
            ProductProductVariantsController::class,
            'store',
        ])->name('products.product-variants.store');

        // Product Product Images
        Route::get('/products/{product}/product-images', [
            ProductProductImagesController::class,
            'index',
        ])->name('products.product-images.index');
        Route::post('/products/{product}/product-images', [
            ProductProductImagesController::class,
            'store',
        ])->name('products.product-images.store');

        // Product Product Reviews
        Route::get('/products/{product}/product-reviews', [
            ProductProductReviewsController::class,
            'index',
        ])->name('products.product-reviews.index');
        Route::post('/products/{product}/product-reviews', [
            ProductProductReviewsController::class,
            'store',
        ])->name('products.product-reviews.store');

        // Product Product Tags
        Route::get('/products/{product}/product-tags', [
            ProductProductTagsController::class,
            'index',
        ])->name('products.product-tags.index');
        Route::post('/products/{product}/product-tags', [
            ProductProductTagsController::class,
            'store',
        ])->name('products.product-tags.store');

        // Product Cart Items
        Route::get('/products/{product}/cart-items', [
            ProductCartItemsController::class,
            'index',
        ])->name('products.cart-items.index');
        Route::post('/products/{product}/cart-items', [
            ProductCartItemsController::class,
            'store',
        ])->name('products.cart-items.store');

        // Product Order Items
        Route::get('/products/{product}/order-items', [
            ProductOrderItemsController::class,
            'index',
        ])->name('products.order-items.index');
        Route::post('/products/{product}/order-items', [
            ProductOrderItemsController::class,
            'store',
        ])->name('products.order-items.store');

        // Product Inventories
        Route::get('/products/{product}/inventories', [
            ProductInventoriesController::class,
            'index',
        ])->name('products.inventories.index');
        Route::post('/products/{product}/inventories', [
            ProductInventoriesController::class,
            'store',
        ])->name('products.inventories.store');

        // Product Product Attributes
        Route::get('/products/{product}/product-attributes', [
            ProductProductAttributesController::class,
            'index',
        ])->name('products.product-attributes.index');
        Route::post('/products/{product}/product-attributes', [
            ProductProductAttributesController::class,
            'store',
        ])->name('products.product-attributes.store');

        Route::apiResource('categories', CategorieController::class);

        // Categorie Products
        Route::get('/categories/{categorie}/products', [
            CategorieProductsController::class,
            'index',
        ])->name('categories.products.index');
        Route::post('/categories/{categorie}/products', [
            CategorieProductsController::class,
            'store',
        ])->name('categories.products.store');

        Route::apiResource('carts', CartController::class);

        // Cart Cart Items
        Route::get('/carts/{cart}/cart-items', [
            CartCartItemsController::class,
            'index',
        ])->name('carts.cart-items.index');
        Route::post('/carts/{cart}/cart-items', [
            CartCartItemsController::class,
            'store',
        ])->name('carts.cart-items.store');

        Route::apiResource('orders', OrderController::class);

        // Order Order Items
        Route::get('/orders/{order}/order-items', [
            OrderOrderItemsController::class,
            'index',
        ])->name('orders.order-items.index');
        Route::post('/orders/{order}/order-items', [
            OrderOrderItemsController::class,
            'store',
        ])->name('orders.order-items.store');

        // Order Payments
        Route::get('/orders/{order}/payments', [
            OrderPaymentsController::class,
            'index',
        ])->name('orders.payments.index');
        Route::post('/orders/{order}/payments', [
            OrderPaymentsController::class,
            'store',
        ])->name('orders.payments.store');

        // Order Shipments
        Route::get('/orders/{order}/shipments', [
            OrderShipmentsController::class,
            'index',
        ])->name('orders.shipments.index');
        Route::post('/orders/{order}/shipments', [
            OrderShipmentsController::class,
            'store',
        ])->name('orders.shipments.store');

        // Order Return Prodcts
        Route::get('/orders/{order}/return-prodcts', [
            OrderReturnProdctsController::class,
            'index',
        ])->name('orders.return-prodcts.index');
        Route::post('/orders/{order}/return-prodcts', [
            OrderReturnProdctsController::class,
            'store',
        ])->name('orders.return-prodcts.store');

        Route::apiResource('payments', PaymentController::class);

        Route::apiResource('payment-methods', PaymentMethodController::class);

        // PaymentMethod Payments
        Route::get('/payment-methods/{paymentMethod}/payments', [
            PaymentMethodPaymentsController::class,
            'index',
        ])->name('payment-methods.payments.index');
        Route::post('/payment-methods/{paymentMethod}/payments', [
            PaymentMethodPaymentsController::class,
            'store',
        ])->name('payment-methods.payments.store');

        Route::apiResource('seo-settings', SeoSettingController::class);

        // SeoSetting Seo Metas
        Route::get('/seo-settings/{seoSetting}/seo-metas', [
            SeoSettingSeoMetasController::class,
            'index',
        ])->name('seo-settings.seo-metas.index');
        Route::post('/seo-settings/{seoSetting}/seo-metas', [
            SeoSettingSeoMetasController::class,
            'store',
        ])->name('seo-settings.seo-metas.store');

        Route::apiResource('shipments', ShipmentController::class);

        Route::apiResource('shipping-methods', ShippingMethodController::class);

        // ShippingMethod Shipments
        Route::get('/shipping-methods/{shippingMethod}/shipments', [
            ShippingMethodShipmentsController::class,
            'index',
        ])->name('shipping-methods.shipments.index');
        Route::post('/shipping-methods/{shippingMethod}/shipments', [
            ShippingMethodShipmentsController::class,
            'store',
        ])->name('shipping-methods.shipments.store');

        Route::apiResource('user-activities', UserActivitieController::class);

        Route::apiResource('discounts', DiscountController::class);

        Route::apiResource('settings', SettingController::class);

        // Setting Social Media Links
        Route::get('/settings/{setting}/social-media-links', [
            SettingSocialMediaLinksController::class,
            'index',
        ])->name('settings.social-media-links.index');
        Route::post('/settings/{setting}/social-media-links', [
            SettingSocialMediaLinksController::class,
            'store',
        ])->name('settings.social-media-links.store');

        Route::apiResource('taxes', TaxeController::class);

        Route::apiResource('pages', PageController::class);

        Route::apiResource('banners', BannerController::class);

        Route::apiResource('email-templates', EmailTemplateController::class);

        Route::apiResource(
            'external-integrations',
            ExternalIntegrationController::class
        );

        Route::apiResource('return-prodcts', ReturnProdctController::class);

        // ReturnProdct Refunds
        Route::get('/return-prodcts/{returnProdct}/refunds', [
            ReturnProdctRefundsController::class,
            'index',
        ])->name('return-prodcts.refunds.index');
        Route::post('/return-prodcts/{returnProdct}/refunds', [
            ReturnProdctRefundsController::class,
            'store',
        ])->name('return-prodcts.refunds.store');
    });
