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

Auth::routes();

Route::get('login/discord', 'Auth\LoginController@redirectToProvider')->name('login.discord');
Route::get('login/discord/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/', 'HomeController@main')->name('home');

// Profile Route
Route::prefix('p/{user}')->group(function () {
    Route::get('/', 'UserController@profile')->name('user.profile');
    Route::get('/gallery', 'UserController@gallery')->name('user.gallery');
    Route::get('/albums', 'UserController@albums')->name('user.albums');
    Route::name('settings.')->prefix('settings')->group(function () {
        Route::get('/', 'UserController@settings')->name('main');
        Route::post('update/style', 'UserController@update_style')->name('update.style');
        Route::post('update/profile', 'UserController@update_profile')->name('update.profile');
        Route::post('update/password', 'UserController@update_password')->name('update.password');
        Route::post('update/token', 'UserController@update_token')->name('update.token');
        Route::post('update/domain', 'UserController@update_domain')->name('update.domain');
        Route::post('update/webhook', 'UserController@update_webhook')->name('update.webhook');
        Route::post('update/avatar', 'UserController@update_avatar')->name('update.avatar');
    });
});

// Image Route
Route::post('/upload', 'ImageController@upload')->name('upload');
Route::post('/url/upload', 'ImageController@url_upload')->name('url_upload');
Route::post('/api/upload', 'ImageController@api_upload')->name('api_upload');

Route::prefix('/i')->group(function () {
    Route::get('/', 'ImageController@main')->name('image.main');

    Route::prefix('/{image}')->group(function () {
        Route::get('/', 'ImageController@get')->name('image.show');
        Route::post('/like', 'ImageController@like')->name('image.like');
        Route::post('/unlike', 'ImageController@unlike')->name('image.unlike');

        Route::post('/updates', 'ImageController@infos')->name('image.infos');
        Route::get('/delete', 'ImageController@delete')->name('image.delete');
        Route::get('/addtoalbum', 'ImageController@add_to_album')->name('image.add_to_album');
        Route::get('/download', 'ImageController@download')->name('image.download');
        Route::get('/{size}', 'ImageController@build');
    });
});

Route::prefix('/a')->group(function () {
    Route::get('/', 'AlbumController@main')->name('album.main');
    Route::get('/new', 'AlbumController@create')->name('album.create');

    Route::prefix('/{album}')->group(function () {
        Route::get('/', 'AlbumController@show')->name('album.show');

        Route::post('/updates', 'AlbumController@infos')->name('album.infos');
        Route::get('/delete', 'AlbumController@delete')->name('album.delete');
        Route::get('/remove/{image:pageName}', 'AlbumController@remove')->name('album.remove');
    });
});
