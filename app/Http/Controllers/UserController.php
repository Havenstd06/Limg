<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image as InterImage;

class UserController extends Controller
{
  public function profile(User $user)
  {
    
    return view('user.profile', [
      'user' => $user,
    ]);
  }

  public function settings(Request $request, User $user)
  {
    abort_unless($user == $request->user(), 403);

    return view('user.settings', [
        'user' => $user,
    ]);
  }

  public function update_password(Request $request)
  {
    $request->validate([
      'current_password' => ['required', new MatchOldPassword],
      'new_password' => ['required', 'string', 'min:8'],
      'new_confirm_password' => ['same:new_password'],
    ]);

    User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

    notify()->success('You have successfully update your passsword.');
    return back();
  }

  public function update_avatar(Request $request, User $user)
  {
    abort_unless($user == $request->user(), 403);

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
      } 
      else {
        InterImage::make($avatar)->resize(150, 150)->save($location);
      }

    }
    else {

      notify()->error('Your avatar is too large, max file size: ' . ($max / 1000000) . ' MB');
      return back();
    }

    $user->avatar = 'avatars/' . $avatarName;
    $user->save();

    notify()->success('You have successfully upload avatar.');
    return back();
  }
}
