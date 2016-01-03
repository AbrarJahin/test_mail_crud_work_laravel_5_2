<?php

Route::get('/', [
	'middleware' 	=> 'guest',
    'uses' 			=> 'PublicController@index',
    'as' 			=> 'index'
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
