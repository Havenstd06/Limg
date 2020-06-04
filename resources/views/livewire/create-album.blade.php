<div>
    <div class="px-4 pt-6 pb-2 bg-white rounded-lg shadow-md md:pb-8 lg:px-8 dark:bg-midnight" data-turbolinks="false">
        <div>
            <form action="" method="POST">
                @if(count($errors) > 0)
                <div class="p-4 mb-4 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        </div>
                        <div class="ml-3">
                        <h3 class="text-sm font-medium leading-5 text-red-800">
                            There is some errors with your submission
                        </h3>
                        <div class="mt-2 text-sm leading-5 text-red-700">
                            <ul class="pl-5 list-disc">
                                @error('name')
                                    <li class="mt-1">{{ $message }}</li>
                                @enderror
                                @error('selectedImage')
                                    <li class="mt-1">{{ $message }}</li>
                                @enderror
                                @error('selectedImage.*')
                                    <li class="mt-1">{{ $message }}</li>
                                @enderror
                            </ul>
                        </div>
                        </div>
                    </div>
                </div>
                @endif
                <div>
                    <h2 class="text-xl font-medium leading-6 text-gray-800 dark:text-gray-50">
                    Create a album
                    </h2>
                    <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">
                    Share your images to the community.
                    </p>
                </div>
                <div class="w-1/4 mt-2 ">
                    <label for="name" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-100">
                        Album name
                    </label>
                    <div class="flex mt-1 rounded-md shadow-sm">
                        <input wire:model="name" type="text" id="name" name="name" placeholder="My awesome album ! 😁" class="block w-full transition duration-150 ease-in-out form-input sm:text-sm sm:leading-5" />
                    </div>
                </div>
                <div class="pt-5 mt-8 border-t border-gray-200">
                    <div class="flex justify-end">  
                    <span class="inline-flex ml-3 rounded-md shadow-sm">
                        <button wire:click.prevent="create" type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700">
                            <span wire:loading.remove wire:target="create" data-turbolinks="false">
                                Create
                            </span>
                            <span wire:loading wire:target="create">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" display="block"><circle cx="50" cy="50" fill="none" stroke="#fff" stroke-width="9" r="30" stroke-dasharray="141.37166941154067 49.12388980384689" transform="rotate(219.32 50 50)"><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1.6393442622950818s" values="0 50 50;360 50 50" keyTimes="0;1"/></circle></svg>
                            </span>
                        </button>
                    </span>
                    </div>
                </div>
            </form>
            <div class="sm:col-span-6">
                <label for="image" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-100">
                    Images
                </label>
                <p class="text-sm text-gray-500 dark:text-gray-400">Selected images must be in public.</p>
                <div>
                    <div class="items-center pt-2 lg:flex">
                        <div class="md:flex-1">
                            <a wire:click.prevent="sortBy('name')" role="button" href="#" class="px-3 py-2 mx-2 bg-gray-700 rounded-md hover:bg-gray-800 text-gray-50">
                                Name
                                @include('includes._sort-icon', ['given_field' => 'name'])
                            </a>
                            <a wire:click.prevent="sortBy('created_at')" role="button" href="#" class="px-3 py-2 mx-2 bg-gray-700 rounded-md hover:bg-gray-800 text-gray-50">
                                Date
                                @include('includes._sort-icon', ['given_field' => 'created_at'])
                            </a>
                            <button wire:click="resetTable()" class="inline-flex items-center px-3 py-2 mx-2 leading-5 text-white transition duration-150 ease-in-out bg-gray-700 border border-gray-700 rounded-md shadow-sm focus:outline-none focus:shadow-outline hover:bg-gray-800 hover:border-gray-800">
                                <i class="relative mr-1 text-sm fas fa-redo" style="top:1px;"></i>
                                Reset
                            </button>
                        </div>
                        <div>                                
                            <input wire:model="search" type="text" placeholder="Image Title, User, Date..." class="w-full px-2 py-2 mt-3 leading-normal bg-white border border-gray-300 rounded-lg appearance-none lg:mt-0 focus:outline-none lg:mr-2">
                        </div>
                    </div>
                    @if ($images->count() > 0)
                    <div class="gap-4 sm:grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7">
                        <div class="mt-2 ml-2 text-4xl text-gray-700 dark:text-gray-50" wire:loading wire:target="search, resetTable, gotoPage, previousPage, nextPage">
                            <i class="relative fas fa-circle-notch fa-spin"></i>
                        </div>
                        @foreach ($images as $img)
                            <input type="checkbox" class="hidden" wire:model="selectedImage.{{ $img->id }}" id="cb{{ $img->id }}"/>
                            <label for="cb{{ $img->id }}">
                                <div id="border" class="mt-2 transition duration-300 ease-out bg-center bg-cover border rounded-lg cursor-pointer dark:bg-forest bg-gray-50 hover:border-gray-50 border-midnight">
                                    <h2 class="h-10 pt-2 mx-4 my-4 font-semibold text-gray-800 truncate md:my-0 dark:text-gray-100" title="{{ $img->title }}">
                                        {{ $img->title ?? '' }}
                                    </h2>
                                    <div class="w-full h-40 mx-auto overflow-hidden bg-center bg-cover shadow-lg" style="background-image: url({{ route('image.show', ['image' => $img->fullname]) }})"></div>
                                    <p class="flex justify-end px-2 py-1 mr-1 text-sm font-medium text-gray-800 dark:text-gray-100">
                                        {{ $img->created_at->format('d/m/Y') }} 
                                        by&nbsp;
                                        <a href="{{ route('user.profile', ['user' => $img->user->username]) }}" class="text-indigo-500 hover:text-indigo-400" data-turbolinks="false">
                                        {{ $img->user->username }}
                                        </a>
                                    </p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $images->links() }}
                    </div>
                    @elseif ($search != null)
                    <p class="mt-2 italic text-gray-800 dark:text-gray-50">Oops! We can't find any image by the name "{{ $search }}"</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>