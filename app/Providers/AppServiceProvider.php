<?php

namespace App\Providers;

use App\Image;
use App\Observers\ImageObserver;
use App\Observers\UserObserver;
use App\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('vendor.pagination.tailwind');

        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');

        Schema::defaultStringLength(191);

        Image::observe(ImageObserver::class);
        User::observe(UserObserver::class);

        Blade::if('ownsImage', function ($image) {
            return auth()->user() && (auth()->user()->id == $image->user->id || auth()->user()->role == 1);
        });

        Blade::if('ownsAlbum', function ($album) {
            return auth()->user() && (auth()->user()->id == $album->user->id || auth()->user()->role == 1);
        });

        Blade::if('imageIsNotPublic', function ($image) {
            return $this->isItemPublic($image);
        });

        Blade::if('albumIsNotPublic', function ($album) {
            return $this->isItemPublic($album);
        });
    }

    public function isItemPublic($item)
    {
        if ($item->is_public == 0) {
            if (! auth()->user()) {
                return true;
            }

            if (auth()->user() && auth()->user()->id == $item->user->id) {
                return false;
            }

            if (auth()->user() && auth()->user()->role == 1) {
                return false;
            }

            return true;
        }

        return false;
    }
}
