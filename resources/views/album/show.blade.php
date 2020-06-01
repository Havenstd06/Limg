@extends('layouts.app')

@section('content')
{{-- {{ $album->name }}

@foreach ($album->images as $i)
    <img src="{{ $i->path }}" alt="{{ $i->title }}">
@endforeach --}}
<div class="px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md max-w-7xl dark:bg-midnight sm:container sm:mx-auto sm:w-full">
<h3 class="mb-4 text-4xl truncate dark:text-gray-300">{{ $album->name }}</h3>
  <div class="container mx-auto">
    <div class="justify-center justify-between mb-3 lg:flex">
    @ownsAlbum($album)
      <form role="form" method="POST" action="">
        @csrf
        <div class="sm:flex sm:items-center">
          <label class="mr-4">
            <input type="text" name="title" value="" placeholder="Give a title to your Album" 
            class="block w-64 px-4 py-3 leading-tight text-gray-700 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
          </label>
          <label class="flex custom-label sm:mx-4">
            <div class="flex items-center justify-center w-6 h-6 p-1 mr-2 bg-white shadow">
              <input type="checkbox" class="hidden" name="is_public" value="">
              <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
            </div>
            <span class="text-gray-700 dark:text-gray-100"> {{ __('Public') }}</span>
          </label>  
          <button type="submit" class="px-4 py-2 mt-4 font-bold text-white bg-indigo-700 rounded shadow hover:bg-indigo-800 focus:shadow-outline focus:outline-none sm:mx-4 sm:mt-0">
            <i class="fas fa-save"></i> {{ __('Save') }}
          </button>
          <a onclick="return confirm('Are you sure you want to delete all your album? (This action is irreversible)')" href="" class="px-4 py-2 mt-4 font-bold text-white bg-red-700 rounded shadow hover:bg-red-800 focus:shadow-outline focus:outline-none sm:mx-4 sm:mt-0">
            <i class="fas fa-trash-alt"></i> {{ __('Delete') }}
          </a>
        </div>
      </form>
    @endownsAlbum
      <a class="flex mt-4 lg:mt-0" href="{{ route('user.profile', $album->user->username) }}">	
        <img class="w-10 h-10 mr-4 rounded-full" src="{{ url($album->user->avatar) }}" alt="{{ $album->user->username }}'s album'">	
        <div class="text-sm">	
        <p class="leading-none text-gray-900 dark:text-gray-300">{{ $album->user->username }}</p>	
        <p class="text-gray-500">{{ $album->created_at->format('d/m/Y') }} ({{ $album->created_at->diffForHumans() }})</p>	
        </div>	
      </a>
    </div>
    <div class="gap-4 sm:grid sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-3">
      @foreach ($album->images as $i)
      <a href="{{ route('image.show', ['image' => $i->pageName]) }}">
        <div class="w-full h-56 mx-auto my-5 overflow-hidden rounded-lg shadow-lg md:h-96 xl:h-64 md:w-full md:my-2 dark:bg-forest bg-gray-50">
            <h2 class="pt-2 mx-4 font-semibold text-gray-800 truncate dark:text-gray-100" title="{{ $i->title }}">
              {{ $i->title }}
            </h2>
            <p class="flex justify-end px-2 mb-2 mr-2 text-sm text-gray-100">
              {{ $i->created_at->format('d/m/Y') }} 
              by {{ $i->user->username }}
            </p>
            <img src="{{ route('image.show', ['image' => $i->fullname]) }}" alt="{{ $i->title ?? $i->user->username }}">
        </div>
      </a>
      @endforeach
    </div>
  </div>
</div>
@endsection