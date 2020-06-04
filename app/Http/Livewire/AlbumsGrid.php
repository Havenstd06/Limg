<?php

namespace App\Http\Livewire;

use App\User;
use App\Album;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class AlbumsGrid extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 20;
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
            'perPage' => 20,
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
    public function paginate($items, $perPage = 20, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    private function getAllAlbums(): Collection
    {
        $base = Album::search($this->search)
            ->get()
            ->where('is_public', '=', '1');
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

    public function render()
    {
        $albums = (config('app.env') != 'local') ? Cache::remember(
            'albumgrid.search.'.Str::of((auth()->user()) ? auth()->user()->id : User::findOrFail(1)->id.$this->search.$this->field.(($this->asc) ? 'true' : 'false').$this->page.$this->perPage)->slug(),
            now()->addMinutes(5),
            function () {
                return $this->paginate($this->getAllAlbums(), $this->perPage);
            }
        ) : $this->paginate($this->getAllAlbums(), $this->perPage);

        return view('livewire.albums-grid', ['albums' => $albums]);
    }
}
