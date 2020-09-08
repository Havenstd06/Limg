<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Album;
use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatsController extends Controller
{
    /**
     * Return global site stats.
     *
     * @return \Illuminate\Http\Response
     */
    public function global()
    {
        $data = [];

        $stats = [
            'images' => Image::count(),
            'albums' => Album::count(),
            'users' => User::count(),
        ];

        $data['global'] = $stats;

        return $data;
    }

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

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'User not found!',
            ], 404);
        }

        $public_stats = [
            'images_count' => $user->images->where('is_public', 1)->count(),
            'albums_count' => $user->albums()->where('is_public', 1)->count()
        ];

        $public_info = [
            'username' => $user->username,
            'description' => $user->description,
            'role' => $user->role,
            'avatar' => config('app.url').'/'.$user->avatar,
            'public_images' => $user->images()->where('is_public', 1)->orderBy('created_at', 'DESC')->get(),
        ];
        $data['public_stats'] = $public_stats;
        $data['public_info'] = $public_info;

        if ($private_key == null) {
            return $data;
        }
        
        $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
        if (in_array($private_key, $keys)) {
            if ($user->api_token != $private_key) {
                return response()->json([
                    'success' => false,
                    'error' => 'The given key is not the same as the requested user!',
                ], 403);
            }

            $private_stats = [
                'all_images_count' => $user->images->count(),
                'public_images_count' => $user->images()->where('is_public', 1)->count(),
                'private_images_count' => $user->images()->where('is_public', 0)->count(),
                'all_albums_count' => $user->albums->count(),
                'public_albums_count' => $user->albums()->where('is_public', 1)->count(),
                'private_albums_count' => $user->albums()->where('is_public', 0)->count()
            ];

            $private_info = [
                'email' => $user->email,
                'domain' => $user->domain,
                'discord_webhook_url' => $user->webhook_url,
                'dark_theme' => $user->style,
                'always_public' => $user->always_public,
                'short_link' => $user->short_link,
                'private_images' => $user->images()->where('is_public', 0)->orderBy('created_at', 'DESC')->get(),
                'all_images' => $user->images()->orderBy('created_at', 'DESC')->get()
            ];

            $data['private_stats'] = $private_stats;
            $data['private_info'] = $private_info;
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Invalid key!',
            ], 401);
        }

        return $data;
    }
}
