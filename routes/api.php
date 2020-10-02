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
    Route::get('/global', [APIStatsController::class, 'global']);// Return site stats
});

// User
Route::get('/user/{username}', [APIUserController::class, 'user']);// Return site stats

// Image OLD
Route::prefix('/images')->group(function () {
    Route::get('/public', [APIImageController::class, 'public']); // Show public public images
    Route::get('/id/{id}', [APIImageController::class, 'show']); // Show specific image (api_token may required)
    Route::get('/delete/{id}', [APIImageController::class, 'delete'])->name('api_image_delete'); // Delete specific image (api_token may required)
});

Route::prefix('/v2')->group(function () {
    Route::post('/upload', [APIImageV2Controller::class, 'store'])->name('apiv2_upload');
    Route::get('/delete/{imageName}', [APIImageV2Controller::class, 'delete'])->name('apiv2_image_delete'); // Delete specific image (api_token is required)
});

// Upload
Route::post('/upload', [APIImageController::class, 'store'])->name('api_upload');
