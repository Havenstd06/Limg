<?php

namespace App\Http\Controllers;

use App\Album;
use App\Image;
use App\Rules\ValidImageUrlRule;
use App\User;
use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as InterImage;
use Nubs\RandomNameGenerator\Alliteration;
use Nubs\RandomNameGenerator\Vgng;

class ImageController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function main()
    {
        return view('image.main');
    }

    public function upload(Request $request)
    {
        $rules = [
            'image' => 'required | mimes:jpeg,jpg,png,svg,gif,bmp,tiff | max:15000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            notify()->error('Image format must be jpeg, jpg, png, svg, gif, bmp, tiff!');

            return back();
        }

        $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);

        $pageName = (string) Str::of(new Vgng().'-'.Str::random(6))
        ->replace('\'', '')
        ->replace('.', '')
        ->replace('/', '')
        ->replace('\\', '')
        ->replace(' ', '');

        $imageName = (string) Str::of(new Alliteration().'-'.new Vgng().'-'.Str::random(6))
        ->replace('\'', '')
        ->replace('.', '')
        ->replace('/', '')
        ->replace('\\', '')
        ->replace(' ', '');

        $newFullName = $imageName.'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(('storage/images'), $newFullName);

        $image = new Image;
        $image->pageName = $pageName;
        $image->imageName = $imageName;
        $image->extension = pathinfo($newFullName, PATHINFO_EXTENSION);
        $image->path = '/i/'.$newFullName;
        $image->user_id = $user->id;
        $image->is_public = (! $user->always_public) ? 0 || (! Auth::check() || $user->always_public) : 1;
        $image->save();

        $this->sendWebhook($user, $image);

        return route('image.show', ['image' => $image->pageName]);
    }

    public function url_upload(Request $request)
    {
        $text = $_POST['url'];
        $textAr = explode("\n", str_replace("\r", '', $text));
        $textAr = array_filter($textAr, 'trim');

        $rules = [
            'url' => 'required',
        ];

        if (count($textAr) >= 10) {
            notify()->error('Maximum 10 URL!');

            return back();
        }

        foreach ($textAr as $key => $newValue) {
            $rules['url'] = new ValidImageUrlRule($newValue);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            notify()->error('Incorrect URL!');

            return back();
        }

        foreach ($textAr as $line) {
            $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);

            $client = new \GuzzleHttp\Client();
            $res = $client->get($line);
            $content = (string) $res->getBody();
            $extension = (string) Str::of($res->getHeaderLine('content-type'))->replace('image/', '');

            $pageName = (string) Str::of(new Vgng().'-'.Str::random(6))
            ->replace('\'', '')
            ->replace('.', '')
            ->replace('/', '')
            ->replace('\\', '')
            ->replace(' ', '');

            $imageName = (string) Str::of(new Alliteration().'-'.new Vgng().'-'.Str::random(6))
            ->replace('\'', '')
            ->replace('.', '')
            ->replace('/', '')
            ->replace('\\', '')
            ->replace(' ', '');

            $newFullName = $imageName.'.'.$extension;
            Storage::put('public/images/'.$newFullName, $content);

            $image = new Image;
            $image->pageName = $pageName;
            $image->imageName = $imageName;
            $image->extension = $extension;
            $image->path = '/i/'.$newFullName;
            $image->user_id = $user->id;
            $image->is_public = ! Auth::check() == 1 || $request->has('is_public');
            $image->save();

            $this->sendWebhook($user, $image);
        }

        notify()->success('You have successfully upload image via URL!');

        return back();
    }

    public function api_upload(Request $request)
    {
        $file = $request->file('file');
        $upload_key = $request->key;

        if ($file == null) {
            return response()->json([
                'success' => false,
                'image' => [],
                'error' => 'Please give a file to upload.',
            ], 500);
        } elseif ($upload_key == null) {
            return response()->json([
                'success' => false,
                'image' => [],
                'error' => 'Please give a api key to validate.',
            ], 500);
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
                    'image' => [],
                    'error' => 'File must be Image.',
                ], 500);
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

                    $imageName = (string) Str::of(new Alliteration().'-'.new Vgng().'-'.Str::random(6))
                    ->replace('\'', '')
                    ->replace('.', '')
                    ->replace('/', '')
                    ->replace('\\', '')
                    ->replace(' ', '-');

                    $imageFullName = $imageName.'.'.$file->getClientOriginalExtension();
                    $file->move(('storage/images'), $imageFullName);

                    $image = new Image;
                    $image->pageName = $pageName;
                    $image->imageName = $imageName;
                    $image->extension = pathinfo($imageFullName, PATHINFO_EXTENSION);
                    $image->path = '/i/'.$imageFullName;
                    $image->user_id = $user->id;
                    $image->is_public = 0;
                    $image->save();

                    $this->sendWebhook($user, $image);

                    return response()->json([
                        'success' => true,
                        'image' => [
                            'url' => $user->domain.$image->path,
                            'delete_url' => route('image.delete', ['image' => $image->pageName]),
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
    }

    public function get(Request $request, $image)
    {
        if (strpos($image, '.') !== false) { // Afficher la page avec l'extension
            $imageLink = Image::where('path', '/i/'.$image)->firstOrFail();

            return response()->download($imageLink->fullpath, null, [], null);
        } else { // Afficher le view image

            $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);
            $pageImage = Image::where('pageName', pathinfo($image, PATHINFO_FILENAME))->firstOrFail();

            $userAlbums = Album::where('user_id', '=', $user->id)->get();

            return view('image.show', [
                'user' => $user,
                'image' => $pageImage,
                'albums' => $userAlbums,
            ]);
        }
    }

    public function infos(Request $request, Image $image)
    {
        $user = $request->user();
        abort_unless(Auth::check() && $user->id == $image->user->id, 403);

        $rules = [
            'title' => 'max:50',
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

        return redirect(route('image.show', ['image' => $image->pageName]));
    }

    public function delete(Request $request, Image $image)
    {
        $user = $request->user();
        abort_unless(Auth::check() && $user->id == $image->user->id, 403);

        if (File::exists($image->fullpath)) {
            File::delete($image->fullpath);
            $image->delete();
        }
        notify()->success('You have successfully delete your image!');

        return redirect()->route('home');
    }

    public function add_to_album(Request $request, Image $image)
    {
        $user = $request->user();

        $selectValue = $request->input('album');
        $album = Album::where('id', '=', $selectValue)->first();

        abort_unless(Auth::check() && $user->id == $album->user->id, 403);

        if ($album->images()->where('image_id', $image->id)->exists()) {
            notify()->error('This image is already on the selected album!');

            return back();
        }

        $image->album()->attach($selectValue);

        notify()->success('You have successfully add this image to your album!');

        return redirect()->route('album.show', ['album' => $album->slug]);
    }

    public function like(Request $request, Image $image)
    {
        $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);

        $image->like($user->id);

        notify()->success('You have successfully like this image!');

        return redirect()->back();
    }

    public function unlike(Request $request, Image $image)
    {
        $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);

        $image->unlike($user->id);

        notify()->success('You have successfully unlike this image!');

        return redirect()->back();
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

    private function sendWebhook(User $user, Image $image): void
    {
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
    }
}
