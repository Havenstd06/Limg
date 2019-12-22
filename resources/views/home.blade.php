@extends('layouts.app')

@section('content')
<div class="md:w-1/2 w-full mx-auto text-center">
    <h2 class="leading-none font-bold text-3xl xs:text-2x1 md:text-5xl lg:6x1 uppercase">
        <span class="text-blue-700">Lara</span><span class="text-purple-600">Img</span>
    </h2>
    <p class="mt-12 mb-12 sm:text-2xl px-10 sm:px-0 text-base"> An 
        <a href="http://" class="text-gray-800 font-bold">Open-Source</a> 
        image hosting service powered by 
        <a href="http://laravel.com" class="text-gray-800 font-bold">Laravel</a>
    </p>
</div>

@if ($image->path == null)
    <div class="flex w-full items-center justify-center">
        <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue-500 rounded-lg shadow-lg tracking-wide uppercase border border-blue-600 cursor-pointer hover:bg-blue-400 hover:text-white">
            <i class="far fa-file-image fa-2x"></i>
            <span class="mt-2 text-base leading-normal text-center">
                <strong>Choose a file</strong>
                {{-- <span> or drag it here</span>. Nah --}}
            </span>

            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <input type='file' class="hidden" id="image" name="image" onchange="form.submit()"/>
            </form>
        </label>
    </div>
@else

<p class="mt-12 mb-12 sm:text-2xl px-10 sm:px-0 text-base text-center">You will be redirected to your image page in 2 seconds ! :happy-face:</p>
<script type="text/javascript">
    function redir(){
        self.location.href="{{ route('image.show', ['image' => $image->name]) }}"
    }
    setTimeout(redir,2000)
</script>
@endif
@endsection
