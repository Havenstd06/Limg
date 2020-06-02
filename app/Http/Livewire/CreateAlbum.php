<?php

namespace App\Http\Livewire;

use App\Album;
use App\Image;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class CreateAlbum extends Component
{
    use WithPagination;

    public $name;
    // public $code;
    public $search = '';
    public $perPage = 32;
    public $field = 'id';
    public $asc = false;

    protected $updatesQueryString = [
        'search' => ['except' => ''],
        'field' => ['except' => 'id'],
        'asc' => ['except' => false],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->fill([
            'search' => request()->query('search', $this->search),
            'perPage' => request()->query('perPage', $this->perPage),
            'field' => request()->query('field', $this->field),
            'asc' => request()->query('asc') ? false : true,
        ]);
        $this->sortBy($this->field);
    }

    public function resetTable()
    {
        $this->fill([
            'search' => '',
            'perPage' => 32,
            'field' => 'id',
            'asc' => false,
        ]);
    }

    public function paginationView()
    {
        return 'vendor.pagination.default';
    }

    /**
     * Paginate collection.
     *
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 32, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    private function getAllImages(): Collection
    {
        $base = Image::search($this->search,
        auth()->user())->get()->where('is_public', '=', '1');
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

    public function create()
    {
        $this->validate([
            'name'    => 'required|min:1|max:70',
            // 'code'     => 'required|min:1|max:10000',
        ]);

        Album::create([
            'name'      => $this->name,
            'slug'      => str_replace(' ', '-', $this->name),
            // 'code'        => $this->code,
            'user_id'   => auth()->user()->id,
        ]);

        return redirect()->to('/i');
    }

    public function render()
    {
        $images = (config('app.env') != 'local') ? Cache::remember(
            'image.search.'.Str::of(auth()->user()->id.$this->search.$this->field.(($this->asc) ? 'true' : 'false').$this->page.$this->perPage)->slug(),
            now()->addMinutes(5),
            function () {
                return $this->paginate($this->getAllImages(), $this->perPage);
            }
        ) : $this->paginate($this->getAllImages(), $this->perPage);

        return view('livewire.create-album', ['images' => $images]);
    }
}
