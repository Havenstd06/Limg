<?php

namespace App\Providers;

use App\User;
use App\Image;
use App\Observers\UserObserver;
use App\Observers\ImageObserver;
use Illuminate\Support\Facades\Blade;
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
        Image::observe(ImageObserver::class);
        User::observe(UserObserver::class);

        Blade::if('ownsImage', function ($image) {
            return (auth()->user() && auth()->user()->id == $image->user->id);
        });
    }
}
