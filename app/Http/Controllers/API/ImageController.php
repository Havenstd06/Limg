<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\DiscordWebhook;
use App\Http\Services\ImageIsPublic;
use App\Image;
use App\User;
use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Private image (required api key).
     *
     * @return string
     */
    public function public(Request $request)
    {
        $images = Image::where('is_public', 1)->orderBy('created_at', 'DESC')->get();

        return $images->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        $key = $request->header('Authorization');
        $file = $request->file('file');
        $data = $request->all('title');

        if (! $key) {
            return response()->json([
                'success' => false,
                'error'   => 'Please give a key file to upload.',
            ], 401);
        }

        $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
        if (! in_array($key, $keys)) {
            return response()->json([
                'success'    => false,
                'error'      => 'Invalid key!',
            ], 401);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'max:50', //  max 100mb
                'file'  => 'mimes:jpeg,jpg,png,svg,gif,bmp,tiff,mp4,mov,ogg,qt | required | max:200000', //  max 200mb
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error'   => $validator->errors(),
            ], 401);
        }

        $user = User::where('api_token', '=', $key)->first();

        $page_name = Str::random(6);
        $image_name = Str::random(6);
        $extension = $file->getClientOriginalExtension();

        $new_name = $image_name.'.'.$extension;
        $file->move(('storage/images'), $new_name);

        $is_public = new ImageIsPublic($user, $isApi = 1);

        $image = new Image;
        $image->title = $data['title'];
        $image->pageName = $page_name;
        $image->imageName = $image_name;
        $image->extension = $extension;
        $image->path = '/i/'.$new_name;
        $image->user_id = $user->id;
        $image->is_public = $is_public->imageState();
        $image->save();

        if ($user->webhook_url) {
            $DiscordWebhook = new DiscordWebhook($user, $image);
            $DiscordWebhook->sendWebhook();
        }

        return response()->json([
            'data' => [
                'title'        => $image->title,
                'datetime'     => date('U'),
                'type'         => $file->getClientMimeType(),
                'account_id'   => $user->id,
                'account_name' => $user->username,
                'image_state'  => $image->is_public,
                'delete'       => route('apiv2_image_delete', ['pageName' => $image->pageName]),
                'page'         => route('image.show', ['image' => $image->pageName]),
                'link'         => $user->domain.$image->path,
            ],
            'success' => true,
            'status'  => 200,
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Delete specific image (api_token is required).
     *
     * @param Request $request
     * @param $pageName
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Request $request, $pageName)
    {
        $key = $request->header('Authorization');
        $image = Image::where('pageName', $pageName)->firstOrFail();

        if (! $key) {
            return response()->json([
                'success' => false,
                'error'   => 'Private image, if you own the image please give your api key to validate.',
            ], 401);
        }

        $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
        if (! in_array($key, $keys)) {
            return response()->json([
                'success'    => false,
                'error'      => 'Invalid key!',
            ], 401);
        }

        $user = User::where('id', $image->user_id)->first();
        if ($key != $user->api_token) {
            return response()->json([
                'success' => false,
                'error'   => 'It is not your image!',
            ], 403);
        }

        if (File::exists($image->fullpath)) {
            File::delete($image->fullpath);
            $image->delete();
        }

        return response()->json([
            'success' => true,
            'info'    => 'Image deleted!',
        ], 200);
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
