<?php

namespace App\Http\Controllers;

use App\Album;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function main()
    {
        return view('album.main');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('album.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        return view('album.show', [
            'album' => $album,
        ]);
    }

    public function infos(Request $request, Album $album)
    {
        $user = $request->user();
        abort_unless(Auth::check() && ($user->id == $album->user->id || $user->role == 1), 403);

        $rules = [
            'name' => 'max:50',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash()->addError('The name must contain maximum 50 characters!');

            return back();
        }

        $album->name = $request->input('name');
        $album->is_public = $request->has('is_public');
        $album->save();

        flash()->addSuccess('You have successfully updated your image!');

        return redirect(route('album.show', ['album' => $album->slug]));
    }

    public function delete(Request $request, Album $album)
    {
        $user = $request->user();
        abort_unless(Auth::check() && ($user->id == $album->user->id || $user->role == 1), 403);

        $album->images()->detach();
        $album->delete();

        flash()->addSuccess('You have successfully delete your album!');

        return redirect()->route('album.main');
    }

    public function remove(Request $request, Album $album, Image $image)
    {
        $user = $request->user();
        abort_unless(Auth::check() && ($user->id == $album->user->id || $user->role == 1), 403);

        if ($album->images()->count() == 1) {
            Session::flash('error', 'You must have at least 1 image in your album.');
        } else {
            $album->images()->detach($image);

            flash()->addSuccess('You have successfully remove this image from this album!');
        }

        return redirect()->back();
    }
}
