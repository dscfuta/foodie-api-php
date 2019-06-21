<?php

Route::POST('/login', 'AuthController@login')->name('login');
Route::POST('/register', 'AuthController@register');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::GET('/profile', 'ProfileController@getProfile');
    Route::PUT('/profile', 'ProfileController@updateProfile');

    Route::GET('/recipe/all', 'RecipeController@getAll');
    Route::GET('/recipe/{id}', 'RecipeController@getOne');

});

