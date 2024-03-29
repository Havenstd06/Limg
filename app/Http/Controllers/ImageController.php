<?php

namespace App\Http\Controllers;

use App\Album;
use App\Http\Services\ImageIsPublic;
use App\Image;
use App\Rules\ValidImageUrlRule;
use App\User;
use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;
use File;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as InterImage;

class ImageController extends Controller
{
    /**
     * Show the home page.
     *
     * @return Renderable
     */
    public function main()
    {
        return view('image.main');
    }

    public function upload(Request $request)
    {
        $rules = [
            'image' => 'required | mimes:jpeg,jpg,png,svg,gif,bmp,tiff,wepb | max:15000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->addError($validator->errors());

            return back();
        }

        $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);

        $pageName = Str::random(6);
        $imageName = Str::random(6);

        $newFullName = $imageName.'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(('storage/images'), $newFullName);

        $image = new Image;
        $this->createImage($user, $image, $pageName, $imageName, $newFullName);

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
            flash()->addError('Maximum 10 URL!');

            return back();
        }

        foreach ($textAr as $key => $newValue) {
            $rules['url'] = new ValidImageUrlRule($newValue);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->addError('Incorrect URL!');

            return back();
        }

        foreach ($textAr as $line) {
            $client = new \GuzzleHttp\Client();
            $res = $client->get($line);
            $content = (string) $res->getBody();
            $extension = (string) Str::of($res->getHeaderLine('content-type'))->replace('image/', '');

            $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);
            $pageName = Str::random(6);
            $imageName = Str::random(6);
            $newFullName = $imageName.'.'.$extension;
            Storage::put('public/images/'.$newFullName, $content);

            $image = new Image;
            $this->createImage($user, $image, $pageName, $imageName, $newFullName);
        }

        flash()->addSuccess('You have successfully upload image via URL! Go to your profile to see them!');

        return back();
    }

    public function get(Request $request, $image)
    {
        if (strpos($image, '.')) { // Afficher la page avec l'extension
            $imageLink = Image::where('path', '/i/'.$image)->firstOrFail();

            return response()->download($imageLink->fullpath, null, [], null);
        } else { // Afficher le view image
            $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);

            $imagePath = Image::where('pageName', $image)
                ->orWhere('imageName', $image)
                ->firstOrFail();

            if ($imagePath->imageName === $image) {
                return redirect()->route('image.show', ['image' => $imagePath->pageName]);
            }

            $userAlbums = Album::where('user_id', '=', $user->id)->get();

            return view('image.show', [
                'user'   => $user,
                'image'  => $imagePath,
                'albums' => $userAlbums,
            ]);
        }
    }

    public function infos(Request $request, Image $image)
    {
        $user = $request->user();
        abort_unless(Auth::check() && ($user->id == $image->user->id || $user->role == 1), 403);

        $rules = [
            'title' => 'max:50',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->addError('The title must contain maximum 50 characters!');

            return back();
        }

        $image->title = $request->input('title');
        $image->is_public = $request->input('is_public');
        $image->save();

        flash()->addSuccess('You have successfully updated your image!');

        return redirect(route('image.show', ['image' => $image->pageName]));
    }

    public function delete(Request $request, Image $image)
    {
        $user = $request->user();
        abort_unless(Auth::check() && ($user->id == $image->user->id || $user->role == 1), 403);

        if (File::exists($image->fullpath)) {
            File::delete($image->fullpath);

            try {
                $image->delete();
            } catch (\Exception $e) {
            }
        }
        flash()->addSuccess('You have successfully delete your image!');

        return redirect(route('user.profile', ['user' => $user->username]));
    }

    public function add_to_album(Request $request, Image $image)
    {
        $user = $request->user();

        $selectValue = $request->input('album');
        $album = Album::where('id', '=', $selectValue)->first();

        abort_unless(Auth::check() && $user->id == $album->user->id, 403);

        if ($album->images()->where('image_id', $image->id)->exists()) {
            flash()->addError('This image is already on the selected album!');

            return back();
        }

        $image->album()->attach($selectValue);

        flash()->addSuccess('You have successfully add this image to your album!');

        return redirect()->route('album.show', ['album' => $album->slug]);
    }

    public function like(Request $request, Image $image)
    {
        $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);

        $image->like($user->id);

        flash()->addSuccess('You have successfully like this image!');

        return redirect()->back();
    }

    public function unlike(Request $request, Image $image)
    {
        $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);

        $image->unlike($user->id);

        flash()->addSuccess('You have successfully unlike this image!');

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

        $cacheName = 'resized-'.Str::of($imageLink->imageName)->slug().'-'.$size;

        return Cache::remember($cacheName, now()->addMinutes(5), function () use ($imageSize, $imageLink) {
            return $imageSize->response($imageLink->extension, '80');
        });
    }

    public function createImage(User $user, $image, $pageName, $imageName, $newFullName)
    {
        $is_public = new ImageIsPublic($user, $isApi = 0);

        $image->pageName = $pageName;
        $image->imageName = $imageName;
        $image->extension = pathinfo($newFullName, PATHINFO_EXTENSION);
        $image->path = '/i/'.$newFullName;
        $image->user_id = $user->id;
        $image->is_public = $is_public->imageState();
        $image->save();

        $this->sendWebhook($user, $image);
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
