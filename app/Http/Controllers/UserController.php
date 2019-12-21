<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as InterImage;

class UserController extends Controller
{
  public function profile(User $user)
  {
    
    return view('user.profile', [
      'user' => $user,
    ]);
  }


  public function update_avatar(Request $request)
  {

    $user = auth()->user();

    $max = config('image.max_size');
    
    $avatar = $request->file('avatar');

    if ($max >= $avatar->getSize()) {
      $avatarName = strtolower($user->username) . '.' . $request->file('avatar')->getClientOriginalExtension();
      $location = storage_path('app/public/avatars/' . $avatarName);

      $oldExt = pathinfo($user->avatar, PATHINFO_EXTENSION);
      $oldAvatar = storage_path('app/public/avatars/' . strtolower($user->username) . '.' . $oldExt);

      if (file_exists($oldAvatar)) {
        File::delete($oldAvatar);
      }

      if ($avatar->getClientOriginalExtension() == 'gif') {
        copy($avatar->getRealPath(), $location);
      } else {
        InterImage::make($avatar)->resize(150, 150)->save($location);
      }

    }
    else {
      return back()->withErrors('Your avatar is too large, max file size: ' . ($max / 1000000) . ' MB');
    }

    $user->avatar = $avatarName;
    $user->save();

    return back()->with('success', 'You have successfully upload image. ');
  }
}
