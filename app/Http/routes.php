<?php

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

    //Users list AJAX post for datatables
    Route::post('users_list', [
        'uses'          => 'AdminController@users_list',
        'as'            => 'users_list'
    ]);
    //Users list AJAX - supporting
    Route::put('users_list/activate', [
        'uses'          => 'AdminController@users_list_activate',
        'as'            => 'users_list_activate'
    ]);
    Route::put('users_list/suspend', [
        'uses'          => 'AdminController@users_list_suspend',
        'as'            => 'users_list_suspend'
    ]);
    Route::delete('users_list/delete', [
        'uses'          => 'AdminController@users_list_delete',
        'as'            => 'users_list_delete'
    ]);

    //Articles list AJAX post for datatables
    Route::post('articles_list', [
        'uses'          => 'AdminController@articles_list',
        'as'            => 'articles_list'
    ]);
    //Articles list AJAX - supporting
    Route::put('articles_list/activate', [
        'uses'          => 'AdminController@articles_list_activate',
        'as'            => 'articles_list_activate'
    ]);
    Route::put('articles_list/suspend', [
        'uses'          => 'AdminController@articles_list_suspend',
        'as'            => 'articles_list_suspend'
    ]);
    Route::delete('articles_list/delete', [
        'uses'          => 'AdminController@articles_list_delete',
        'as'            => 'articles_list_delete'
    ]);
});

//User Routes
Route::group(['middleware' => ['web','user']], function ()
{
    //My Articles - Add, edit, delete
    Route::get('my_articles', [
        'uses'          => 'UserController@my_articles',
        'as'            => 'my_articles'
    ]);

    Route::get('all_articles', [
        'uses'          => 'UserController@all_articles',
        'as'            => 'all_articles'
    ]);
    //All Articles list AJAX post for datatables
    Route::post('all_articles_list', [
        'uses'          => 'UserController@all_articles_public_list',
        'as'            => 'all_articles_list'
    ]);
    //All Articles list AJAX post for datatables
    Route::post('my_articles_list', [
        'uses'          => 'UserController@my_articles_public_list',
        'as'            => 'my_articles_list'
    ]);
    //Add Aticles
    Route::post('add_articles', [
        'uses'          => 'UserController@add_articles',
        'as'            => 'add_articles'
    ]);

    //Edit Aticles
    Route::post('my_articles_list/get', [
        'uses'          => 'UserController@get_articles',
        'as'            => 'get_articles'
    ]);

    //Edit Aticles
    Route::post('my_articles_list/edit', [
        'uses'          => 'UserController@edit_articles',
        'as'            => 'edit_articles'
    ]);

    //Delete Aticles
    Route::delete('my_articles_list/delete', [
        'uses'          => 'UserController@delete_article',
        'as'            => 'delete_article'
    ]);
    //Balance View
    Route::get('balance', [
        'uses'          => 'UserController@show_balance',
        'as'            => 'show_balance'
    ]);
    //Adding balance
    Route::post('balance', [
        'uses'          => 'UserController@add_balance',
        'as'            => 'add_balance'
    ]);
});