<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/admin', function() {
	return view('admin.index');
});

/*
|--------------------------------------------------------------------------
| Middlewares
|--------------------------------------------------------------------------
|
|Route grouping with middlewares
|
*/

Route::group(['middleware'=>'admin'], function() {
	Route::resource('admin/users', 'AdminUsersController');
	Route::resource('admin/posts', 'AdminPostsController');
	Route::resource('admin/categories', 'AdminCategoriesController');
	// Sample deleting using link
	Route::get('admin/categories/{categories}', ['as'=>'category.delete', 'uses'=>'AdminCategoriesController@destroy']);
	Route::resource('admin/media', 'AdminMediasController');
	Route::get('admin/media/{media}', ['as'=>'admin.media.delete', 'uses'=>'AdminMediasController@destroy']);
	// Route::get('admin/media/upload', ['as'=>'admin.media.upload', 'uses'=>'AdminMediasController@store'], function() {
	// });
});
