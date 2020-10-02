<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     * @return Renderable
     */
    public function main()
    {
        $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);

        return view('home', [
            'user'   => $user,
        ]);
    }
}
