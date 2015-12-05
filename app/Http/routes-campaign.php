<?php

// ------------------------------------------------------------------------------------
// CAMPAIGN
// ------------------------------------------------------------------------------------
Route::group(['namespace' => 'Campaign\\'], function() 
{
	// ------------------------------------------------------------------------------------
	// INVITATION
	// ------------------------------------------------------------------------------------

	Route::get('join/by/invitation', 									['uses' => 'InvitationController@getinvitation', 'as' => 'frontend.join.get']);

	Route::post('join/by/invitation', 									['uses' => 'InvitationController@postinvitation', 'as' => 'frontend.join.post']);

	// ------------------------------------------------------------------------------------
	// EARLY SIGNUP
	// ------------------------------------------------------------------------------------

	Route::group(['prefix' => 'early'], function()
	// Route::group(['domain' => 'early.balin.id'], function()
	{
		Route::get('/', 										['uses' => 'EarlySignUpController@getearlier', 'as' => 'frontend.early.get']);

		Route::post('/', 										['uses' => 'EarlySignUpController@postearlier', 'as' => 'frontend.early.post']);
		
		Route::get('/sso', 										['uses' => 'EarlySignUpController@postearliersso', 'as' => 'frontend.earlysso.post']);

		Route::get('sso/success',								['uses' => 'AuthController@getSso', 'as' => 'frontend.earlysso.get']);

		Route::get('/redeem', 									['uses' => 'EarlySignUpController@getpromo', 'as' => 'frontend.promo.get']);

		Route::post('/redeem', 									['uses' => 'EarlySignUpController@postpromo', 'as' => 'frontend.promo.post']);
	});
});
