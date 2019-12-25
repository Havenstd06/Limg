<?php

namespace App\Http\Controllers;

use App\User;
use App\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as InterImage;

class ImageController extends Controller
{
  public function upload(Request $request)
  {
    $rules = array(
      'image' => 'required | mimes:jpeg,jpg,png,gif,bmp,tiff',
    );

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      notify()->error('Image must be filled!');
      return back();
    }

    $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);

    $newName = Str::random(7);
    $newFullName = $newName . '.' . $request->file('image')->getClientOriginalExtension();
    $request->file('image')->move(('storage/images'), $newFullName);

    $image = new Image;
    $image->name = $newName;
    $image->extension = pathinfo($newFullName, PATHINFO_EXTENSION);
    $image->path = "/i/" . $newFullName;
    $image->user_id = $user->id;
    $image->save();

    notify()->success('You have successfully upload image!');

    return redirect(route('image.show', ['image' => $image->name]));
  }
  
  public function getImage($image)
  {
    if (strpos($image, '.') !== false) { // Afficher la page avec l'extension
      $imageLink = Image::where('path', '/i/' . $image)->firstOrFail();

      return response()->download(storage_path('app/public/images/' . $imageLink->fullname), null, [], null);
    } else { // Afficher le view image
      
      $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);
      $pageImage = Image::where('name', pathinfo($image, PATHINFO_FILENAME))->firstOrFail();

      return view('image', [
        'user' => $user,
        'image' => $pageImage,
      ]);
    }
  }

  public function imageInfos(Request $request, Image $image) 
  {
    $user = $request->user();
    abort_unless($user == $request->user(), 403);

    $rules = array(
      'title' => 'max:50',
    );

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      notify()->error('The title must contain maximum 50 characters!');
      return back();
    }

    $image->title = $request->input('title');
    $image->save();

    notify()->success('You have successfully update your image info!');

    return redirect(route('image.show', ['image' => $image->name]));
  }

  public function download(Image $image)
  {
    return ($image->title) ? response()->download($image->fullpath, Str::slug($image->title, '-') . '.' . $image->extension) : response()->download($image->fullpath);
  }
}
