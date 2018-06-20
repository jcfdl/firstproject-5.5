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

Route::get('/post/{id}', ['as'=>'home.post', 'uses'=>'AdminPostsController@post']);

/*
|--------------------------------------------------------------------------
| Middlewares
|--------------------------------------------------------------------------
|
|Route grouping with middlewares
|
*/

Route::group(['middleware'=>'admin'], function() {
	Route::get('/admin', function() {
		return view('admin.index');
	});
	Route::resource('admin/users', 'AdminUsersController');
	Route::resource('admin/posts', 'AdminPostsController');
	Route::resource('admin/categories', 'AdminCategoriesController');
	// Sample deleting using link
	Route::get('admin/categories/{categories}', ['as'=>'category.delete', 'uses'=>'AdminCategoriesController@destroy']);
	Route::resource('admin/media', 'AdminMediasController');
	Route::get('admin/media/{media}', ['as'=>'admin.media.delete', 'uses'=>'AdminMediasController@destroy']);
	// Route::get('admin/media/upload', ['as'=>'admin.media.upload', 'uses'=>'AdminMediasController@store'], function() {
	// });	
	// Comments 
	Route::resource('admin/comments', 'PostCommentsController');
	Route::get('admin/comments/{comments}', ['as'=>'comment.edit', 'uses'=>'PostCommentsController@update']);
	Route::get('admin/comments/delete/{comments}', ['as'=>'comment.delete', 'uses'=>'PostCommentsController@destroy']);
	Route::get('admin/comments/{comments}/show', ['as'=>'comment.show', 'uses'=>'PostCommentsController@show']);
	// Replies		
	Route::resource('admin/comment/replies', 'CommentRepliesController');	
	Route::get('admin/comment/replies/{replies}', ['as'=>'reply.edit', 'uses'=>'CommentRepliesController@update']);
	Route::get('admin/comment/replies/delete/{replies}', ['as'=>'reply.delete', 'uses'=>'CommentRepliesController@destroy']);
	Route::get('admin/comment/replies/{replies}/show', ['as'=>'reply.show', 'uses'=>'CommentRepliesController@show']);
});

Route::group(['middleware'=>'auth'], function() {
	Route::post('comment/reply', 'CommentRepliesController@createReply');
});