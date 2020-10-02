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

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;

Auth::routes();

Route::get('/login/discord', [AuthLoginController::class, 'redirectToProvider'])->name('login.discord');
Route::get('/login/discord/callback', [AuthLoginController::class, 'handleProviderCallback']);

Route::get('/', [HomeController::class, 'main'])->name('home');

// Profile Route
Route::prefix('p/{user}')->group(function () {
    Route::get('/', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/gallery', [UserController::class, 'gallery'])->name('user.gallery');
    Route::get('/albums', [UserController::class, 'albums'])->name('user.albums');
    Route::name('settings.')->prefix('settings')->group(function () {
        Route::get('/', [UserController::class, 'settings'])->name('main');
        Route::post('update/style', [UserController::class, 'update_style'])->name('update.style');
        Route::post('update/profile', [UserController::class, 'update_profile'])->name('update.profile');
        Route::post('update/password', [UserController::class, 'update_password'])->name('update.password');
        Route::post('update/token', [UserController::class, 'update_token'])->name('update.token');
        Route::post('update/domain', [UserController::class, 'update_domain'])->name('update.domain');
        Route::post('update/webhook', [UserController::class, 'update_webhook'])->name('update.webhook');
        Route::post('update/avatar', [UserController::class, 'update_avatar'])->name('update.avatar');
    });
});

// Image Route
Route::post('/upload', [ImageController::class, 'upload'])->name('upload');
Route::post('/url/upload', [ImageController::class, 'url_upload'])->name('url_upload');

Route::prefix('/i')->group(function () {
    Route::get('/', [ImageController::class, 'main'])->name('image.main');

    Route::prefix('/{image}')->group(function () {
        Route::get('/', [ImageController::class, 'get'])->name('image.show');
        Route::post('/like', [ImageController::class, 'like'])->name('image.like');
        Route::post('/unlike', [ImageController::class, 'unlike'])->name('image.unlike');

        Route::post('/updates', [ImageController::class, 'infos'])->name('image.infos');
        Route::get('/delete', [ImageController::class, 'delete'])->name('image.delete');
        Route::get('/addtoalbum', [ImageController::class, 'add_to_album'])->name('image.add_to_album');
        Route::get('/download', [ImageController::class, 'download'])->name('image.download');
        Route::get('/{size}', [ImageController::class, 'build']);
    });
});

Route::prefix('/a')->group(function () {
    Route::get('/', [AlbumController::class, 'main'])->name('album.main');
    Route::get('/new', [AlbumController::class, 'create'])->name('album.create');

    Route::prefix('/{album}')->group(function () {
        Route::get('/', [AlbumController::class, 'show'])->name('album.show');

        Route::post('/updates', [AlbumController::class, 'infos'])->name('album.infos');
        Route::get('/delete', [AlbumController::class, 'delete'])->name('album.delete');
        Route::get('/remove/{image:pageName}', [AlbumController::class, 'remove'])->name('album.remove');
    });
});
