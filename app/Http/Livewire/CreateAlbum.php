<?php

namespace App\Http\Livewire;

use App\Album;
use Livewire\Component;

class CreateAlbum extends Component
{
    public $name;
    // public $code;

    public function create()
    {
        $this->validate([
            'name'    => 'required|min:1|max:70',
            // 'code'     => 'required|min:1|max:10000',
        ]);

        $album = Album::create([
            'name'      => $this->name,
            'slug'      => str_replace(' ', '-', $this->name),
            // 'code'        => $this->code,
            'user_id'   => auth()->user()->id,
        ]);

        notify()->success('Album successfully created!');

        return redirect()->route('album.show', ['album' => $album->slug]);
    }

    public function render()
    {
        return view('livewire.create-album');
    }
}
