<?php

Route::group(['namespace' => 'Users'], function(){
	Route::get('/','HomeController@index');
	Route::get('/post/{post}','postController@post')->name('post');
	Route::get('post/tag/{tag}','HomeController@tags')->name('tag');
	Route::get('post/category/{category}','HomeController@category');
});


Route::group(['namespace' => 'Admin'], function(){
	
	Route::get('admin/home','HomeController@index')->name('admin/home');

	Route::resource('admin/post','PostController');

	Route::resource('admin/tag','TagController');

	Route::resource('admin/category','CategoryController');

	Route::resource('admin/user','UserController');
	
	Route::resource('admin/role','RoleController');


	Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('admin.login');

	Route::post('admin/login', 'Auth\LoginController@login');

	Route::get('admin/logout','Auth\LoginController@logout')->name('admin.logout');


});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
