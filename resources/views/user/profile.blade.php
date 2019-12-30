@extends('layouts.app')

@section('content')

<div class="px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md dark:bg-midnight sm:container sm:mx-auto sm:w-full">
    <div class="sm:px-2">
        <div class="sm:-mx-2 sm:flex">
            <div class="sm:w-1/3 sm:px-2">
                <div class="flex sm:ml-40">
                    <img class="w-32 rounded sm:w-38" src="{{ Storage::url($user->avatar) }}"/>
                    <div class="mt-4 ml-2 sm:ml-4">
                        <span class="text-lg sm:text-5xl font-firacode dark:text-gray-300">{{ $user->username }}</span><br>
                        <span class="text-sm sm:text-xl dark:text-gray-300 font-firacode"><span class="text-green-600">{{ $user->images->count() }}</span> Images</span>
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
                    <h4 class="text-lg sm:text-xl font-firacode dark:text-gray-300">This user has no description</h4>
                    @endif
                    <h4 class="text-lg sm:text-xl font-firacode dark:text-gray-300" title="Registration date">{{ $user->created_at === null ? "N/A" : date('M d Y', $user->created_at->getTimestamp()) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>     
<br class="my-10">
<div class="px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md dark:bg-midnight sm:container sm:mx-auto sm:w-full">
    @if ($user->images)
        <div class="flex flex-wrap">
            @foreach ($user->images as $image)
                @isNotPublic($image)
                @else
                <div class="p-3 md:w-1/2 lg:w-1/6">
                    <a href="{{ route('image.show', ['image' => $image->name]) }}" class="block h-56 overflow-hidden rounded-lg sm:shadow-lg">
                        <h1 class="items-center justify-between h-16 p-3 text-lg leading-tight bg-white rounded-t dark:text-gray-300 dark:bg-forest lg:flex">{{ $image->title ?? '‌‌' }} <small class="dark:text-gray-400">@if($image->is_public) Public @else Private @endif</small></h1>
                        <img class="w-full rounded-b" src="{{ route('image.show', ['image' => $image->fullname]) }}" alt="{{ $image->title ?? $user->username }}">
                    </a>
                </div>
                @endisNotPublic
            @endforeach
        </div>
    @endif
</div>

@endsection
