<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\RestaurantQueryController;
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

Route::get('/', 'FrontController@index')->name('home');
Route::get('/langue/{locale}', 'FrontController@changeLanguage')->name('change_language');
Route::get('terms-and-conditions', 'HomeController@terms_and_conditions')->name('terms-and-conditions');
Route::get('about-us', 'HomeController@about_us')->name('about-us');
Route::get('contact-us', 'HomeController@contact_us')->name('contact-us');
Route::get('privacy-policy', 'HomeController@privacy_policy')->name('privacy-policy');

Route::post('/search', 'FrontController@search')->name('search');

Route::get('/restaurants', [FrontController::class, 'restaurant_listing'])->name('restaurant_listing');
Route::get('/restaurant-catalogue/{restaurant}', [FrontController::class, 'restaurant_details'])->name('restaurant_details'); 
Route::post('/search', [RestaurantQueryController::class, '__invoke'])->name('restaurants.query');
Route::get('/area/{postcode}', function ($postcode) {
    return view('front.restaurant_listing', ['postcode' => $postcode]);
})->name('restaurants.filter');

Route::get('quick-view', [FrontController::class, 'quick_view'])->name('quick-view');
Route::get('quick-view-cart-item', [FrontController::class, 'quick_view_card_item'])->name('quick-view-cart-item');
Route::post('variant_price', [FrontController::class, 'variant_price'])->name('variant_price');
///cart///
Route::get('/cart2',[FrontController::class,'cart2'])->name('cart2');
Route::get('/emptycart',[FrontController::class,'emptycart'])->name('emptycart');

Route::get('/aboutus',[FrontController::class,'aboutus'])->name('aboutus');
Route::get('/contact',[FrontController::class,'contact'])->name('contact');

//Restaurant Registration
Route::group(['prefix' => 'restaurant', 'as' => 'restaurant.'], function () {
    Route::get('apply', 'VendorController@create')->name('create');
    Route::post('apply', 'VendorController@store')->name('store');
});

//Deliveryman Registration
Route::group(['prefix' => 'deliveryman', 'as' => 'deliveryman.'], function () {
    Route::get('apply', 'DeliveryManController@create')->name('create');
    Route::post('apply', 'DeliveryManController@store')->name('store');
});



Route::get('authentication-failed', function () {
    $errors = [];
    array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthenticated.']);
    return response()->json([
        'errors' => $errors,
    ], 401);
})->name('authentication-failed');

Route::group(['prefix' => 'payment-mobile'], function () {
    Route::get('/', 'PaymentController@payment')->name('payment-mobile');
    Route::get('set-payment-method/{name}', 'PaymentController@set_payment_method')->name('set-payment-method');
});

// SSLCOMMERZ Start
/*Route::get('/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
Route::get('/example2', 'SslCommerzPaymentController@exampleHostedCheckout');*/
Route::post('pay-ssl', 'SslCommerzPaymentController@index');
Route::post('/success', 'SslCommerzPaymentController@success');
Route::post('/fail', 'SslCommerzPaymentController@fail');
Route::post('/cancel', 'SslCommerzPaymentController@cancel');
Route::post('/ipn', 'SslCommerzPaymentController@ipn');
//SSLCOMMERZ END

/*paypal*/
/*Route::get('/paypal', function (){return view('paypal-test');})->name('paypal');*/
Route::post('pay-paypal', 'PaypalPaymentController@payWithpaypal')->name('pay-paypal');
Route::get('paypal-status', 'PaypalPaymentController@getPaymentStatus')->name('paypal-status');
/*paypal*/

/*Route::get('stripe', function (){
return view('stripe-test');
});*/

Route::get('pay-stripe', 'StripePaymentController@payment_process_3d')->name('pay-stripe');
Route::get('pay-stripe/success', 'StripePaymentController@success')->name('pay-stripe.success');
Route::get('pay-stripe/fail', 'StripePaymentController@fail')->name('pay-stripe.fail');

// Get Route For Show Payment Form
Route::get('paywithrazorpay', 'RazorPayController@payWithRazorpay')->name('paywithrazorpay');
Route::post('payment-razor', 'RazorPayController@payment')->name('payment-razor');

/*Route::fallback(function () {
return redirect('/admin/auth/login');
});*/

Route::get('payment-success', 'PaymentController@success')->name('payment-success');
Route::get('payment-fail', 'PaymentController@fail')->name('payment-fail');

//senang pay
Route::match(['get', 'post'], '/return-senang-pay', 'SenangPayController@return_senang_pay')->name('return-senang-pay');

// paymob
Route::post('/paymob-credit', 'PaymobController@credit')->name('paymob-credit');
Route::get('/paymob-callback', 'PaymobController@callback')->name('paymob-callback');

//paystack
Route::post('/paystack-pay', 'PaystackController@redirectToGateway')->name('paystack-pay');
Route::get('/paystack-callback', 'PaystackController@handleGatewayCallback')->name('paystack-callback');
Route::get('/paystack',function (){
    return view('paystack');
});


// The route that the button calls to initialize payment
Route::post('/flutterwave-pay','FlutterwaveController@initialize')->name('flutterwave_pay');
// The callback url after a payment
Route::get('/rave/callback', 'FlutterwaveController@callback')->name('flutterwave_callback');


// The callback url after a payment
Route::get('mercadopago/home', 'MercadoPagoController@index')->name('mercadopago.index');
Route::post('mercadopago/make-payment', 'MercadoPagoController@make_payment')->name('mercadopago.make_payment');
Route::get('mercadopago/get-user', 'MercadoPagoController@get_test_user')->name('mercadopago.get-user');

//paytabs
Route::any('/paytabs-payment', 'PaytabsController@payment')->name('paytabs-payment');
Route::any('/paytabs-response', 'PaytabsController@callback_response')->name('paytabs-response');

//bkash
Route::group(['prefix'=>'bkash'], function () {
    // Payment Routes for bKash
    Route::post('get-token', 'BkashPaymentController@getToken')->name('bkash-get-token');
    Route::post('create-payment', 'BkashPaymentController@createPayment')->name('bkash-create-payment');
    Route::post('execute-payment', 'BkashPaymentController@executePayment')->name('bkash-execute-payment');
    Route::get('query-payment', 'BkashPaymentController@queryPayment')->name('bkash-query-payment');
    Route::post('success', 'BkashPaymentController@bkashSuccess')->name('bkash-success');

    // Refund Routes for bKash
    // Route::get('refund', 'BkashRefundController@index')->name('bkash-refund');
    // Route::post('refund', 'BkashRefundController@refund')->name('bkash-refund');
});

// The callback url after a payment PAYTM
Route::get('paytm-payment', 'PaytmController@payment')->name('paytm-payment');
Route::any('paytm-response', 'PaytmController@callback')->name('paytm-response');

// The callback url after a payment LIQPAY
Route::get('liqpay-payment', 'LiqPayController@payment')->name('liqpay-payment');
Route::any('liqpay-callback', 'LiqPayController@callback')->name('liqpay-callback');


Route::get('authentication-failed', function () {
    $errors = [];
    array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthorized.']);
    return response()->json([
        'errors' => $errors
    ], 401);
})->name('authentication-failed');
    

Route::middleware('auth')->group(function (){
    
    Route::get('/myaccount', [FrontController::class, 'myaccount'])->name('myaccount'); 
    Route::get('/account', [FrontController::class, 'account'])->name('account');
    Route::patch('/update/{id}', [FrontController::class, 'profile_update'])->name('profile_update');
    Route::get('/address', [FrontController::class, 'address'])->name('address');
    Route::post('/address_store', [FrontController::class, 'address_store'])->name('address_store');
    Route::get('/edit_address/{id}', [FrontController::class, 'edit_address'])->name('edit_address');
    Route::get('/address/{id}', [FrontController::class, 'address_destroy'])->name('address_destroy');
    Route::patch('/update_address/{id}', [FrontController::class, 'update_address'])->name('update_address');
    Route::get('/default/{id}', [FrontController::class, 'default'])->name('default');
    Route::get('/removedefault/{id}', [FrontController::class, 'removedefault'])->name('removedefault');

    Route::get('/show_password', [FrontController::class, 'show_password'])->name('show_password');
    Route::post('/changePassword',[FrontController::class, 'change_password'])->name('change_password');
    //////////Cart///////////////
    Route::get('/cart',[FrontController::class,'cart'])->name('cart');
    Route::get('/add-to-cart/{id}', [FrontController::class, 'addToCart'])->name('addToCart');
    Route::get('/remove-from-cart/{id}', [FrontController::class, 'removeFromCart'])->name('removeFromCart');
    Route::delete('cartDelete/{id}', [FrontController::class, 'cartDelete'])->name('cartDelete');
    
    Route::get('/checkout',[FrontController::class,'checkout'])->name('checkout');
    Route::get('/order',[FrontController::class,'order'])->name('order');
    Route::get('/order_tracking/{order}',[FrontController::class,'order_tracking'])->name('order_tracking');

    Route::get('/addressStore/{id}', [FrontController::class, 'addressStore'])->name('addressStore');

    Route::post('/order/store', [FrontController::class, 'orderStore'])->name('orderStore');
    Route::get('/orderhistory',[FrontController::class, 'order_history'])->name('order_history');
    Route::get('download-pdf/{order}', [FrontController::class, 'downloadPDF'])->name('downloadPDF'); 

});

require __DIR__.'/auth.php';