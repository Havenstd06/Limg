<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $images = auth()->user()->images;

        return view('home', compact('images', 'user'));
    }

    public function upload(Request $request)
    {
        $newName = Str::random(7).'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(('storage/images'), $newName);

        $image = new Image;
        $image->name = $newName;
        $image->path = "storage/images/".$newName;
        $image->user_id = auth()->user()->id;
        $image->save();

        return redirect(route('home'));
    }
}
