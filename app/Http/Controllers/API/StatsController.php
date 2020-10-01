<?php

namespace App\Http\Controllers\API;

use App\Album;
use App\Http\Controllers\Controller;
use App\Image;
use App\User;

class StatsController extends Controller
{
    /**
     * Return global site stats.
     *
     * @return array
     */
    public function global()
    {
        $data = [];

        $all_time = [
            'images' => Image::count(),
            'albums' => Album::count(),
            'users'  => User::count(),
        ];

        $last_day = [
            'images' => Image::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->count(),
            'albums' => Album::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->count(),
            'users'  => User::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->count(),
        ];

        $last_week = [
            'images' => Image::where('created_at', '>=', \Carbon\Carbon::now()->subWeek())->count(),
            'albums' => Album::where('created_at', '>=', \Carbon\Carbon::now()->subWeek())->count(),
            'users'  => User::where('created_at', '>=', \Carbon\Carbon::now()->subWeek())->count(),
        ];

        $last_month = [
            'images' => Image::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count(),
            'albums' => Album::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count(),
            'users'  => User::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count(),
        ];

        $last_half_year = [
            'images' => Image::where('created_at', '>=', \Carbon\Carbon::now()->subMonths(6))->count(),
            'albums' => Album::where('created_at', '>=', \Carbon\Carbon::now()->subMonths(6))->count(),
            'users'  => User::where('created_at', '>=', \Carbon\Carbon::now()->subMonths(6))->count(),
        ];

        $last_year = [
            'images' => Image::where('created_at', '>=', \Carbon\Carbon::now()->subYear())->count(),
            'albums' => Album::where('created_at', '>=', \Carbon\Carbon::now()->subYear())->count(),
            'users'  => User::where('created_at', '>=', \Carbon\Carbon::now()->subYear())->count(),
        ];

        $data['all_time'] = $all_time;
        $data['last_day'] = $last_day;
        $data['last_week'] = $last_week;
        $data['last_month'] = $last_month;
        $data['last_half_year'] = $last_half_year;
        $data['last_year'] = $last_year;

        return $data;
    }
}
