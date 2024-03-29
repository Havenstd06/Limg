<?php

namespace App\Http\Controllers;

use App\Enums\ImageStateType;
use App\Image;
use App\Rules\MatchOldPassword;
use App\Rules\ValidDiscordWebhookRule;
use App\Rules\ValidImageDomainRule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as InterImage;

class UserController extends Controller
{
    public function profile(Request $request, $username)
    {
        $user = User::where('username', '=', $username)->firstOrFail();

        $allImages = Image::where('user_id', '=', $user->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        $discoverImages = Image::where('user_id', '=', $user->id)
            ->where('is_public', ImageStateType::Discover)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        $publicImages = Image::where('user_id', $user->id)
            ->where('is_public', ImageStateType::Public || ImageStateType::Discover)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        $public_images_count = $user->images()
            ->where('is_public', ImageStateType::Public || ImageStateType::Discover)
            ->count();

        $privateImages = Image::where('user_id', $user->id)
            ->where('is_public', ImageStateType::Private)
            ->orderBy('created_at', 'DESC')->paginate(20);

        $imagesLiked = Image::whereLikedBy($user->id)
            ->with('likeCounter')
            ->where('is_public', ImageStateType::Public || ImageStateType::Discover)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('user.profile', [
            'user'                 => $user,
            'allImages'            => $allImages,
            'discoverImages'       => $discoverImages,
            'publicImages'         => $publicImages,
            'public_images_count'  => $public_images_count,
            'privateImages'        => $privateImages,
            'imagesLiked'          => $imagesLiked,
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
        $user->always_discover = $request->has('always_discover');
        $user->description = $request->input('description');
        $user->save();

        flash()->addSuccess('You have successfully update your profile!');

        return back();
    }

    public function update_style(Request $request)
    {
        $user = auth()->user();

        $user->style = $request->has('style');
        $user->save();

        flash()->addSuccess('You have successfully update your style!');

        return back();
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'current_password'     => ['required', new MatchOldPassword],
            'new_password'         => ['required', 'string', 'min:8'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        flash()->addSuccess('You have successfully update your passsword!');

        return back();
    }

    public function update_token(Request $request)
    {
        User::find(auth()->user()->id)->update([
            'api_token' => Str::random(20),
        ]);

        flash()->addSuccess('You have successfully update your token!');

        return back();
    }

    public function update_domain(Request $request, User $user)
    {
        abort_unless($user == $request->user(), 403);

        $user->domain = $request->input('domain');

        $v = validator($user->toArray(), [
            'domain' => ['required', new ValidImageDomainRule],
        ]);

        if ($v->fails()) {
            flash()->addError('Domain must be valid!');

            return redirect()->back();
        }
        $user->save();

        flash()->addSuccess('You have successfully update your domain!');

        return back();
    }

    public function update_webhook(Request $request, User $user)
    {
        abort_unless($user == $request->user(), 403);

        $user->webhook_url = $request->input('webhook_url');

        $v = validator($user->toArray(), [
            'webhook_url' => ['nullable', 'url', new ValidDiscordWebhookRule],
        ]);

        if ($v->fails()) {
            flash()->addError('Webbook must be valid!');

            return redirect()->back();
        }

        $user->save();

        flash()->addSuccess('You have successfully update your Discord Webhook URL!');

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
            flash()->addError('Image must be filled!');

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
            flash()->addError('Your avatar is too large, max file size: 2 MB');

            return back();
        }

        $user->avatar = 'storage/avatars/'.$avatarName;
        $user->save();

        flash()->addSuccess('You have successfully upload avatar.');

        return back();
    }

    public function gallery(Request $request, $username)
    {
        $user = User::where('username', '=', $username)->firstOrFail();

        abort_unless($user == $request->user(), 403);

        return view('user.gallery', [
            'user' => $user,
        ]);
    }

    public function albums(Request $request, $username)
    {
        $user = User::where('username', '=', $username)->firstOrFail();

        abort_unless($user == $request->user(), 403);

        return view('user.albums', [
            'user' => $user,
        ]);
    }
}
