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

use App\Http\Controllers\ImageController;

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');


// Profile Route
Route::prefix('p')->group(function () {
    Route::get('{user}', 'UserController@profile')->name('profile');
    Route::post('update_avatar', 'UserController@update_avatar')->name('update_avatar');
});


// Image Route
Route::post('/upload', 'ImageController@upload')->name('upload');
Route::get('/i/{image}', 'ImageController@getImage')->name('image.show');


