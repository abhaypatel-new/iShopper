<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomProductController;
use App\Http\Controllers\SellerOfferController;
use App\Http\Controllers\Customer\Auth\LoginController;
use App\Http\Controllers\api\Customerproduct;
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

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1', 'middleware' => ['api_lang']], function () {
     Route::post('customer/store','CustomerController@customer_store')->name('customer.store');
        Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
        Route::post('registers', 'PassportAuthController@register');
        Route::post('login', 'PassportAuthController@login');
        Route::post('check-phone', 'PhoneVerificationController@check_phone');
        Route::post('verify-phone', 'PhoneVerificationController@verify_phone');
       
        Route::post('check-email', 'EmailVerificationController@check_email');
        Route::post('verify-email', 'EmailVerificationController@verify_email');
        Route::post('custom/product', [CustomProductController::class, 'store']);
        Route::post('forgot-password', 'ForgotPassword@reset_password_request');
        Route::post('verify-otp', 'ForgotPassword@otp_verification_submit');
        Route::put('reset-password', 'ForgotPassword@reset_password_submit');

        Route::any('social-login', 'SocialAuthController@social_login');
        Route::post('update-phone', 'SocialAuthController@update_phone');
       
        // Custom Product 
       
       
        // Route::put('seller/offer/{id}', [SellerOfferController::class, 'store']);
        // Route::post('clogin', [LoginController::class, 'submit']);
       
    });

    Route::group(['prefix' => 'config'], function () {
        Route::get('/', 'ConfigController@configuration');
    });

    Route::group(['prefix' => 'shipping-method','middleware'=>'auth:api'], function () {
        Route::get('detail/{id}', 'ShippingMethodController@get_shipping_method_info');
        Route::get('by-seller/{id}/{seller_is}', 'ShippingMethodController@shipping_methods_by_seller');
        Route::post('choose-for-order', 'ShippingMethodController@choose_for_order');
        Route::get('chosen', 'ShippingMethodController@chosen_shipping_methods');

        Route::get('check-shipping-type','ShippingMethodController@check_shipping_type');
    });

    Route::group(['prefix' => 'cart','middleware'=>'auth:api'], function () {
        Route::get('/', 'CartController@cart');
        Route::post('add', 'CartController@add_to_cart');
        Route::put('update', 'CartController@update_cart');
        Route::delete('remove', 'CartController@remove_from_cart');
        Route::delete('remove-all','CartController@remove_all_from_cart');
        
        //customproduct//
        
        Route::get('/customlist', 'CartController@cartlist');
        Route::post('add/custom', 'CartController@add_to_cartcustomlist');
        Route::post('update/custom', 'CartController@update_cartcustom');
        Route::post('remove/custom', 'CartController@remove_from_cartcustom');
        Route::post('remove-all/custom','CartController@remove_all_from_cart_custom');

    });

    Route::get('faq', 'GeneralController@faq');

    Route::group(['prefix' => 'products'], function () {
        Route::get('latest', 'ProductController@get_latest_products');
        Route::get('featured', 'ProductController@get_featured_products');
        Route::get('top-rated', 'ProductController@get_top_rated_products');
        Route::any('search', 'ProductController@get_searched_products');
        Route::any('searchbyuser', 'ProductController@get_searched_by_products');
        Route::get('details/{slug}', 'ProductController@get_product');
        Route::get('related-products/{product_id}', 'ProductController@get_related_products');
        Route::get('reviews/{product_id}', 'ProductController@get_product_reviews');
        Route::get('rating/{product_id}', 'ProductController@get_product_rating');
        Route::get('counter/{product_id}', 'ProductController@counter');
        Route::get('shipping-methods', 'ProductController@get_shipping_methods');
        Route::get('social-share-link/{product_id}', 'ProductController@social_share_link');
        Route::post('reviews/submit', 'ProductController@submit_product_review')->middleware('auth:api');
        Route::get('best-sellings', 'ProductController@get_best_sellings');
        Route::get('home-categories', 'ProductController@get_home_categories');
        ROute::get('discounted-product', 'ProductController@get_discounted_product');
    });

    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', 'NotificationController@get_notifications');
    });

    Route::group(['prefix' => 'brands'], function () {
        Route::get('/', 'BrandController@get_brands');
        Route::get('products/{brand_id}', 'BrandController@get_products');
    });

    Route::group(['prefix' => 'attributes'], function () {
        Route::get('/', 'AttributeController@get_attributes');
    });

    Route::group(['prefix' => 'flash-deals'], function () {
        Route::get('/', 'FlashDealController@get_flash_deal');
        Route::get('products/{deal_id}', 'FlashDealController@get_products');
    });

    Route::group(['prefix' => 'deals'], function () {
        Route::get('featured', 'DealController@get_featured_deal');
    });

    Route::group(['prefix' => 'dealsoftheday'], function () {
        Route::get('deal-of-the-day', 'DealOfTheDayController@get_deal_of_the_day_product');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoryController@get_categories');
        Route::get('products/{category_id}', 'CategoryController@get_products');
    });

    Route::group(['prefix' => 'customer', 'middleware' => 'auth:api'], function () {
        
        Route::get('info', 'CustomerController@info');
        Route::put('update-profile', 'CustomerController@update_profile');
        Route::put('cm-firebase-token', 'CustomerController@update_cm_firebase_token');

        Route::group(['prefix' => 'address'], function () {
            Route::get('list', 'CustomerController@address_list');
            Route::post('add', 'CustomerController@add_new_address');
            Route::delete('/', 'CustomerController@delete_address');
        });

        Route::group(['prefix' => 'support-ticket'], function () {
            Route::post('create', 'CustomerController@create_support_ticket');
            Route::get('get', 'CustomerController@get_support_tickets');
            Route::get('conv/{ticket_id}', 'CustomerController@get_support_ticket_conv');
            Route::post('reply/{ticket_id}', 'CustomerController@reply_support_ticket');
        });

        Route::group(['prefix' => 'wish-list'], function () {
            Route::get('/', 'CustomerController@wish_list');
            Route::post('add', 'CustomerController@add_to_wishlist');
            Route::delete('remove', 'CustomerController@remove_from_wishlist');
        });

        Route::group(['prefix' => 'order'], function () {
            Route::get('list', 'CustomerController@get_order_list');
            Route::get('details', 'CustomerController@get_order_details');
            Route::get('place', 'OrderController@place_order');
            Route::get('refund', 'OrderController@refund_request');
            Route::post('refund-store', 'OrderController@store_refund');
            Route::get('refund-details', 'OrderController@refund_details');
        });
        // Chatting
        Route::group(['prefix' => 'chat'], function () {
            Route::get('/', 'ChatController@chat_with_seller');
            Route::get('messages', 'ChatController@messages');
            Route::post('send-message', 'ChatController@messages_store');
            Route::post('upload-images', 'ChatController@upload_images');
            Route::post('video', 'ChatController@chat_video');
        });
          Route::get('custom_product/list', [Customerproduct::class, 'custom_list_userwise']);
          Route::post('customerstore', [Customerproduct::class, 'customerstores']);
          Route::post('upload/video', [Customerproduct::class, 'uploade_video']);
          Route::get('offer_product/list/{id}', [Customerproduct::class, 'offer_list']);
           Route::get('unit_list/{id}', [Customerproduct::class, 'unit_list']);
            Route::get('sub_category_list/{id}', [Customerproduct::class, 'sub_category_list']);
          Route::get('offer_count/list/{id}', [Customerproduct::class, 'offer_count']);
          Route::get('color', [Customerproduct::class, 'color']);
          Route::get('category', [Customerproduct::class, 'category']);
          Route::get('sub_category', [Customerproduct::class, 'sub_category']);
    });

        Route::group(['prefix' => 'order'], function () {
        Route::get('track', 'OrderController@track_order');
        Route::get('cancel-order','OrderController@order_cancel');
    });

        Route::group(['prefix' => 'banners'], function () {
        Route::get('/', 'BannerController@get_banners');
    });

    Route::group(['prefix' => 'seller'], function () {
        Route::get('/', 'SellerController@get_seller_info');
        Route::get('{seller_id}/products', 'SellerController@get_seller_products');
        Route::get('top', 'SellerController@get_top_sellers');
        Route::get('all', 'SellerController@get_all_sellers');
    });
     Route::group(['prefix' => 'chat'], function () {
            // Route::get('/', 'ChatController@chat_with_seller');
            // Route::get('messages', 'ChatController@messages');
            Route::post('send-message', 'ChatController@messages_store');
        });
    Route::group(['prefix' => 'coupon','middleware' => 'auth:api'], function () {
        Route::get('apply', 'CouponController@apply');
    });

    //map api
    Route::group(['prefix' => 'mapapi'], function () {
        Route::get('place-api-autocomplete', 'MapApiController@place_api_autocomplete');
        Route::get('distance-api', 'MapApiController@distance_api');
        Route::get('place-api-details', 'MapApiController@place_api_details');
        Route::get('geocode-api', 'MapApiController@geocode_api');
    });
   
 Route::get('custom_product_list', [Customerproduct::class, 'custom_product_list']);
 Route::get('offer_list', [Customerproduct::class, 'offer_list']);
 Route::any('searchbyseller', [Customerproduct::class, 'get_searched_products_by_seller']);
 Route::get('unit_list/{id}', [Customerproduct::class, 'unit_list']);
 Route::post('view_custom/{id}', [Customerproduct::class, 'view_custom']);
 Route::post('edit_custom/{id}', [Customerproduct::class, 'edit_custom']);
 Route::post('update/custom_product/{id}', [Customerproduct::class, 'update_custom_product']);
 Route::post('delete_product/{id}', [Customerproduct::class, 'delete_product']);
 Route::post('login', [Customerproduct::class, 'login']);
 Route::get('sellerlist', [Customerproduct::class, 'sellerlist']);
 Route::post('seller_update', [Customerproduct::class, 'seller_update']);
 Route::post('seller_delete', [Customerproduct::class, 'seller_delete']);
 Route::post('seller_view/{id}', [Customerproduct::class, 'seller_view']);
 Route::get('get-order-list/{status}', [Customerproduct::class, 'getOrderList']);
 Route::get('get-order-details/{id}', [Customerproduct::class, 'getOrderDetails']);
 
 Route::get('getSizeAndMaterials', [Customerproduct::class,'getSizeAndMaterials']);
});
  
 
  
