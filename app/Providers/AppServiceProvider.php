<?php

namespace App\Providers;

use App\User;
use App\Image;
use App\Observers\UserObserver;
use App\Observers\ImageObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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
            return auth()->user() && auth()->user()->id == $image->user->id;
        });

        Blade::if('isNotPublic', function ($image) {
            return $image->is_public == 0 && (! Auth::check() || auth()->user()->id != $image->user->id);
        });
    }
}
