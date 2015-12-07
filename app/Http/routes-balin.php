<?php 



// ------------------------------------------------------------------------------------
// FRONTEND
// ------------------------------------------------------------------------------------
// 
// Route::get('/', 														['as' => 'frontend.index', function()
// {
// 	return Redirect::route('frontend.home.index'); 
// }]);

// Route::group(['namespace' => 'Frontend\\', 'domain' => 'balin.id'], function() 
Route::group(['namespace' => 'Frontend\\', 'prefix' => ''], function() 
{
	// ------------------------------------------------------------------------------------
	// SIGNUP & SIGNIN PAGE
	// ------------------------------------------------------------------------------------
	Route::get('join', 													['uses' => 'JoinController@index', 'as' => 'frontend.join.index']);

	Route::post('do/login',												['uses' => 'AuthController@doLogin', 'as' => 'frontend.dologin']);

	Route::get('do/sso',												['uses' => 'AuthController@doSso', 'as' => 'frontend.dosso']);
	
	Route::get('sso/success',											['uses' => 'AuthController@getSso', 'as' => 'frontend.getsso']);

	Route::post('do/signup',											['uses' => 'UserController@store', 'as' => 'frontend.user.store']);
	
	// ------------------------------------------------------------------------------------
	// FORGOT PASSWORD
	// ------------------------------------------------------------------------------------

	Route::post('do/forgot',											['uses' => 'AuthController@doForgot', 'as' => 'frontend.doforgot']);
	
	Route::get('do/forgot/password/{link}',								['uses' => 'AuthController@getForgot', 'as' => 'frontend.get.forgot']);

	Route::post('do/forgot/password',									['uses' => 'AuthController@postForgot', 'as' => 'frontend.post.forgot']);

	// ------------------------------------------------------------------------------------
	// HOME
	// ------------------------------------------------------------------------------------

	Route::group(['middleware' => 'redirectsave'], function() 
	{
	Route::get('/', 													['uses' => 'HomeController@index', 'as' => 'frontend.home.index']);

	// ------------------------------------------------------------------------------------
	// PRODUCT
	// ------------------------------------------------------------------------------------

	Route::get('products/{page?}', 									['uses' => 'ProductController@index', 'as' => 'frontend.product.index']);

	Route::get('products/detail/{slug?}', 										['uses' => 'ProductController@show', 'as' => 'frontend.product.show']);
	});

	// ------------------------------------------------------------------------------------
	// USER MENU
	// ------------------------------------------------------------------------------------

	Route::group(['prefix' => 'profile', 'middleware' => 'customer'], function() 
	{
		Route::get('/', 												['uses' => 'UserController@index', 'as' => 'frontend.user.index']);
		
		Route::get('/setting', 											['uses' => 'UserController@edit', 'as' => 'frontend.user.edit']);

		Route::get('/change/password',									['uses' => 'UserController@changePassword', 'as' => 'frontend.user.change.password']);

		Route::post('/setting', 										['uses' => 'UserController@update', 'as' => 'frontend.user.update']);
		
		Route::get('/points', 											['uses' => 'UserController@point', 'as' => 'frontend.user.point']);

		Route::get('/downline', 										['uses' => 'UserController@downline', 'as' => 'frontend.user.downline']);

		Route::resource('address',  									'AddressController',			
																		['names' => ['index' => 'frontend.user.address.index', 'create' => 'frontend.user.address.create', 
																		'store' => 'frontend.user.address.store', 'show' => 'frontend.user.address.show', 
																		'edit' => 'frontend.user.address.edit', 'update' => 'frontend.user.address.update', 
																		'destroy' => 'frontend.user.address.destroy']]);
		
		Route::get('/orders', 											['uses' => 'UserController@orders', 'as' => 'frontend.user.order.index']);

		Route::get('/order/{ref}', 										['uses' => 'UserController@order', 'as' => 'frontend.user.order.show']);
		
		Route::post('/order/delete/{ref}', 								['uses' => 'UserController@orderdestroy', 'as' => 'frontend.user.order.destroy']);

		Route::get('/order/show/confirm',								['uses' => 'UserController@orderconfirmdestroy', 'as' => 'frontend.user.order.confirm']);
	
		Route::get('/reference', 										['uses' => 'CampaignController@getreference', 'as' => 'frontend.user.reference.get']);

		Route::post('/reference', 										['uses' => 'CampaignController@postreference', 'as' => 'frontend.user.reference.post']);

		Route::get('edit/cart', 										['uses' => 'CartController@edit', 'as' => 'frontend.cart.edit']);

		Route::get('/redeem/code',										['uses' => 'RedeemController@index', 'as' => 'frontend.redeem.index']);
	});
	
	Route::get('do/logout',												['uses' => 'AuthController@doLogout', 'as' => 'frontend.dologout']);

	// ------------------------------------------------------------------------------------
	// USER ACTIVATION
	// ------------------------------------------------------------------------------------

	Route::get('/mail/activation/{activation_link}', 					['uses' => 'AuthController@activateAccount' ,'as' => 'balin.claim.voucher']);

	Route::group(['middleware' => 'redirectsave'], function() 
	{
	// ------------------------------------------------------------------------------------
	// CART
	// ------------------------------------------------------------------------------------

	Route::get('cart', 													['uses' => 'CartController@index', 'as' => 'frontend.cart.index']);

	Route::any('cart/list',												['uses' => 'CartController@getListBasket', 'as' => 'frontend.cart.listBasket.ajax']);

	Route::any('cart/add', 												['uses' => 'CartController@store', 'as' => 'frontend.cart.store.ajax' ]);

	Route::any('update/cart/{cid?}/{vid?}',								['uses' => 'CartController@update', 'as' => 'frontend.cart.update']);

	Route::any('remove/from/cart',										['uses' => 'CartController@destroy', 'as' => 'frontend.cart.destroy']);
	
	Route::get('empty/cart',											['uses' => 'CartController@clean', 'as' => 'frontend.cart.empty']);

	// Get address
	Route::any('get/address/{id?}',										['uses' => 'CheckOutController@getAddress', 'as' => 'frontend.address.get.ajax']);
	
	// ------------------------------------------------------------------------------------
	// CHECKOUT
	// ------------------------------------------------------------------------------------
	
	Route::group(['middleware' => 'customer'], function() 
	{
		Route::get('checkout',											['uses' => 'CheckOutController@getCheckout', 'as' => 'frontend.get.checkout']);
		
		Route::post('checkout',											['uses' => 'CheckOutController@postCheckout', 'as' => 'frontend.post.checkout']);
		
		Route::any('ship/cost',											['uses' => 'CheckOutController@getShippingCost', 'as' => 'frontend.any.zipcode']);
		
		Route::any('check/voucher',										['uses' => 'CheckOutController@checkvoucher', 'as' => 'frontend.any.check.voucher']);
		
		Route::any('checked/out',										['uses' => 'CheckOutController@checkedout', 'as' => 'frontend.any.checked.out']);
	});
	});

	Route::get('why/join',												['uses' => 'WhyJoinController@index', 'as' => 'frontend.whyjoin.index']);
	
	Route::get('about/us', 												['uses' => 'AboutUsController@index', 'as' => 'frontend.aboutus.index']);
	
	Route::get('contact/us', 											['uses' => 'ContactUsController@index', 'as' => 'frontend.contactus.index']);
	
	Route::post('contact/us', 											['uses' => 'ContactUsController@submit', 'as' => 'contactus.dosubmit']);
	
	Route::get('contact/us/thanks', 									['uses' => 'ContactUsController@thanks', 'as' => 'contactus.thanks']);
	
	Route::get('/term/condition', 										['uses' => 'HomeController@index', 		'as' => 'balin.term.condition']);
	
	Route::get('/about/use', 											['uses' => 'AboutUsController@index', 		'as' => 'balin.about.us']);
	
	Route::get('/404', 													['uses' => 'ErrorController@er404', 		'as' => 'frontend.error.404']);
});
