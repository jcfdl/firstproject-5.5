<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware'=>'admin'], function() {
	Route::get('/admin', function() {
		return view('admin.index');
	});
	Route::resource('admin/users', 'AdminUsersController', ['names'=>[
		'index'		=> 'admin.users.index',
		'create'	=> 'admin.users.create',
		'store'		=> 'admin.users.store',
		'edit'		=> 'admin.users.edit'
	]]);
	Route::resource('admin/posts', 'AdminPostsController', ['names'=>[
		'index' 	=> 'admin.posts.index',
		'create' 	=> 'admin.posts.create',
		'edit'		=> 'admin.posts.edit'
	]]);
	Route::get('/post/{id}', ['as'=>'home.post', 'uses'=>'AdminPostsController@post']);
	Route::resource('admin/categories', 'AdminCategoriesController', ['names'=>[
		'index' 	=> 'admin.categories.index',
		'create' 	=> 'admin.categories.create',
		'edit'		=> 'admin.categories.edit'
	]]);
	// Sample deleting using link
	// Depecrated in 5.3
	// Route::get('admin/categories/{categories}', ['as'=>'category.delete', 'uses'=>'AdminCategoriesController@destroy']);
	Route::get('admin/categories/{category}', 'AdminCategoriesController@destroy')->name('category.delete');
	Route::resource('admin/media', 'AdminMediasController', ['names'=>[
		'index' 	=> 'admin.media.index',
		'create' 	=> 'admin.media.create'
	]]);
	Route::get('admin/media/{medium}', 'AdminMediasController@destroy')->name('admin.media.delete');
	// Route::get('admin/media/upload', ['as'=>'admin.media.upload', 'uses'=>'AdminMediasController@store'], function() {
	// });	
	// Comments 
	Route::resource('admin/comments', 'PostCommentsController', ['names'=>[
		'index' 	=> 'admin.comments.index'
	]]);
	Route::get('admin/comments/{comments}', ['as'=>'comment.edit', 'uses'=>'PostCommentsController@update']);
	Route::get('admin/comments/delete/{comments}', ['as'=>'comment.delete', 'uses'=>'PostCommentsController@destroy']);
	Route::get('admin/comments/{comments}/show', ['as'=>'comment.show', 'uses'=>'PostCommentsController@show']);
	// Replies		
	Route::resource('admin/comment/replies', 'CommentRepliesController');	
	Route::get('admin/comment/replies/{replies}', ['as'=>'reply.edit', 'uses'=>'CommentRepliesController@update']);
	Route::get('admin/comment/replies/delete/{replies}', ['as'=>'reply.delete', 'uses'=>'CommentRepliesController@destroy']);
	Route::get('admin/comment/replies/{replies}/show', ['as'=>'reply.show', 'uses'=>'CommentRepliesController@show']);
});