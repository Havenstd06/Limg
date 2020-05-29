<?php

namespace App\Http\Controllers;

use App\User;
use App\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Rules\ValidDiscordWebhookRule;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as InterImage;

class UserController extends Controller
{
    public function profile(Request $request, $username)
    {
        $user = User::where('username', '=', $username)->firstOrFail();

        $userImages = Image::where('user_id', '=', $user->id)->orderBy('created_at', 'DESC')->paginate(18);

        return view('user.profile', [
            'user' => $user,
            'userImages' => $userImages,
        ]);
    }

    public function settings(Request $request, User $user)
    {
        abort_unless($user == $request->user(), 403);

        return view('user.settings', [
            'user' => $user,
        ]);
    }

    public function update_profile(Request $request, User $user)
    {
        abort_unless($user == $request->user(), 403);

        $user->always_public = $request->has('always_public');
        $user->description = $request->input('description');
        $user->save();

        notify()->success('You have successfully update your profile!');

        return back();
    }

    public function update_style(Request $request, User $user)
    {
        abort_unless($user == $request->user(), 403);

        $user->style = $request->has('style');
        $user->save();

        notify()->success('You have successfully update your style!');

        return back();
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'string', 'min:8'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        notify()->success('You have successfully update your passsword.');

        return back();
    }

    public function update_token(Request $request)
    {
        User::find(auth()->user()->id)->update([
            'api_token' => Str::random(20),
        ]);

        notify()->success('You have successfully update your token.');

        return back();
    }

    public function update_domain(Request $request, User $user)
    {
        abort_unless($user == $request->user(), 403);

        $user->domain = $request->input('domain');

        $v = validator($user->toArray(), [
            'domain' => 'required',
        ]);

        if ($v->fails()) {
            notify()->error('Error must be filled');

            return redirect()->back();
        }
        $user->save();

        notify()->success('You have successfully update your domain.');

        return back();
    }

    public function update_webhook(Request $request, User $user)
    {
        abort_unless($user == $request->user(), 403);

        $user->webhook_url = $request->input('webhook_url');

        $v = validator($user->toArray(), [
            'webhook_url' => ['required', 'url', new ValidDiscordWebhookRule]
        ]);

        if ($v->fails()) {
            notify()->error('Error must be valid webbook');

            return redirect()->back();
        }
        $user->save();

        notify()->success('You have successfully update your Discord Webhook URL.');

        return back();
    }

    public function update_avatar(Request $request, User $user)
    {
        abort_unless($user == $request->user(), 403);

        $rules = [
            'avatar' => 'required | mimes:jpeg,jpg,png,gif,bmp,tiff',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            notify()->error('Image must be filled!');

            return back();
        }

        $user = auth()->user();

        $avatar = $request->file('avatar');

        $maxSize = 2000000; // 2 MB

        if ($maxSize >= $avatar->getSize()) {
            $avatarName = strtolower($user->username).'.'.$request->file('avatar')->getClientOriginalExtension();
            $location = storage_path('app/public/avatars/'.$avatarName);

            $oldExt = pathinfo($user->avatar, PATHINFO_EXTENSION);
            $oldAvatar = storage_path('app/public/avatars/'.strtolower($user->username).'.'.$oldExt);

            if (file_exists($oldAvatar)) {
                File::delete($oldAvatar);
            }

            if ($avatar->getClientOriginalExtension() == 'gif') {
                copy($avatar->getRealPath(), $location);
            } else {
                InterImage::make($avatar)->resize(150, 150)->save($location);
            }
        } else {
            notify()->error('Your avatar is too large, max file size: 2 MB');

            return back();
        }

        $user->avatar = 'storage/avatars/'.$avatarName;
        $user->save();

        notify()->success('You have successfully upload avatar.');

        return back();
    }

    public function my_images(Request $request, $username)
    {
        $user = User::where('username', '=', $username)->firstOrFail();

        abort_unless($user == $request->user(), 403);

        return view('user.myimages', [
            'user' => $user,
        ]);
    }
}
