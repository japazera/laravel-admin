<?php

Auth::routes();
Route::get('/admin', 'HomeController@admin')->name('home');
Route::get('/', 'HomeController@index')->name('site.home');
Route::resource('/admin/user', 'UserController');
