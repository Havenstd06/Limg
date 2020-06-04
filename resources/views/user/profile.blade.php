@extends('layouts.app')

@section('head')
<title>{{ $user->username }}'s profile — {{ config('app.name', 'Laravel') }} — {{ config('app.description') }}</title>

<!-- OpenGraph/Twitter -->
<meta data-rh="true" name="description" content="{{ $user->username }}'s Profile" />
<meta data-rh="true" property="og:url" content="{{ url()->current() }}" />
<meta data-rh="true" property="og:description" content="{{ $user->username }}'s Profile" />
<meta data-rh="true" property="og:image" content="{{ url(url($user->avatar)) }}" />
<meta data-rh="true" property="og:title" content="{{ config('app.name') }}" />
<meta data-rh="true" property="og:website" content="website" />
<meta data-rh="true" property="og:site_name" content="{{ config('app.name') }}.app" />
<meta data-rh="true" name="twitter:image:src" content="{{ url(url($user->avatar)) }}" />
<meta data-rh="true" property="twitter:description" content="{{ $user->username }}'s Profile" />
<meta data-rh="true" name="twitter:card" content="summary_large_image" />
<meta data-rh="true" name="twitter:creator" content="@HavensYT" />
<meta data-rh="true" name="author" content="Thomas Drumont" />
<meta data-rh="true" name="twitter:site" content="@limg_app" />
<meta data-rh="true" property="twitter:title" content="{{ config('app.name') }}" />
@endsection

@section('content')

<div class="px-8 pt-6 pb-8 mb-6 bg-gray-100 rounded-lg shadow-md dark:bg-midnight dark:text-gray-300">
    <div class="grid-flow-col md:grid sm:grid-flow-row md:grid-flow-col-dense lg:grid-flow-row-dense xl:grid-flow-col">
        <div class="flex items-center justify-center mx-auto md:justify-start">
            <img class="w-24 rounded sm:w-38" src="{{ url($user->avatar) }}"/>
            <div class="ml-4">
                <h4 class="text-lg text-gray-800 sm:text-5xl dark:text-gray-300">{{ $user->username }}</h4>
                <span class="flex mb-1 -mt-1">{{ $user->description }}</span>
                <span class="inline-flex items-center px-3 text-sm font-medium leading-5 text-white bg-gray-600 rounded-full dark:text-gray-800 dark:bg-gray-100">
                    <span class="text-green-400 dark:text-green-600">{{ $user->images->count() }}</span>
                    &nbsp;images
                </span>
            </div>
        </div>
        <div class="flex items-center mt-6 md:mt-0">
            <div>
                @if (Auth::check() && auth()->user()->id == $user->id)
                    <form action="{{ route('settings.update.profile', ['user' => $user]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex items-center">
                            <div class="relative">
                                <input name="description" value="{{ $user->description }}" class="block w-full px-2 py-2 leading-5 transition duration-150 ease-in-out border border-gray-300 rounded-none dark:text-gray-700 rounded-l-md sm:text-sm" placeholder="Description" />
                            </div>
                            <button type="submit" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out border border-gray-300 dark:text-gray-800 rounded-r-md bg-gray-50 hover:text-gray-500 hover:bg-white focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                                <span>Save</span>
                            </button>
                        </div>
                        <label for="always_public" class="flex items-center justify-center pt-6 pb-3 cursor-pointer">
                            <div class="relative">
                                <input name="always_public" id="always_public" type="checkbox" class="hidden" value="{{ $user->always_public ? '1' : '0' }}" {{ $user->always_public ? 'checked' : '' }} onChange="form.submit()"/>
                                <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner toggle__line"></div>
                                <div class="absolute inset-y-0 left-0 w-6 h-6 bg-white rounded-full shadow toggle__dot"></div>
                            </div>
                            <span class="pl-4 text-sm font-bold text-gray-700 md:text-base dark:text-gray-300">Always Upload Image in public</span>
                        </label>
                    </form>
                @endif
            </div>
        </div>
        @if (Auth::check() && auth()->user()->id == $user->id)
        <div class="flex items-center justify-center md:justify-start">
            <div class="mt-6" x-data="{ open: false }">
                <button @click="open = true" class="relative inline-flex items-center px-4 py-2 -ml-px text-lg font-medium leading-5 text-gray-700 transition duration-150 ease-in-out border border-gray-300 rounded bg-gray-50 hover:text-gray-500 hover:bg-white focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                    ShareX Configuration
                </button>

                <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full" style="background-color: rgba(0,0,0,.5);" x-show="open" x-cloak x-description="Background overlay, show/hide based on modal state." x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity">
                    <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0" @click.away="open = false">
                        <h2 class="text-2xl dark:text-gray-700">ShareX</h2>
                        <textarea id="sharex" cols="60" rows="11" class="w-full p-2 border dark:text-gray-700" spellcheck="false">{
"Name": "{{ config('app.name') }}",
"DestinationType": "ImageUploader",
"RequestURL": "{{ route('api_upload') }}",
"FileFormName": "file",
"Arguments": {
    "key": "{{ auth()->user()->api_token }}",
    "file": "%guid"
},
"URL": "$json:image.url$"
}</textarea>
                        <div class="flex justify-center mt-8">                      
                            <button onclick=saveShareXFile(sharex.value,'ShareX-{{ config('app.name') }}.sxcu') class="px-4 py-2 text-white bg-gray-600 rounded select-none no-outline focus:shadow-outline">
                                Download
                            </button>
                            <button class="px-4 py-2 ml-2 text-white bg-red-700 rounded select-none no-outline focus:shadow-outline" @click="open = false">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="pt-6 pb-8 mt-4 bg-gray-100 rounded-lg shadow-md md:px-8 dark:bg-midnight sm:container sm:mx-auto sm:w-full">
    @if ($user->images->count() != 0)
    <div x-data="{ tab: @if (Auth::check() && auth()->user()->id == $user->id) 'all' @else 'public' @endif }">
        <nav class="flex items-center mb-2">
            @if (Auth::check() && auth()->user()->id == $user->id)
            <button class="px-1 py-4 ml-8 font-medium leading-5 whitespace-no-wrap border-b-2 focus:outline-none" 
            :class="{'dark:text-gray-300 text-gray-700 border-transparent hover:text-gray-500 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300': tab !== 'all', 'text-indigo-500 border-indigo-400 focus:text-indigo-500 focus:border-indigo-600': tab === 'all'}"
            @click="tab = 'all'">
                <i class="fas fa-globe"></i> All
            </button>
            @endif
            <button class="px-1 py-4 ml-8 font-medium leading-5 whitespace-no-wrap border-b-2 focus:outline-none" 
            :class="{'dark:text-gray-300 text-gray-700 border-transparent hover:text-gray-500 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300': tab !== 'public', 'text-indigo-500 border-indigo-400 focus:text-indigo-500 focus:border-indigo-600': tab === 'public'}"
            @click="tab = 'public'">
                <i class="fas fa-globe-europe"></i> Public
            </button>
            @if (Auth::check() && auth()->user()->id == $user->id)
            <button class="px-1 py-4 ml-8 font-medium leading-5 whitespace-no-wrap border-b-2 focus:outline-none" 
            :class="{'dark:text-gray-300 text-gray-700 border-transparent hover:text-gray-500 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300': tab !== 'private', 'text-indigo-500 border-indigo-400 focus:text-indigo-500 focus:border-indigo-600': tab === 'private'}"
            @click="tab = 'private'">
                <i class="fas fa-user-lock"></i> Private
            </button>
            @endif
        </nav>
        <div x-show="tab === 'all'">
            <div class="gap-4 sm:grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                @foreach ($allImages as $img)
                    <div class="rounded-lg dark:bg-forest bg-gray-50">
                        <h2 class="h-10 pt-2 mx-4 my-4 font-semibold text-gray-800 truncate md:my-0 dark:text-gray-100" title="{{ $img->title }}">
                            {{ $img->title ?? '' }}
                        </h2>
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
            <div class="pt-5 text-center">
                {{ $allImages->links() }}
            </div>
        </div>
        <div x-show="tab === 'public'">
            <div class="gap-4 sm:grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                @foreach ($publicImages as $img)
                    <div class="rounded-lg dark:bg-forest bg-gray-50">
                        <h2 class="h-10 pt-2 mx-4 my-4 font-semibold text-gray-800 truncate md:my-0 dark:text-gray-100" title="{{ $img->title }}">
                            {{ $img->title ?? '' }}
                        </h2>
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
            <div class="pt-5 text-center">
                {{ $publicImages->links() }}
            </div>
        </div>
        <div x-show="tab === 'private'">
            <div class="gap-4 sm:grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                @foreach ($privateImages as $img)
                    <div class="rounded-lg dark:bg-forest bg-gray-50">
                        <h2 class="h-10 pt-2 mx-4 my-4 font-semibold text-gray-800 truncate md:my-0 dark:text-gray-100" title="{{ $img->title }}">
                            {{ $img->title ?? '' }}
                        </h2>
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
            <div class="pt-5 text-center">
                {{ $privateImages->links() }}
            </div>
        </div>
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

@section('javascripts')
<script>
   function saveShareXFile(textToWrite, fileNameToSaveAs)
    {
    	var textFileAsBlob = new Blob([textToWrite], {type:'text/plain'}); 
    	var downloadLink = document.createElement("a");
    	downloadLink.download = fileNameToSaveAs;
    	downloadLink.innerHTML = "Download File";
    	if (window.webkitURL != null)
    	{
    		downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
    	}
    	else
    	{
    		downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
    		downloadLink.onclick = destroyClickedElement;
    		downloadLink.style.display = "none";
    		document.body.appendChild(downloadLink);
    	}
    
    	downloadLink.click();
    }
</script>
@endsection