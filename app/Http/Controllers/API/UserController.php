<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Return site stats.
     *
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request, $username)
    {
        $data = [];

        $user = User::where('username', $username)->with('images')->first();
        $private_key = key($request->query());

        if (! $user) {
            return response()->json([
                'success' => false,
                'error'   => 'User not found!',
            ], 404);
        }

        $public_stats = [
            'images_count' => $user->images()->where('is_public', 1)->count(),
            'albums_count' => $user->albums()->where('is_public', 1)->count(),
        ];

        $public_info = [
            'username'      => $user->username,
            'description'   => $user->description,
            'role'          => $user->role,
            'avatar'        => config('app.url').'/'.$user->avatar,
        ];

        $public_images = $user->images()->where('is_public', 1)->orderBy('created_at', 'DESC')->get();

        if ($private_key == null) {
            $data['public_stats'] = $public_stats;
            $data['public_info'] = $public_info;
            $data['public_images'] = $public_images;

            return $data;
        }

        $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
        if (in_array($private_key, $keys)) {
            if ($user->api_token != $private_key) {
                return response()->json([
                    'success' => false,
                    'error'   => 'The given key is not the same as the requested user!',
                ], 403);
            }

            $images = [
                'all'     => $user->images->count(),
                'public'  => $user->images()->where('is_public', 1)->count(),
                'private' => $user->images()->where('is_public', 0)->count(),
            ];

            $albums = [
                'all'     => $user->albums->count(),
                'public'  => $user->albums()->where('is_public', 1)->count(),
                'private' => $user->albums()->where('is_public', 0)->count(),
            ];

            $private_info = [
                'email'               => $user->email,
                'domain'              => $user->domain,
                'discord_webhook_url' => $user->webhook_url,
                'dark_theme'          => $user->style,
                'always_public'       => $user->always_public,
            ];

            $private_images = $user->images()->where('is_public', 0)->orderBy('created_at', 'DESC')->get();
            $all_images = $user->images()->orderBy('created_at', 'DESC')->get();

            $data['public_stats'] = $public_stats;
            $data['private_stats']['images_count'] = $images;
            $data['private_stats']['albums_count'] = $albums;
            $data['public_info'] = $public_info;
            $data['private_info'] = $private_info;
            $data['all_images'] = $all_images;
            $data['private_images'] = $private_images;
        } else {
            return response()->json([
                'success' => false,
                'error'   => 'Invalid key!',
            ], 401);
        }

        return $data;
    }
}
