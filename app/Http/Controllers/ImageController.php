<?php

namespace App\Http\Controllers;

use App\Image;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as InterImage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $rules = [
            'image' => 'required | mimes:jpeg,jpg,png,svg,gif,bmp,tiff',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            notify()->error('Image format must be jpeg, jpg, png, svg, gif, bmp, tiff!');

            return back();
        }

        $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);

        $newName = Str::random(7);
        $newFullName = $newName.'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(('storage/images'), $newFullName);

        $image = new Image;
        $image->name = $newName;
        $image->extension = pathinfo($newFullName, PATHINFO_EXTENSION);
        $image->path = '/i/'.$newFullName;
        $image->user_id = $user->id;
        $image->is_public = (! $user->always_public) ? 0 || (! Auth::check() || $user->always_public) : 1;
        $image->save();

        notify()->success('You have successfully upload image!');

        return redirect(route('image.show', ['image' => $image->name]));
    }

    public function api_upload(Request $request)
    {
        $storage = storage_path('app/public/images');
        $file = $request->file('file');
        $upload_key = $request->key;

        if($file == null) {
            return response()->json([
                'success' => false,
                'image' => [],
                'error' => 'Please give a file to upload.',
            ], 500);

        } elseif($upload_key == null) {
            return response()->json([
                'success' => false,
                'image' => [],
                'error' => 'Please give a api key to validate.',
            ], 500);

        } else {
            $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
            
            if(in_array($upload_key, $keys)) {

                $user = User::where('api_token', '=', $upload_key)->first();

                $newName = Str::random(7);
                $newFullName = $newName.'.'.$file->getClientOriginalExtension();
                $file->move(('storage/images'), $newFullName);

                $image = new Image;
                $image->name = $newName;
                $image->extension = pathinfo($newFullName, PATHINFO_EXTENSION);
                $image->path = '/i/'.$newFullName;
                $image->user_id = $user->id;
                $image->is_public = 0;
                $image->save();

                return response()->json([
                    'success' => true,
                    'image' => [
                        'url' => route('image.show', [
                            $image->name,
                        ]),
                        'delete_url' => 'Use the web UI please.',
                    ],
                    'error' => '',
                ]);
            
            } else {
                return response()->json([
                    'success' => false,
                    'screenshot' => [],
                    'error' => 'Invalid key!',
                ], 500);
            }
        }
    }

    public function api_get(Request $request, $name)
    {
        if($image = Image::where('name', '=', $name)->first()) {
            return view('image', compact('image'));
        } else {
            return view(route('home'));
        }
    }

    public function get($image)
    {
        if (strpos($image, '.') !== false) { // Afficher la page avec l'extension
            $imageLink = Image::where('path', '/i/'.$image)->firstOrFail();

            return response()->download($imageLink->fullpath, null, [], null);
        } else { // Afficher le view image

            $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);
            $pageImage = Image::where('name', pathinfo($image, PATHINFO_FILENAME))->firstOrFail();

            return view('image.image', [
                'user' => $user,
                'image' => $pageImage,
            ]);
        }
    }

    public function infos(Request $request, Image $image)
    {
        $user = $request->user();
        abort_unless(Auth::check() && $user->id == $image->user->id, 403);

        $rules = [
            'title'      => 'max:50',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            notify()->error('The title must contain maximum 50 characters!');

            return back();
        }

        $image->title = $request->input('title');
        $image->is_public = $request->has('is_public');
        $image->save();

        notify()->success('You have successfully updated your image!');

        return redirect(route('image.show', ['image' => $image->name]));
    }

    public function delete(Request $request, Image $image)
    {
        $user = $request->user();
        abort_unless(Auth::check() && $user->id == $image->user->id, 403);

        File::delete($image->fullpath);
        $image->delete();

        notify()->success('You have successfully delete your image !');

        return redirect(route('home'));
    }

    public function download(Image $image)
    {
        return ($image->title) ? response()->download($image->fullpath, Str::slug($image->title, '-').'.'.$image->extension) : response()->download($image->fullpath);
    }

    public function build($image, $size)
    {
        $imageLink = Image::where('path', '/i/'.$image)->firstOrFail();

        $w = InterImage::make($imageLink->fullpath)->width();
        $h = InterImage::make($imageLink->fullpath)->height();

        if ($w > $h) {
            $imageSize = InterImage::make($imageLink->fullpath)->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else {
            $imageSize = InterImage::make($imageLink->fullpath)->resize(null, $size, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        return $imageSize->response($imageLink->extension, '80');
    }
}
