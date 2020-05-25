<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('login/discord', 'Auth\LoginController@redirectToProvider')->name('login.discord');
Route::get('login/discord/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index')->name('home');

// Profile Route
Route::prefix('p/{user}')->group(function () {
    Route::get('/', 'UserController@profile')->name('profile');
    Route::name('settings.')->prefix('settings')->group(function () {
        Route::get('/', 'UserController@settings')->name('index');
        Route::post('update/style', 'UserController@update_style')->name('update.style');
        Route::post('update/profile', 'UserController@update_profile')->name('update.profile');
        Route::post('update/password', 'UserController@update_password')->name('update.password');
        Route::post('update/token', 'UserController@update_token')->name('update.token');
        Route::post('update/avatar', 'UserController@update_avatar')->name('update.avatar');
    });
});

// Image Route
Route::post('/upload', 'ImageController@upload')->name('upload');
Route::post('/api/upload', 'ImageController@api_upload')->name('api_upload');

Route::prefix('/i/{image}')->group(function () {
    Route::get('/', 'ImageController@get')->name('image.show');

    Route::post('/updates', 'ImageController@infos')->name('image.infos');
    Route::get('/delete', 'ImageController@delete')->name('image.delete');
    Route::get('/download', 'ImageController@download')->name('image.download');
    Route::get('/{size}', 'ImageController@build');
});
