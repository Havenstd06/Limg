@extends('layouts.app')

@section('content')
<div class="md:w-1/2 w-full mx-auto text-center">
    <div class="flex w-full items-center justify-center">
        <img src="{{ url('images/logo.svg')}}" alt="LaraImg" class="w-36">
        <h2 class="leading-none font-bold text-4xl xs:text-2x1 md:text-5xl lg:6x1">
            <span class="text-blue-700">Lara</span><span class="text-purple-600">Img</span>
        </h2>
    </div>
    <p class="mt-12 mb-12 sm:text-2xl px-10 sm:px-0 text-base"> An 
        <a href="http://" class="text-gray-800 font-bold">Open-Source</a> 
        image hosting service powered by 
        <a href="http://laravel.com" class="text-gray-800 font-bold">Laravel</a>
    </p>

</div>

<div class="flex w-full items-center justify-center">
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue-500 rounded-lg shadow-lg tracking-wide uppercase border border-blue-600 cursor-pointer hover:bg-blue-400 hover:text-white" for="image-upload">
            <i class="far fa-file-image fa-2x"></i>
            <span class="mt-2 text-base leading-normal text-center">
                <strong>Click or drop a image</strong>
            </span>
            <input class="sm:absolute sm:-ml-0 sm:-mt-6 sm:h-30 sm:w-64 sm:block hidden opacity-0" id="image-upload" type="file" name="image" aria-describedby="image" onChange="form.submit()"/>
        </label>
    </form>
</div>
@endsection
