<div wire:poll.5000ms class="lg:px-8 lg:mx-4 sm:w-full">
    <div class="md:flex md:justify-center">
        <div class="px-2 md:w-full xl:w-4/6 sm:w-auto">
            <div class="flex mt-2 mb-4 lg:justify-between">
                <h2 class="text-3xl font-bold dark:text-gray-300">
                {{ auth()->user()->images->count() }} Image{{ (auth()->user()->images->count() > 1 || auth()->user()->images->count() == 0) ? 's' : '' }}</h2>
            </div>

            <div class="justify-between mb-4 md:flex">
                <div class="md:flex-1">
                    <input wire:model="search" class="flex-1 px-5 py-2 leading-normal bg-white border border-gray-300 rounded-lg appearance-none min-w-24 lg:w-1/3 focus:outline-none lg:mr-2" type="text" placeholder="Search Image ID, Title, Date...">
                    <div class="inline text-xl text-gray-700" wire:loading wire:target="search, resetTable, gotoPage, previousPage, nextPage">
                        <i class="relative fas fa-circle-notch fa-spin" style="top:1px;"></i>
                    </div>
                </div>
                <div class="pt-3 md:pl-2 md:pt-0">
                    <button onclick="confirm('Are you sure you want to delete all your images? (This action is irreversible)') || event.stopImmediatePropagation()" wire:click="destroyAll()" class="inline-flex items-center px-4 py-2 text-base font-medium leading-5 text-white transition duration-150 ease-in-out bg-red-800 border border-red-800 rounded-md shadow-sm delete-all focus:outline-none focus:shadow-outline hover:bg-red-900 hover:border-red-900" data-url="{{ url('myImagesDeleteAll') }}">
                        <i class="relative mr-1 text-sm fas fa-redo" style="top:1px;"></i>
                        Delete All
                    </button>
                </div>
                <div class="pt-3 md:pl-2 md:pt-0">
                    <button wire:click="resetTable()" class="inline-flex items-center px-4 py-2 text-base font-medium leading-5 text-white transition duration-150 ease-in-out bg-gray-800 border border-gray-800 rounded-md shadow-sm focus:outline-none focus:shadow-outline hover:bg-gray-900 hover:border-gray-900">
                        <i class="relative mr-1 text-sm fas fa-redo" style="top:1px;"></i>
                        Reset
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div class="container flex flex-col mx-auto">
        <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            @if ($images->count() > 0)
            <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
            <table class="min-w-full">
                <thead>
                <tr>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-800 uppercase bg-gray-100 border-b border-gray-200">
                        <a wire:click.prevent="sortBy('id')" role="button" href="#">
                            ID
                            @include('includes._sort-icon', ['given_field' => 'id'])
                        </a>
                    </th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-800 uppercase bg-gray-100 border-b border-gray-200">
                        <a wire:click.prevent="sortBy('title')" role="button" href="#">
                            Image
                            @include('includes._sort-icon', ['given_field' => 'title'])
                        </a>
                    </th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-800 uppercase bg-gray-100 border-b border-gray-200">
                        <a wire:click.prevent="sortBy('is_public')" role="button" href="#">
                            Is Public
                            @include('includes._sort-icon', ['given_field' => 'is_public'])
                        </a>
                    </th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-center text-gray-800 uppercase bg-gray-100 border-b border-gray-200">
                        <a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                            Date
                            @include('includes._sort-icon', ['given_field' => 'created_at'])
                        </a>
                    </th>
                    <th class="px-6 py-3 bg-gray-100 border-b border-gray-200"></th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach ($images as $image)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            {{ $image->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                        <a href="{{ route('image.show', ['image' => $image->pageName]) }}">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-auto">
                                    <img class="w-10 h-auto rounded" src="{{ route('image.show', ['image' => $image->fullname]) }}" alt="" />
                                </div>
                                <div class="ml-4 text-sm font-medium leading-5 text-gray-900">{{ $image->title ? $image->title : '' }}</div>
                            </div>
                        </a>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                        @if ($image->is_public)
                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                Active
                            </span>
                        @else
                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                Disable
                            </span>
                        @endif
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-center text-gray-800 whitespace-no-wrap border-b border-gray-200">
                            {{ $image->created_at->format('Y/m/d H:i:s') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-gray-200">
                            @if ($confirming === $image->id)
                                <button wire:click="destroy({{ $image->id }})" class="px-4 py-2 text-sm font-medium leading-5 text-white transition duration-200 ease-in-out bg-red-600 border border-red-300 rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:shadow-outline">
                                    <i class="mr-1 far fa-trash-alt"></i> Sure ?
                                </button> 
                            @else
                                <button wire:click="confirmDestroy({{ $image->id }})" class="px-4 py-2 text-sm font-medium leading-5 text-white transition duration-200 ease-in-out bg-gray-600 border border-gray-300 rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:shadow-outline">
                                    <i class="mr-1 far fa-trash-alt"></i> Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            <div class="mt-4">
                {{ $images->links() }}
            </div>
            @elseif ($search != null)
            <p class="italic text-gray-800">Oops! We can't find any image by the name "{{ $search }}"</p>
            @endif
        </div>
    </div>
</div>