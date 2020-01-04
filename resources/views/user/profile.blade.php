@extends('layouts.app')

@section('head')
<title>{{ $user->username }}'s profile — {{ config('app.name', 'Laravel') }} — {{ config('app.description') }}</title>

<!-- OpenGraph/Twitter -->
<meta data-rh="true" name="description" content="{{ $user->username }}'s Profile" />
<meta data-rh="true" property="og:url" content="{{ url()->current() }}" />
<meta data-rh="true" property="og:description" content="{{ $user->username }}'s Profile" />
<meta data-rh="true" property="og:image" content="{{ url(Storage::url($user->avatar)) }}" />
<meta data-rh="true" property="og:title" content="{{ config('app.name') }}" />
<meta data-rh="true" property="og:website" content="website" />
<meta data-rh="true" property="og:site_name" content="{{ config('app.name') }}.app" />
<meta data-rh="true" name="twitter:image:src" content="{{ url(Storage::url($user->avatar)) }}" />
<meta data-rh="true" property="twitter:description" content="{{ $user->username }}'s Profile" />
<meta data-rh="true" name="twitter:card" content="summary_large_image" />
<meta data-rh="true" name="twitter:creator" content="@HavensYT" />
<meta data-rh="true" name="author" content="Thomas Drumont" />
<meta data-rh="true" name="twitter:site" content="@rss_chat" />
<meta data-rh="true" property="twitter:title" content="{{ config('app.name') }}" />
@endsection

@section('content')

<div class="px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md dark:bg-midnight sm:container sm:mx-auto sm:w-full">
    <div class="sm:px-2">
        <div class="sm:-mx-2 sm:flex">
            <div class="sm:w-1/3 sm:px-2">
                <div class="flex sm:ml-40">
                    <img class="w-24 rounded sm:w-38" src="{{ Storage::url($user->avatar) }}"/>
                    <div class="mt-4 ml-2 sm:ml-4">
                        <h4 class="text-lg sm:text-5xl font-firacode dark:text-gray-300">{{ $user->username }}</h4>
                        <p class="text-sm sm:text-xl dark:text-gray-300 font-firacode"><span class="text-green-600">{{ $user->images->count() }}</span> Images</p>
                    </div>
                </div>  
            </div>
            <div class="sm:w-1/3 sm:px-2">
                <div class="mt-4 sm:ml-24 sm:mt-10">
                    @if (Auth::check() && auth()->user()->id == $user->id)
                    <form action="{{ route('settings.update.profile', ['user' => $user]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input name="description" value="{{ $user->description }}" placeholder="Description" class="w-4/6 px-3 py-2 text-gray-800 border rounded shadow appearance-none sm:w-3/5">
                        <button type="submit" class="inline-flex items-center px-2 py-2 font-bold text-white bg-indigo-700 border-2 border-indigo-700 rounded shadow-md hover:border-indigo-600 hover:bg-indigo-800 hover:text-white">
                            <i class="mr-2 fas fa-save"></i> Save
                        </button>
                    </form>
                    @elseif ($user->description)
                    <h4 class="text-lg sm:text-xl font-firacode dark:text-gray-300" title="Description">{{ $user->description }}</h4>
                    @else
                    <h1 class="text-lg sm:text-xl font-firacode dark:text-gray-300">This user has no description</h1>
                    @endif
                    <h4 class="text-lg sm:text-xl font-firacode dark:text-gray-300" title="Registration date">{{ $user->created_at === null ? "N/A" : date('M d Y', $user->created_at->getTimestamp()) }}</h4>
                </div>
            </div>
            <div class="sm:w-1/3 sm:px-2">
                <div class="mt-4 sm:ml-24 sm:mt-10">
                    @if (Auth::check() && auth()->user()->id == $user->id)
                    <form action="{{ route('settings.update.profile', ['user' => $user]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="always_public" class="flex items-center justify-center pt-6 pb-3 pr-3 cursor-pointer">
                        <div class="relative">
                            <input name="always_public" id="always_public" type="checkbox" class="hidden" value="{{ $user->always_public ? '1' : '0' }}" {{ $user->always_public ? 'checked' : '' }} onChange="form.submit()"/>
                            <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner toggle__line"></div>
                            <div class="absolute inset-y-0 left-0 w-6 h-6 bg-white rounded-full shadow toggle__dot"></div>
                        </div>
                        <span class="pl-4 font-bold text-gray-800 dark:text-gray-300">Always Upload Image in public</span>
                        </label>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>     
<br class="my-10">
<div class="px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md dark:bg-midnight sm:container sm:mx-auto sm:w-full">
    @if ($user->images->count() != 0)
    <div data-controller="tabs" data-tabs-active-tab="-text-gray-600 border-b-2 border-blue-500 text-blue-500" class="pb-6">
        <ul class="flex flex-col list-reset sm:flex-row">
            <li data-target="tabs.tab" data-action="click->tabs#change">
                <a href="#all" class="block px-6 py-4 font-medium text-center dark:text-gray-300 focus:outline-none">
                    <i class="fas fa-globe"></i> All
                </a>
            </li>
            @if (Auth::check() && auth()->user()->id == $user->id)
            <li data-target="tabs.tab" data-action="click->tabs#change">
                <a href="#public" class="block px-6 py-4 text-center dark:text-gray-300 focus:outline-none">
                    <i class="fas fa-globe-europe"></i> Public
                </a>
            </li>
            <li data-target="tabs.tab" data-action="click->tabs#change">
                <a href="#private" class="block px-6 py-4 text-center dark:text-gray-300 focus:outline-none">
                    <i class="fas fa-user-lock"></i> Private
                </a>
            </li>
            @endif
        </ul>
        <div class="hidden px-4 py-4" data-target="tabs.panel">
            <div class="flex flex-wrap">
                @foreach ($user->images as $image)
                    @isNotPublic($image)
                    @else
                    <div class="p-3 md:w-1/2 lg:w-1/6">
                        <a href="{{ route('image.show', ['image' => $image->name]) }}" class="block h-56 overflow-hidden rounded-lg sm:shadow-lg">
                            <h1 class="items-center justify-between h-16 p-3 px-4 text-lg leading-tight bg-white rounded-t dark:text-gray-300 dark:bg-forest lg:flex">{{ $image->title ?? '‌‌' }} <small class="dark:text-gray-400">@if($image->is_public) Public @else Private @endif</small></h1>
                            <img class="w-full rounded-b" src="{{ route('image.show', ['image' => $image->fullname]) }}" alt="{{ $image->title ?? $user->username }}">
                        </a>
                    </div>
                    @endisNotPublic
                @endforeach
            </div>
        </div>
        @if (Auth::check() && auth()->user()->id == $user->id)
        <div class="hidden px-4 py-4" data-target="tabs.panel">
            <div class="flex flex-wrap">
                @foreach ($user->images as $image)
                    @if ($image->is_public)
                    <div class="p-3 md:w-1/2 lg:w-1/6">
                        <a href="{{ route('image.show', ['image' => $image->name]) }}" class="block h-56 overflow-hidden rounded-lg sm:shadow-lg">
                            <h1 class="items-center justify-between h-16 p-3 px-4 text-lg leading-tight bg-white rounded-t dark:text-gray-300 dark:bg-forest lg:flex">{{ $image->title ?? '‌‌' }} <small class="dark:text-gray-400">@if($image->is_public) Public @else Private @endif</small></h1>
                            <img class="w-full rounded-b" src="{{ route('image.show', ['image' => $image->fullname]) }}" alt="{{ $image->title ?? $user->username }}">
                        </a>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="hidden px-4 py-4" data-target="tabs.panel">
            <div class="flex flex-wrap">
                @foreach ($user->images as $image)
                    @if (!$image->is_public)
                    <div class="p-3 md:w-1/2 lg:w-1/6">
                        <a href="{{ route('image.show', ['image' => $image->name]) }}" class="block h-56 overflow-hidden rounded-lg sm:shadow-lg">
                            <h1 class="items-center justify-between h-16 p-3 px-4 text-lg leading-tight bg-white rounded-t dark:text-gray-300 dark:bg-forest lg:flex">{{ $image->title ?? '‌‌' }} <small class="dark:text-gray-400">@if($image->is_public) Public @else Private @endif</small></h1>
                            <img class="w-full rounded-b" src="{{ route('image.show', ['image' => $image->fullname]) }}" alt="{{ $image->title ?? $user->username }}">
                        </a>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @else
        <div class="py-4 text-center lg:px-4">
            <div class="flex items-center p-2 leading-none text-indigo-100 bg-indigo-800 lg:rounded-full lg:inline-flex" role="alert">
                <span class="flex px-2 py-1 mr-3 text-xs font-bold uppercase bg-indigo-500 rounded-full">Info</span>
                <span class="flex-auto mr-2 font-semibold text-left">This user has no image</span>
            </div>
        </div>
    @endif
</div>

@endsection
