<div>
    <div class="items-center justify-between pt-2 lg:flex">
        <div class="md:flex">
            <div wire:click.prevent="sortBy('id')" role="button" href="#" class="w-full px-3 py-2 mx-2 mt-2 text-center bg-gray-700 rounded-md md:w-24 hover:bg-gray-800 text-gray-50">
                ID
                @include('includes._sort-icon', ['given_field' => 'id'])
            </div>
            <div wire:click.prevent="sortBy('name')" role="button" href="#" class="w-full px-3 py-2 mx-2 mt-2 text-center bg-gray-700 rounded-md md:w-24 hover:bg-gray-800 text-gray-50">
                Album
                @include('includes._sort-icon', ['given_field' => 'name'])
            </div>
            <div wire:click.prevent="sortBy('created_at')" role="button" href="#" class="w-full px-3 py-2 mx-2 mt-2 text-center bg-gray-700 rounded-md md:w-24 hover:bg-gray-800 text-gray-50">
                Date
                @include('includes._sort-icon', ['given_field' => 'created_at'])
            </div>
            <button wire:click="resetTable()" class="inline-flex items-center justify-center w-full px-4 py-2 mx-2 mt-2 leading-5 text-center text-white transition duration-150 ease-in-out bg-gray-700 border border-gray-700 rounded-md shadow-sm md:justify-start md:w-24 focus:outline-none focus:shadow-outline hover:bg-gray-800 hover:border-gray-800">
                <i class="relative mr-1 text-sm fas fa-redo" style="top:1px;"></i>
                Reset
            </button>
            <div class="ml-2 text-xl text-gray-700 dark:text-gray-50" wire:loading wire:target="search, resetTable, gotoPage, previousPage, nextPage">
                <i class="relative fas fa-circle-notch fa-spin" style="top: 2px;"></i>
            </div>
        </div>
        <div class="w-full lg:w-1/3">                                
            <input wire:model="search" class="w-full px-2 py-2 mt-3 leading-normal bg-white border border-gray-300 rounded-lg appearance-none lg:mt-0 focus:outline-none lg:mr-2" type="text" placeholder="album ID, Title, User, Date...">
        </div>
    </div>
    @if ($albums->count() > 0)
    <div class="gap-4 mt-4 sm:grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
        @foreach ($albums as $album)
        {{-- {{ dd(route('image.show', ['image' => $album->images->first()->fullname])) }} --}}
            <div wire:loading.remove class="mt-2 transition duration-300 ease-out bg-center bg-cover border rounded-lg dark:bg-forest bg-gray-50 hover:border-gray-50 border-midnight">
            <h2 class="h-10 pt-2 mx-4 my-4 font-semibold text-gray-800 truncate md:my-0 dark:text-gray-100" title="{{ $album->name }}">
                {{ $album->name ?? '' }}
            </h2>
            
            <a href="{{ route('album.show', ['album' => $album->slug]) }}">
                <div class="w-full h-48 mx-auto overflow-hidden bg-center bg-cover shadow-lg"
                style="background-image: url({{ route('image.show', ['image' => $album->images->first()->fullname]) }})"></div>
            </a>
            <p class="flex justify-end px-2 py-1 mr-2 text-sm font-medium text-gray-800 dark:text-gray-100">
                {{ $album->created_at->format('d/m/Y') }} 
                by&nbsp;
                <a href="{{ route('user.profile', ['user' => $album->user->username]) }}" class="text-indigo-500 hover:text-indigo-400">
                {{ $album->user->username }}
                </a>
            </p>
            </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $albums->links() }}
    </div>
    @elseif ($search != null)
    <p class="mt-2 italic text-gray-800 dark:text-gray-50">Oops! We can't find any album by the name "{{ $search }}"</p>
    @endif
</div>
