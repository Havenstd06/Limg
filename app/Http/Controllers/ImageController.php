<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ImageController extends Controller
{
  public function getImage($image)
  {
    return response()->download(storage_path('app/public/images/'.$image), null, [], null);
  }

  public function upload(Request $request)
  {
    $newName = Str::random(7) . '.' . $request->file('image')->getClientOriginalExtension();
    $request->file('image')->move(('storage/images'), $newName);


    $image = new Image;
    $image->name = $newName;
    $image->path = "/i/" . $newName;
    $image->user_id = auth()->user()->id;
    $image->save();

    return redirect(route('home'));
  }
}
