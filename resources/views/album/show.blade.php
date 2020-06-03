@extends('layouts.app')

@section('head')
    <title>{{ $album->name }} — {{ config('app.name', 'Laravel') }} — {{ config('app.description') }}</title>

    <!-- OpenGraph/Twitter -->
    <meta data-rh="true" name="description" content="{{ $album->name }}"/>
    <meta data-rh="true" property="og:url" content="{{ url()->current() }}"/>
    <meta data-rh="true" property="og:description" content="{{ $album->name }} "/>
    <meta data-rh="true" property="og:image" @if($album->is_public) content="{{ route('album.show', ['album' => $album->slug]) }}" @else content="{{ asset('images/cover.png') }}"@endif/>
    <meta data-rh="true" property="og:title" content="{{ config('app.name') }}"/>
    <meta data-rh="true" property="og:website" content="website" />
    <meta data-rh="true" property="og:site_name" content="{{ config('app.name') }}.app"/>
    <meta data-rh="true" name="twitter:image:src" @if($album->is_public) content="{{ route('album.show', ['album' => $album->slug]) }}" @else content="{{ asset('images/cover.png') }}"@endif/>
    <meta data-rh="true" property="twitter:description" content="{{ $album->name }}"/>
    <meta data-rh="true" name="twitter:card" content="summary_large_image" />
    <meta data-rh="true" name="twitter:creator" content="@HavensYT"/>
    <meta data-rh="true" name="author" content="Thomas Drumont"/>
    <meta data-rh="true" name="twitter:site" content="@limg_app"/>
    <meta data-rh="true" property="twitter:title" content="{{ config('app.name') }}"/>
@endsection

@section('content')
<div class="px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md max-w-7xl dark:bg-midnight sm:container sm:mx-auto sm:w-full">
  @albumIsNotPublic($album)
  <div class="container w-1/2 mx-auto lg:w-2/4">
    <div class="px-4 py-3 text-teal-900 bg-teal-100 border-t-4 border-teal-500 rounded-b shadow-md" role="alert">
      <div class="flex">
        <div class="py-1 pr-3">
          <i class="fas fa-info-circle fa-2x"></i>
        </div>
        <div>
          <p class="font-bold">This album is private</p>
          <p class="text-sm">The user has chosen to put his album in private.</p>
        </div>
      </div>
    </div>
  </div>
  @else 
  <h3 class="mb-4 text-4xl truncate dark:text-gray-300">{{ $album->name }}</h3>
  <div class="container mx-auto">
    <div class="justify-center justify-between mb-3 lg:flex">
    @ownsAlbum($album)
      <form role="form" method="POST" action="{{ route('album.infos', ['album' => $album->slug]) }}">
        @csrf
        <div class="sm:flex sm:items-center">
          <label class="mr-4">
            <input type="text" name="name" value="{{ $album->name }}" placeholder="Give a name to your Album" 
            class="block w-64 px-4 py-3 leading-tight text-gray-700 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
          </label>
          <label class="flex custom-label sm:mx-4">
            <div class="flex items-center justify-center w-6 h-6 p-1 mr-2 bg-white shadow">
              <input type="checkbox" class="hidden" name="is_public" value="{{ $album->is_public ? '1' : '0' }}" {{ $album->is_public ? 'checked' : '' }}>
              <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
            </div>
            <span class="text-gray-700 dark:text-gray-100"> {{ __('Public') }}</span>
          </label>  
          <button type="submit" class="px-4 py-2 mt-4 font-bold text-white bg-indigo-700 rounded shadow hover:bg-indigo-800 focus:shadow-outline focus:outline-none sm:mx-4 sm:mt-0">
            <i class="fas fa-save"></i> {{ __('Save') }}
          </button>
          <a onclick="return confirm('Are you sure you want to delete all your album? (This action is irreversible)')" href="{{ route('album.delete', ['album' => $album->slug]) }}" class="px-4 py-2 mt-4 font-bold text-white bg-red-700 rounded shadow hover:bg-red-800 focus:shadow-outline focus:outline-none sm:mx-4 sm:mt-0">
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
      @foreach ($album->images as $img)
        <div class="rounded-lg dark:bg-forest bg-gray-50">
          <div class="relative flex">
            <h2 class="h-10 pt-2 mx-4 my-4 font-semibold text-gray-800 truncate md:my-0 dark:text-gray-100" title="{{ $img->title }}">
              {{ $img->title ?? '' }}
            </h2>
          @ownsAlbum($album)
            <a href="{{ route('album.remove', ['album' => $album, 'image' => $img]) }}" title="Remove from this album" data-turbolinks="false">
              <span class="absolute block px-1 text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full right-2 top-1">
                <i class="far fa-trash-alt fa-sm" style="margin-bottom:6px;margin-left:3px;margin-right:3px;"></i>
              </span>
            </a>
          @endownsAlbum
          </div>
          <a href="{{ route('image.show', ['image' => $img->pageName]) }}">
            <div class="w-full h-48 mx-auto overflow-hidden bg-center bg-cover shadow-lg"
            style="background-image: url({{ route('image.show', ['image' => $img->fullname]) }})"></div>
          </a>
          <p class="flex justify-end px-2 py-1 mr-2 text-sm font-medium text-gray-800 dark:text-gray-100">
            {{ $img->created_at->format('d/m/Y') }} 
            by&nbsp;
            <a href="{{ route('user.profile', ['user' => $img->user->username]) }}" class="text-indigo-500 hover:text-indigo-400">
              {{ $img->user->username }}
            </a>
          </p>
        </div>
      @endforeach
    </div>
  </div>
  @endalbumIsNotPublic
</div>
@endsection