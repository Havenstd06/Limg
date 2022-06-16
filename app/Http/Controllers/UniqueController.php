<?php

namespace App\Http\Controllers;

use App\Unique;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as InterImage;

class UniqueController extends Controller
{
    public function show(Request $request, $unique)
    {
        if (strpos($unique, '.')) { // Afficher la page avec l'extension
            $uniqueLink = Unique::where('path', '/u/'.$unique)->firstOrFail();

            return response()->download($uniqueLink->fullpath, null, [], null);
        } else {
            $user = (auth()->user()) ? auth()->user() : User::findOrFail(1);
            $uniqueLink = Unique::where('name', $unique)
                ->orWhere('shareName', $unique)
                ->firstOrFail();

            if ($unique === $uniqueLink->shareName) {
                return redirect()->route('unique.show', ['unique' => $uniqueLink->fullname]);
            }

            return view('unique.show', [
                'user'   => $user,
                'unique' => $uniqueLink,
            ]);
        }
    }

    public function upload(Request $request)
    {
        $rules = [
            'image' => 'required | mimes:jpeg,jpg,png,gif | max:15000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->addError($validator->errors());

            return back();
        }

        $user = auth()->user();

        $name = Str::random(6);

        $newFullName = $name.'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(('storage/uniques'), $newFullName);

        $unique = new Unique;
        $unique->name = $name;
        $unique->shareName = Str::random(6);
        $unique->extension = pathinfo($newFullName, PATHINFO_EXTENSION);
        $unique->path = '/u/'.$newFullName;
        $unique->user_id = $user->id;
        $unique->save();

        return route('unique.show', ['unique' => $unique->name]);
    }

    public function download(Unique $unique)
    {
        return ($unique->title) ? response()->download($unique->fullpath, Str::slug($unique->title, '-').'.'.$unique->extension) : response()->download($unique->fullpath);
    }

    public function infos(Request $request, Unique $unique)
    {
        $user = $request->user();
        abort_unless(Auth::check() && ($user->id == $unique->user->id || $user->role == 1), 403);

        $rules = [
            'title' => 'max:50',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->addError('The title must contain maximum 50 characters!');

            return back();
        }

        $unique->title = $request->input('title');
        $unique->save();

        flash()->addSuccess('You have successfully updated your image!');

        return redirect(route('unique.show', ['unique' => $unique->name]));
    }

    public function build($unique, $size)
    {
        $uniqueLink = Unique::where('path', '/u/'.$unique)->firstOrFail();

        $w = InterImage::make($uniqueLink->fullpath)->width();
        $h = InterImage::make($uniqueLink->fullpath)->height();

        if ($w > $h) {
            $imageSize = InterImage::make($uniqueLink->fullpath)->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else {
            $imageSize = InterImage::make($uniqueLink->fullpath)->resize(null, $size, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $cacheName = 'resized-'.Str::of($uniqueLink->name)->slug().'-'.$size;

        return Cache::remember($cacheName, now()->addMinutes(5), function () use ($imageSize, $uniqueLink) {
            return $imageSize->response($uniqueLink->extension, '80');
        });
    }
}
