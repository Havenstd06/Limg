@extends('layouts.app')

@section('head')
    <title>@if($image->title) {{ $image->title }} — @endif {{ config('app.name', 'Laravel') }} — {{ config('app.description') }}</title>

    <!-- OpenGraph/Twitter -->
    <meta data-rh="true" name="description" content="@if($image->title) {{ $image->title }}@endif" />
    <meta data-rh="true" property="og:url" content="{{ url()->current() }}" />
    <meta data-rh="true" property="og:description" content="@if($image->title) {{ $image->title }} @endif" />
    <meta data-rh="true" property="og:image" @if($image->is_public) content="{{ url($image->path) }}" @endif @if(!$image->is_public) content="{{ asset('images/cover.png') }}" @endif />
    <meta data-rh="true" property="og:title" content="{{ config('app.name') }}" />
    <meta data-rh="true" property="og:website" content="website" />
    <meta data-rh="true" property="og:site_name" content="{{ config('app.name') }}.app" />
    <meta data-rh="true" name="twitter:image:src" @if($image->is_public) content="{{ url($image->path) }}" @endif @if(!$image->is_public) content="{{ asset('images/cover.png') }}" @endif />
    <meta data-rh="true" property="twitter:description" content="@if($image->title) {{ $image->title }}@endif" />
    <meta data-rh="true" name="twitter:card" content="summary_large_image" />
    <meta data-rh="true" name="twitter:creator" content="@HavensYT" />
    <meta data-rh="true" name="author" content="Thomas Drumont" />
    <meta data-rh="true" name="twitter:site" content="@limg_app" />
    <meta data-rh="true" property="twitter:title" content="{{ config('app.name') }}" />
@endsection

@section('content')
<div class="container mx-auto mt-10">
  @isNotPublic($image)
  <div class="container w-1/2 mx-auto lg:w-1/3">
    <div class="px-4 py-3 text-teal-900 bg-teal-100 border-t-4 border-teal-500 rounded-b shadow-md" role="alert">
      <div class="flex">
        <div class="py-1 pr-3">
          <i class="fas fa-info-circle fa-2x"></i>
        </div>
        <div>
          <p class="font-bold">This image is private</p>
          <p class="text-sm">The user has chosen to put his image in private.</p>
        </div>
      </div>
    </div>
  </div>
  @else 
  <div class="max-w-6xl px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md dark:bg-midnight sm:container sm:mx-auto sm:w-full">
  @if ($image->title != null)
    <h3 class="mb-4 text-4xl dark:text-gray-300">{{ $image->title }}</h3>
  @endif
  @ownsImage($image)
    <form role="form" method="POST" action="{{ route('image.infos', ['image' => $image->pageName]) }}">
      @csrf
      <div class="my-6 sm:flex sm:items-center">
        <label class="mr-4">
          <input type="text" name="title" value="{{ $image->title }}" placeholder="Give a title to your image" 
          class="block w-64 px-4 py-3 leading-tight text-gray-700 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
        </label>
        <label class="flex custom-label sm:mx-4">
          <div class="flex items-center justify-center w-6 h-6 p-1 mr-2 bg-white shadow">
            <input type="checkbox" class="hidden" name="is_public" value="{{ $image->is_public ? '1' : '0' }}" {{ $image->is_public ? 'checked' : '' }}>
            <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
          </div>
          <span class="text-gray-700 dark:text-gray-100"> {{ __('Public') }}</span>
        </label>  
        <button type="submit" class="px-4 py-2 mt-4 font-bold text-white bg-indigo-700 rounded shadow hover:bg-indigo-800 focus:shadow-outline focus:outline-none sm:mx-4 sm:mt-0">
          <i class="fas fa-save"></i> {{ __('Save') }}
        </button>
        <a href="#" onclick="deleteImage()" class="px-4 py-2 mt-4 font-bold text-white bg-red-700 rounded shadow hover:bg-red-800 focus:shadow-outline focus:outline-none sm:mx-4 sm:mt-0">
          <i class="fas fa-trash-alt"></i> {{ __('Delete') }}
        </a>
      </div>
    </form>
  @endownsImage
  <div class="sm:flex sm:flex-row">
    <div class="sm:w-3/4">
      <div class="relative flex items-center justify-center max-w-full overflow-hidden bg-gray-100 rounded shadow dark:bg-asphalt sm:min-h-12">
        <img src="{{ route('image.show', ['image' => $image->fullname]) }}">
      </div>
    </div>
    <div class="my-6 ml-6 sm:my-0">
      <div class="ml-16">
        <h3 class="pb-3 -ml-2 text-2xl font-medium text-gray-900 dark:text-gray-100 font-firacode">Image Tools</h3>
        <div class="h-10 mt-3 mb-4 w-36 sm:mt-0 sm:mr-3 custom-number-input">
          <div class="relative flex flex-row w-full h-10 bg-transparent rounded-lg">
            <input type="number" id="userInput" placeholder="Size" class="flex items-center w-full max-w-full font-semibold text-center text-gray-700 bg-gray-300 outline-none focus:outline-none text-md hover:text-black focus:text-black md:text-basecursor-default">
            <a href="#" onclick="javascript:changeText();location.reload();" target="_nofollow" id=lnk class="p-2 pr-4 font-semibold text-center text-gray-700 bg-gray-300">Go</a>
          </div>
        </div>
        <a href="{{ route('image.download', ['image' => $image->pageName]) }}">
          <button class="block px-4 py-2 mb-4 font-semibold text-gray-900 bg-transparent border rounded hover:bg-gray-600 hover:text-white dark:text-gray-200 w-36 border-grey hover:border-transparent">
            <i class="fa fa-download"></i> {{ __('Download') }}
          </button>
        </a>
        <div x-data="{ open: false }">
            <button @click="open = true" class="block px-4 py-2 my-4 font-semibold text-gray-900 bg-transparent border rounded hover:bg-gray-600 hover:text-white dark:text-gray-200 w-36 border-grey hover:border-transparent">
                <i class="fas fa-code"></i> {{ __('Embed') }}
            </button>

            <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full" style="background-color: rgba(0,0,0,.5);" x-show="open"  x-description="Background overlay, show/hide based on modal state." x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity">
                <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0" @click.away="open = false">
                    @include('image.embed-modal')
                </div>
            </div>
        </div>
        <div x-data="{ open: false }">
            <button @click="open = true" class="block px-4 py-2 my-4 font-semibold text-gray-900 bg-transparent border rounded hover:bg-gray-600 hover:text-white dark:text-gray-200 w-36 border-grey hover:border-transparent">
                <i class="fas fa-globe-europe"></i> {{ __('BBCode') }}
            </button>

            <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full" style="background-color: rgba(0,0,0,.5);" x-show="open"  x-description="Background overlay, show/hide based on modal state." x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity">
                <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0" @click.away="open = false">
                    @include('image.bbcode-modal')
                </div>
            </div>
        </div>
      </div>
      @if ($image->user->id == 1)
      <a class="flex items-center pt-4" href="{{ route('register') }}">
        <img class="w-10 h-10 mr-4 rounded-full" src="{{ url($image->user->avatar) }}" alt="Anonyme User">
        <div class="text-sm">
        <p class="leading-none text-gray-900 dark:text-gray-300">Anonyme | Signup Now !</p>
        <p class="text-gray-600">{{ $image->created_at->format('d/m/Y') }} ({{ $image->created_at->diffForHumans() }})</p>
        </div>
      </a>
      @else
      <a class="flex items-center pt-4" href="{{ route('profile', $image->user->username) }}">
        <img class="w-10 h-10 mr-4 rounded-full" src="{{ url($image->user->avatar) }}" alt="{{ $image->user->username }}'s image'">
        <div class="text-sm">
        <p class="leading-none text-gray-900 dark:text-gray-300">{{ $image->user->username }}</p>
        <p class="text-gray-600">{{ $image->created_at->format('d/m/Y') }} ({{ $image->created_at->diffForHumans() }})</p>
        </div>
      </a>
      @endif
    </div>
  </div>

  </div>
  @endisNotPublic
</div>
@endsection

@section('javascripts')
<script>
function deleteImage() {
  swal({
    title: "Are you sure?",
    text: "Once deleted, you will not be able to recover this imaginary file!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      window.location = "{{ route('image.delete', ['image' => $image->pageName]) }}";
    }
  });
}
</script>
<script>
function changeText(){
    var userInput = document.getElementById('userInput').value;
    var lnk = document.getElementById('lnk');
    lnk.href = "{{ route('image.show', ['image' => $image->fullname]) }}/" + userInput;
    lnk.innerHTML = lnk.href;
}
</script>
<script>
function copyEmbed() {
  var copyText = document.getElementById("embed");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
}
</script>
<script>
function copyBbcode() {
  var copyText = document.getElementById("bbcode");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
}
</script>
@endsection