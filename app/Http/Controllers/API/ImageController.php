<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Image;
use App\User;
use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Private image (required api key).
     *
     * @return \Illuminate\Http\Response
     */
    public function public(Request $request)
    {
        $images = Image::where('is_public', 1)->orderBy('created_at', 'DESC')->get();

        return $images->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $upload_key = $request->key;

        if ($file == null) {
            return response()->json([
                'success' => false,
                'error'   => 'Please give a file to upload.',
            ], 400);
        } elseif ($upload_key == null) {
            return response()->json([
                'success' => false,
                'error'   => 'Please give a api key to validate.',
            ], 401);
        } else {
            $postData = $request->only('file');
            $file = $postData['file'];

            $fileArray = ['image' => $file];

            $rules = [
                'image' => 'mimes:jpeg,jpg,png,svg,gif,bmp,tiff | required | max:30000', // max 30000kb
            ];
            $validator = Validator::make($fileArray, $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error'   => 'File must be Image.',
                ], 422);
            } else {
                $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();

                if (in_array($upload_key, $keys)) {
                    $user = User::where('api_token', '=', $upload_key)->first();

                    $pageName = Str::random(6);
                    $imageName = Str::random(6);

                    $newFullName = $imageName.'.'.$file->getClientOriginalExtension();
                    $file->move(('storage/images'), $newFullName);

                    $image = new Image;
                    $image->pageName = $pageName;
                    $image->imageName = $imageName;
                    $image->extension = pathinfo($newFullName, PATHINFO_EXTENSION);
                    $image->path = '/i/'.$newFullName;
                    $image->user_id = $user->id;
                    $image->is_public = (! $user->always_public) ? 0 || $user->always_public : 1;
                    $image->save();

                    if ($user->webhook_url) {
                        $webhook = new Client($user->webhook_url);
                        $embed = new Embed();

                        $embed->title('New image uploaded!', route('image.show', ['image' => $image]));
                        $embed->image(config('app.url').$image->path);
                        $embed->author($user->username, route('user.profile', ['user' => $user]), url($user->avatar));
                        $embed->footer(config('app.url'), config('app.url').'/images/favicon/favicon-32x32.png');
                        $embed->timestamp(date('c'));
                        $embed->color('7041F6');

                        $webhook->username(config('app.name'))->avatar(config('app.url').'/images/favicon/apple-touch-icon.png')->embed($embed)->send();
                    }

                    return response()->json([
                        'success' => true,
                        'image'   => [
                            'url' => $user->domain.$image->path,
                        ],
                        'error' => '',
                    ], 201);
                } else {
                    return response()->json([
                        'success'    => false,
                        'error'      => 'Invalid key!',
                    ], 401);
                }
            }
        }
    }

    /**
     * Show specific image (api_token may required).
     *
     * @param \App\Image $image
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $image = Image::where('id', $id)->firstOrFail();
        $private_key = key($request->query());

        if ($image->is_public == 0) { // Private
            if ($private_key == null) {
                return response()->json([
                    'success' => false,
                    'error'   => 'Private image, if you own the image please give your api key to validate.',
                ], 401);
            }

            $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
            if (in_array($private_key, $keys)) {
                $user = User::where('id', $image->user_id)->first();

                if ($private_key == $user->api_token) {
                    return $image;
                } else {
                    return response()->json([
                        'success' => false,
                        'error'   => 'It is not your image!',
                    ], 403);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'error'   => 'Invalid key!',
                ], 401);
            }
        } else {
            return $image;
        }
    }
}
