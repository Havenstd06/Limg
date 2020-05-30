@extends('layouts.app')

@section('content')
<div class="px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md dark:bg-midnight sm:container sm:mx-auto sm:w-full">
  <div class="text-black dark:text-gray-300">
    <h2 class="text-2xl font-bold md:text-4xl">Drag And Drop</h2>
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data" id="my-awesome-dropzone" class="max-w-lg text-lg font-medium border border-2 border-gray-300 border-dashed rounded-md cursor-pointer dark:bg-transparent dark:text-gray-100 dropzone">
      @csrf
    </form>
  </div>
</div>
@endsection

@section('javascripts')
<script>
  Dropzone.options.myAwesomeDropzone = {
    dictDefaultMessage: '<i class="mb-1 far fa-file-image fa-3x"></i> <p class="mt-1 text-sm text-gray-300"> <span class="font-medium text-indigo-500 transition duration-150 ease-in-out hover:text-indigo-400 focus:outline-none focus:underline">Upload a file</span> or drag and drop </p> <p class="mt-1 text-xs text-gray-300">PNG, JPG, GIF up to 15MB</p> ',
    paramName: "image",
    maxFilesize: 15,
    acceptedFiles: 'image/*',
    @auth
    init: function() {
      myDropzone = this;
      this.on('addedfile', function(file) {
        file.previewElement.addEventListener("click", function () {
            window.location.replace('{{ route('user.gallery', ['user' => auth()->user()]) }}');
        });
      })
      console.log('error')
    }
    @endauth
  };
</script>
@endsection