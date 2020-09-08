<?php

namespace App\Http\Livewire;

use App\Album;
use App\Image;
use App\Rules\ArrayAtLeastOneRequired;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class CreateAlbum extends Component
{
    use WithPagination;

    public $name;
    public $selectedImage = [];
    public $search = '';
    public $perPage = 28;
    public $field = 'id';
    public $asc = false;

    protected $updatesQueryString = [
        'search' => ['except' => ''],
        'field'  => ['except' => 'id'],
        'asc'    => ['except' => false],
        'page'   => ['except' => 1],
    ];

    public function mount()
    {
        $this->fill([
            'search'  => request()->query('search', $this->search),
            'perPage' => request()->query('perPage', $this->perPage),
            'field'   => request()->query('field', $this->field),
            'asc'     => request()->query('asc') ? false : true,
        ]);
        $this->sortBy($this->field);
    }

    public function resetTable()
    {
        $this->fill([
            'search'  => '',
            'perPage' => 32,
            'field'   => 'id',
            'asc'     => false,
        ]);
    }

    public function paginationView()
    {
        return 'vendor.pagination.default';
    }

    /**
     * Paginate collection.
     *
     * @param array|Collection $items
     * @param int $perPage
     * @param int $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 28, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    private function getAllImages(): Collection
    {
        $base = Image::search(
            $this->search,
            auth()->user()
        )->get()->where('is_public', '=', '1');
        if (! empty(trim($this->search))) {
            $this->page = 1;
        }
        $sorted = $this->asc ? $base->sortBy($this->field) : $base->sortByDesc($this->field);
        if (! empty(trim($this->search))) {
            $this->page = 1;
        }

        return $sorted;
    }

    public function sortBy($field)
    {
        if ($this->field === $field) {
            $this->asc = ! $this->asc;
        } else {
            $this->asc = true;
        }

        $this->field = $field;
        $this->page = 1;
    }

    public function getSelectedOptionsProperty()
    {
        return array_keys(array_filter($this->selectedImage));
    }

    public function create()
    {
        $result = array_keys(array_filter($this->selectedImage));

        $this->validate([
            'name'            => 'required|min:1|max:70',
            'selectedImage'   => 'required',
            'selectedImage.*' => [new ArrayAtLeastOneRequired($result)],
        ]);

        $album = new Album();
        $album->name = $this->name;
        $album->slug = Str::random(6);
        $album->user_id = auth()->user()->id;
        $album->save();

        $album->images()->attach($result);

        notify()->success('Album successfully created!');

        return redirect()->route('album.show', ['album' => $album->slug]);
    }

    public function render()
    {
        abort_unless(Auth::check(), 403);

        $images = $this->paginate($this->getAllImages(), $this->perPage);

        return view('livewire.create-album', ['images' => $images]);
    }
}
