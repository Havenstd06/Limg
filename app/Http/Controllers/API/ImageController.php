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
use Nubs\RandomNameGenerator\Alliteration;
use Nubs\RandomNameGenerator\Vgng;

class ImageController extends Controller
{
    /**
     * Private image (required api key)
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
                'image'   => [],
                'error'   => 'Please give a file to upload.',
            ], 400);
        } elseif ($upload_key == null) {
            return response()->json([
                'success' => false,
                'image'   => [],
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
                    'image'   => [],
                    'error'   => 'File must be Image.',
                ], 422);
            } else {
                $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();

                if (in_array($upload_key, $keys)) {
                    $user = User::where('api_token', '=', $upload_key)->first();

                    $pageName = (string) Str::of(new Vgng().'-'.Str::random(6))
                    ->replace('\'', '')
                    ->replace('.', '')
                    ->replace('/', '')
                    ->replace('\\', '')
                    ->replace(' ', '-');

                    $tempImageName = 'temp-'.Str::random(6);

                    $image = new Image;
                    $image->pageName = $pageName;
                    $image->imageName = $tempImageName;
                    $image->extension = pathinfo($tempImageName, PATHINFO_EXTENSION);
                    $image->path = '/i/'.$tempImageName;
                    $image->user_id = $user->id;
                    $image->is_public = 0;
                    $image->save();

                    $finalImageName = $user->short_link == 0 ? (string) Str::of(new Alliteration().'-'.new
                    Vgng().'-'.Str::random(6))
                    ->replace('\'', '')
                    ->replace('.', '')
                    ->replace('/', '')
                    ->replace('\\', '')
                    ->replace(' ', '-') : $image->id.Str::random(3);

                    $finalimageFullName = $finalImageName.'.'.$file->getClientOriginalExtension();
                    $file->move(('storage/images'), $finalimageFullName);

                    $image->imageName = $finalImageName;
                    $image->extension = pathinfo($finalimageFullName, PATHINFO_EXTENSION);
                    $image->path = '/i/'."$finalimageFullName";
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
                        'screenshot' => [],
                        'error'      => 'Invalid key!',
                    ], 401);
                }
            }
        }
    }
    
    /**
     * Show specific image (api_token may required)
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
