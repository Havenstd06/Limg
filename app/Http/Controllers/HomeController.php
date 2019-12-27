<?php

namespace App\Http\Controllers;

use App\Image;
use App\User;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);
        $images = $user->images;

        if (session('image_id')) {
            $image = Image::where('id', session('image_id'))->firstOrFail();
        } else {
            $image = new Image;
        }

        return view('home', compact('user', 'images', 'image'));
    }
}
