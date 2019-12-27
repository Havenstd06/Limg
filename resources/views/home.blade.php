@extends('layouts.app')

@section('content')
<div class="w-full mx-auto text-center md:w-1/2">
    <div class="flex items-center justify-center w-full">
        <img src="{{ url('images/logo.svg')}}" alt="LaraImg" class="w-36">
        <h2 class="text-4xl font-bold leading-none xs:text-2x1 md:text-5xl lg:6x1">
            <span class="text-blue-700">Lara</span><span class="text-purple-600">Img</span>
        </h2>
    </div>
    <p class="px-10 mt-12 mb-12 text-base sm:text-2xl sm:px-0"> An 
        <a href="http://" class="font-bold text-gray-800">Open-Source</a> 
        image hosting service powered by 
        <a href="http://laravel.com" class="font-bold text-gray-800">Laravel</a>
    </p>

</div>

<div class="flex items-center justify-center w-full">
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label id="image-drop" class="flex flex-col items-center w-64 px-4 py-6 tracking-wide text-blue-500 uppercase bg-white border border-blue-600 rounded-lg shadow-lg cursor-pointer hover:bg-blue-400 hover:text-white" for="image-upload">
            <i class="far fa-file-image fa-2x"></i>
            <span class="mt-2 text-base leading-normal text-center">
                <strong>Click or drop a image</strong>
            </span>
            <input class="hidden opacity-0 sm:absolute sm:-ml-0 sm:-mt-6 sm:h-30 sm:w-64 sm:block" id="image-upload" type="file" accept="image/*" name="image" aria-describedby="image" onChange="form.submit()"/>
        </label>
    </form>
</div>
@endsection

@section('javascripts')
<script>
    var fileInput = document.querySelector('input[type=file]');
    var dropzone = document.querySelector('label#image-drop');

    fileInput.addEventListener('dragenter', function () {
    dropzone.classList.remove('text-blue-500', 'bg-white');
    dropzone.classList.add('text-white', 'bg-blue-400');
    });

    fileInput.addEventListener('dragleave', function () {
    dropzone.classList.remove('text-white', 'bg-blue-400');
    dropzone.classList.add('text-blue-500', 'bg-white');
    });
</script>
@endsection