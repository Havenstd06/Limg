<?php

namespace App\Http\Controllers\API;

use App\Enums\ImageStateType;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Return site stats.
     *
     * @param Request $request
     * @param $username
     * @return array|JsonResponse
     */
    public function user(Request $request, $username)
    {
        $key = $request->header('Authorization');
        $user = User::where('username', $username)
            ->with('images')
            ->first();

        $user_stats = [
            'discover_images_count' => $user->images()->where('is_public', ImageStateType::Discover)->count(),
            'public_images_count'   => $user->images()->where('is_public', ImageStateType::Public)->count(),
            'public_albums_count'   => $user->albums()->where('is_public', 1)->count(),
        ];

        $user_info = [
            'username'      => $user->username,
            'description'   => $user->description,
            'role'          => $user->role,
            'avatar'        => $user->avatar,
        ];

        if ($key) { // If private
            $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
            if (! in_array($key, $keys)) {
                if ($user->api_token != $key) {
                    return response()->json([
                        'success' => false,
                        'error'   => 'The given key is not the same as the requested user!',
                    ], 403);
                }
            }

            $user_private_stats = [
                'image' => [
                    'all'   => $user->images()->count(),
                    'discover'   => $user->images()->where('is_public', ImageStateType::Discover)->count(),
                    'public'     => $user->images()->where('is_public', ImageStateType::Public)->count(),
                    'private'    => $user->images()->where('is_public', ImageStateType::Private)->count(),
                ],
                'album' => [
                    'all'   => $user->albums()->count(),
                    'public'     => $user->albums()->where('is_public', 1)->count(),
                    'private'    => $user->albums()->where('is_public', 0)->count(),
                ],
            ];

            $user_private_info = [
                'username'             => $user->username,
                'description'          => $user->description,
                'role'                 => $user->role,
                'avatar'               => $user->avatar,
                'email'                => $user->email,
                'domain'               => $user->domain,
                'discord_webhook_url'  => $user->webhook_url,
                'dark_theme'           => $user->style,
                'always_public'        => $user->always_public,
            ];

            return response()->json([
                "stats" => $user_private_stats,
                "info"  => $user_private_info,
                //                "images" => [
                //                    "discover" => $discover_images,
                //                    "public" => $public_images,
                //                    "private" => $private_images,
                //                    ],
            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        } else { // Public
            return response()->json([
                "stats" => $user_stats,
                "info"  => $user_info,
                //                "images" => [
                //                    "discover" => $discover_images
                //                ],
            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }
    }

//    /**
//     * Return site stats.
//     *
//     * @param Request $request
//     * @param $username
//     * @return JsonResponse
//     */
//    public function user(Request $request, $username)
//    {
//        $data = [];
//
//        $user = User::where('username', $username)->with('images')->first();
//        $private_key = key($request->query());
//
//        if (! $user) {
//            return response()->json([
//                'success' => false,
//                'error'   => 'User not found!',
//            ], 404);
//        }
//
//        $public_stats = [
//            'images_count' => $user->images()->where('is_public', 1)->count(),
//            'albums_count' => $user->albums()->where('is_public', 1)->count(),
//        ];
//
////        $public_info = $user->where('username', $username);
//
//        $public_info = [
//            'username'      => $user->username,
//            'description'   => $user->description,
//            'role'          => $user->role,
//            'avatar'        => config('app.url').'/'.$user->avatar,
//        ];
//
//        $discover_images = $user->images()
//            ->where('is_public', ImageStateType::Discover)
//            ->orderBy('created_at', 'DESC')
//            ->jsonPaginate(100);
//
//        if ($private_key == null) {
//            return response()->json([
//                $data['public_stats'] = $public_stats,
//                $data['public_info'] = $public_info,
//                $data['discover_images'] = $discover_images,
//            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
//        }
//
//        $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
//        if (in_array($private_key, $keys)) {
//            if ($user->api_token != $private_key) {
//                return response()->json([
//                    'success' => false,
//                    'error'   => 'The given key is not the same as the requested user!',
//                ], 403);
//            }
//
//            $images = [
//                'all'     => $user->images->count(),
//                'public'  => $user->images()->where('is_public', 1)->count(),
//                'private' => $user->images()->where('is_public', 0)->count(),
//            ];
//
//            $albums = [
//                'all'     => $user->albums->count(),
//                'public'  => $user->albums()->where('is_public', 1)->count(),
//                'private' => $user->albums()->where('is_public', 0)->count(),
//            ];
//
//            $private_info = [
//                'email'               => $user->email,
//                'domain'              => $user->domain,
//                'discord_webhook_url' => $user->webhook_url,
//                'dark_theme'          => $user->style,
//                'always_public'       => $user->always_public,
//            ];
//
//            $private_images = $user->images()->where('is_public', 0)->orderBy('created_at', 'DESC')->get();
//            $all_images = $user->images()->orderBy('created_at', 'DESC')->get();
//
//            return response()->json([
//                $data['public_stats'] = $public_stats,
//                $data['private_stats']['images_count'] = $images,
//                $data['private_stats']['albums_count'] = $albums,
//                $data['public_info'] = $public_info,
//                $data['private_info'] = $private_info,
//                $data['all_images'] = $all_images,
//                $data['private_images'] = $private_images,
//            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
//        } else {
//            return response()->json([
//                'success' => false,
//                'error'   => 'Invalid key!',
//            ], 401);
//        }
//
//        return $data;
//    }
}
