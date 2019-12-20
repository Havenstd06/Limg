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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');


// Profile Route
Route::get('p/{user}', 'UserController@index')->name('profile');


// Image Route
Route::post('/upload', 'ImageController@upload')->name('upload');
Route::get('/i/{image}', 'ImageController@getImage')->where('image', '^[^/]+$');
