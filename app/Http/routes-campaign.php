<?php

// ------------------------------------------------------------------------------------
// CAMPAIGN
// ------------------------------------------------------------------------------------
Route::group(['namespace' => 'Campaign\\'], function() 
{
	// ------------------------------------------------------------------------------------
	// INVITATION
	// ------------------------------------------------------------------------------------

	Route::get('join/by/invitation', 									['uses' => 'InvitationController@getinvitation', 'as' => 'campaign.join.get']);

	Route::post('join/by/invitation', 									['uses' => 'InvitationController@postinvitation', 'as' => 'campaign.join.post']);

	// ------------------------------------------------------------------------------------
	// EARLY SIGNUP
	// ------------------------------------------------------------------------------------

	// Route::group(['prefix' => 'early'], function()
	// Route::group(['domain' => 'balin.id'], function()
	// {
	// 	Route::get('/', 										['uses' => 'EarlySignUpController@getearlier', 'as' => 'campaign.early.get']);

	// 	Route::post('/', 										['uses' => 'EarlySignUpController@postearlier', 'as' => 'campaign.early.post']);
		
	// 	Route::get('/sso', 										['uses' => 'EarlySignUpController@postearliersso', 'as' => 'campaign.earlysso.post']);

	// 	Route::get('sso/success',								['uses' => '\App\Http\Controllers\Frontend\AuthController@getSso', 'as' => 'campaign.earlysso.get']);

	// 	Route::get('/redeem', 									['uses' => 'EarlySignUpController@getpromo', 'as' => 'campaign.promo.get']);

	// 	Route::post('/redeem', 									['uses' => 'EarlySignUpController@postpromo', 'as' => 'campaign.promo.post']);
	// });
});
