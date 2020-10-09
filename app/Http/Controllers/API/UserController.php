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
     * Return user private image.
     *
     * @param Request $request
     * @param $username
     * @return JsonResponse
     */
    public function all(Request $request, $username)
    {
        $key = $request->header('Authorization');
        $user = User::where('username', $username)
            ->with('images')
            ->first();

        if ($key) { // If header "Authorization"
            $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
            if (in_array($key, $keys) && $user->api_token != $key) {
                return response()->json([
                    'success' => false,
                    'error'   => 'The given key is not the same as the requested user!',
                ], 403);
            }

            $all_image = $user->images()
                ->with('user')
                ->orderBy('created_at', 'DESC')
                ->jsonPaginate(10);

            return response()->json([
                'images'  => $all_image,
                'success' => true,
                'status'  => 200,
            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        return response()->json([
            'success' => false,
            'error'   => 'Please enter the API key for user '.$user->username,
        ], 401);
    }

    /**
     * Return user discover image.
     *
     * @param Request $request
     * @param $username
     * @return JsonResponse
     */
    public function discover(Request $request, $username)
    {
        $user = User::where('username', $username)
            ->with('images')
            ->first();

        $discover_images = $user->images()
            ->where('is_public', ImageStateType::Discover)
            ->orderBy('created_at', 'DESC')
            ->jsonPaginate(10);

        return response()->json([
            'images'  => $discover_images,
            'success' => true,
            'status'  => 200,
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Return user public image.
     *
     * @param Request $request
     * @param $username
     * @return JsonResponse
     */
    public function public(Request $request, $username)
    {
        $key = $request->header('Authorization');
        $user = User::where('username', $username)
            ->with('images')
            ->first();

        if ($key) { // If private
            $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
            if (in_array($key, $keys) && $user->api_token != $key) {
                return response()->json([
                    'success' => false,
                    'error'   => 'The given key is not the same as the requested user!',
                ], 403);
            }

            $public_image = $user->images()
                ->where('is_public', ImageStateType::Public)
                ->with('user')
                ->orderBy('created_at', 'DESC')
                ->jsonPaginate(10);

            return response()->json([
                'images'  => $public_image,
                'success' => true,
                'status'  => 200,
            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        return response()->json([
            'success' => false,
            'error'   => 'Please enter the API key for user '.$user->username,
        ], 401);
    }

    /**
     * Return user private image.
     *
     * @param Request $request
     * @param $username
     * @return JsonResponse
     */
    public function private(Request $request, $username)
    {
        $key = $request->header('Authorization');
        $user = User::where('username', $username)
            ->with('images')
            ->first();

        if ($key) { // If private
            $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
            if (in_array($key, $keys) && $user->api_token != $key) {
                return response()->json([
                    'success' => false,
                    'error'   => 'The given key is not the same as the requested user!',
                ], 403);
            }

            $private_image = $user->images()
                ->where('is_public', ImageStateType::Private)
                ->with('user')
                ->orderBy('created_at', 'DESC')
                ->jsonPaginate(10);

            return response()->json([
                'images'  => $private_image,
                'success' => true,
                'status'  => 200,
            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        return response()->json([
            'success' => false,
            'error'   => 'Please enter the API key for user '.$user->username,
        ], 401);
    }

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

        $user_data = [
            'username'      => $user->username,
            'description'   => $user->description,
            'role'          => $user->role,
            'avatar'        => $user->avatar,
        ];

        if ($key) { // If private
            $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
            if (! in_array($key, $keys) && $user->api_token != $key) {
                return response()->json([
                    'success' => false,
                    'error'   => 'The given key is not the same as the requested user!',
                ], 403);
            }

            $user_private_stats = [
                'image' => [
                    'all'        => $user->images()->count(),
                    'discover'   => $user->images()->where('is_public', ImageStateType::Discover)->count(),
                    'public'     => $user->images()->where('is_public', ImageStateType::Public)->count(),
                    'private'    => $user->images()->where('is_public', ImageStateType::Private)->count(),
                ],
                'album' => [
                    'all'        => $user->albums()->count(),
                    'public'     => $user->albums()->where('is_public', 1)->count(),
                    'private'    => $user->albums()->where('is_public', 0)->count(),
                ],
            ];

            $user_private_data = [
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
                'stats' => $user_private_stats,
                'data'  => $user_private_data,
            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        } else { // Public
            return response()->json([
                'stats' => $user_stats,
                'info'  => $user_data,
            ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }
    }
}
