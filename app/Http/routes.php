<?php

/*Route::get('/', [
	'middleware' 	=> 'guest',
    'uses' 			=> 'PublicController@index',
    'as' 			=> 'index'
]);

Route::get('email_confirmation/{token}', [
	'middleware' 	=> 'guest',
    'uses' 			=> 'PublicController@email_confirmation',
    'as' 			=> 'confirm_mail'
]);*/

//Public poutes
Route::group(['middleware' => 'guest'], function ()
{
    Route::get('/', [
        'uses' 			=> 'PublicController@index',
        'as' 			=> 'index'
    ]);

    Route::get('email_confirmation/{token}', [
        'uses' 			=> 'PublicController@email_confirmation',
        'as' 			=> 'confirm_mail'
    ]);
});

//Auth Routes - default modified auth system for Laravel 5.2
Route::group(['middleware' => 'web'], function ()
{
    Route::auth();

    Route::get('/home', 'HomeController@index');
});

//Admin Routes
Route::group(['middleware' => ['web','admin']], function ()
{
    //suspend, activate, delete
    Route::get('users', [
        'uses'          => 'AdminController@users',
        'as'            => 'users'
    ]);

    //Edit,activate,suspend, delete
    Route::get('articles', [
        'uses'          => 'AdminController@articles',
        'as'            => 'articles'
    ]);
});

//Admin Routes
Route::group(['middleware' => ['web','user']], function ()
{
/*
    //Edit,activate,suspend, delete
    Route::get('articles', [
        'uses'          => 'AdminController@articles',
        'as'            => 'articles'
    ]);*/
});