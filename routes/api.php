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
use App\Http\Controllers\API\ImageController as APIImageController;
use App\Http\Controllers\API\ImageV2Controller as APIImageV2Controller;
use App\Http\Controllers\API\StatsController as APIStatsController;
use App\Http\Controllers\API\UserController as APIUserController;

Route::prefix('/stats')->group(function () {
    Route::get('/global', [APIStatsController::class, 'global']); // Return site stats
});

// User
Route::prefix('/user')->group(function () {
    Route::get('/{username}', [APIUserController::class, 'user']); // Return user stats & info
    Route::get('/{username}/images/all', [APIUserController::class, 'all']); // Return discover user image
    Route::get('/{username}/images/discover', [APIUserController::class, 'discover']); // Return discover user image
    Route::get('/{username}/images/public', [APIUserController::class, 'public']); // Return public user image
    Route::get('/{username}/images/private', [APIUserController::class, 'private']); // Return private user image
});


// Image OLD
Route::prefix('/images')->group(function () {
    Route::get('/discover', [APIImageController::class, 'discover']); // Show public public images
    Route::get('/id/{id}', [APIImageController::class, 'show']); // Show specific image (api_token may required)
    Route::get('/delete/{pageName}', [APIImageController::class, 'delete'])->name('api_image_delete'); // Delete specific image (api_token is required)
});

// Upload
Route::post('/upload', [APIImageController::class, 'store'])->name('api_upload');
