<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Stats
Route::prefix('/stats')->group(function () {
    Route::get('/global', 'API\StatsController@global'); // Return site stats
});

// User
Route::get('/user/{username}', 'API\UserController@user'); // Return user stats

// Image OLD
Route::prefix('/images')->group(function () {
    Route::get('/public', 'API\ImageController@public'); // Show public public images
    Route::get('/id/{id}', 'API\ImageController@show'); // Show specific image (api_token may required)
    Route::get('/delete/{id}', 'API\ImageController@delete')->name('api_image_delete'); // Delete specific image (api_token may required)
});

Route::prefix('/v2')->group(function () {
    Route::post('/upload', 'API\ImageV2Controller@store')->name('apiv2_upload');
    Route::get('/delete/{imageName}', 'API\ImageV2Controller@delete')->name('apiv2_image_delete'); // Delete specific image (api_token is required)
});

// Upload
Route::post('/upload', 'API\ImageController@store')->name('api_upload');
