<?php

Route::get('/', [
	'middleware' 	=> 'guest',
    'uses' 			=> 'PublicController@index',
    'as' 			=> 'index'
]);

Route::get('email_confirmation/{token}', [
	'middleware' 	=> 'guest',
    'uses' 			=> 'PublicController@email_confirmation',
    'as' 			=> 'confirm_mail'
]);

/*Route::group(['middleware' => ['web']], function ()
{
    //
});*/

Route::group(['middleware' => 'web'], function ()
{
    Route::auth();

    Route::get('/home', 'HomeController@index');
});
