@extends('layouts.app')

@section('content')
<section class="container flex items-center justify-center min-h-full py-5 mx-auto -mt-10 lg:justify-start ">
  <div class="flex flex-wrap items-center -mx-2 text-center lg:text-left">
    <div class="hidden px-2 mx-auto lg:block lg:w-1/2">      
      <img src="/images/home/image-bg.svg" alt="Limg">     
      <div class="mt-3 text-2xl font-bold text-center text-gray-800 dark:text-gray-50">
        Already <span class="text-indigo-500">{{ App\Image::count() }}</span> Images Uploaded !
      </div>
    </div> 
    <div class="min-h-full px-2 mt-10 lg:w-1/2 lg:pl-16 lg:mt-0 ">
      <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-50">
        <span class="text-indigo-500">Limg</span>.App
      </h2>
      <h2 class="mt-4 text-4xl leading-tight text-gray-800 font-heading dark:text-gray-50">
        <a href="https://github.com/Havenstd06/Limg" target="_nofollow" class="text-gray-600 dark:text-gray-400 dark-hover:text-gray-500 hover:text-gray-700">Open Source</a> Image Hosting
      </h2>
      <h4 class="mt-2 mb-4 text-xl leading-tight text-gray-800 font-heading dark:text-gray-50">
        Upload png, jpeg, jpg and gif now !
      </h4>
      <div class="max-w-lg mx-auto lg:mx-0 " x-data="{ tab: 'drop' }">
        <div class="mb-3 md:mb-0">
          <nav class="flex mb-3">
            <button @click="tab = 'drop'" class="px-3 py-2 ml-4 text-sm font-medium leading-5 rounded-md focus:outline-none"
            :class="{ 'text-indigo-700 bg-indigo-100 focus:text-indigo-800 focus:bg-indigo-200': tab === 'drop', 'dark:text-gray-300 dark-hover:text-gray-400 text-gray-600 hover:text-gray-900 focus:text-indigo-600 focus:bg-indigo-50': tab !== 'drop' }">
              File
            </button>
            <button @click="tab = 'url'" class="px-3 py-2 ml-4 text-sm font-medium leading-5 rounded-md focus:outline-none"
            :class="{ 'text-indigo-700 bg-indigo-100 focus:text-indigo-800 focus:bg-indigo-200': tab === 'url', 'dark:text-gray-300 dark-hover:text-gray-400 text-gray-600 hover:text-gray-900 focus:text-indigo-600 focus:bg-indigo-50': tab !== 'url' }">
              URL
            </button>
            <button @click="tab = 'sharex'" class="px-3 py-2 ml-4 text-sm font-medium leading-5 rounded-md focus:outline-none"
            :class="{ 'text-indigo-700 bg-indigo-100 focus:text-indigo-800 focus:bg-indigo-200': tab === 'sharex', 'dark:text-gray-300 dark-hover:text-gray-400 text-gray-600 hover:text-gray-900 focus:text-indigo-600 focus:bg-indigo-50': tab !== 'sharex' }">
              ShareX
            </button>
          </nav>
          <div x-cloak x-show="tab === 'drop'">
            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data" id="my-awesome-dropzone" class="text-lg font-medium border border-gray-300 border-dashed rounded-md cursor-pointer dark:bg-transparent dark:text-gray-100 dropzone">
              @csrf
            </form>
            <p class="mt-1 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
              Drag and drop files inside the box to start upload images. 15 MB per image.
            </p>
          </div>
          <div x-cloak x-show="tab === 'url'">
            <form action="{{ route('url_upload') }}" method="POST">
              @csrf
              <textarea name="url" class="w-full p-2 border border-gray-300 border-dashed rounded-md h-41 bg-gray-50 focus:outline-none dark:bg-transparent dark:text-gray-100" style="resize: none;" 
              placeholder="1 link per line. Example:
https://limg.app/i/Amused-Ant-True-Crime:-Matador-Shootout-xFfLW9.jpg
https://limg.app/i/Fantastic-Flamingo-Shrunken-Florist-Mania-pPCnYd.jpg"></textarea>
              <div class="flex justify-end">
                @auth
                <div class="flex text-gray-800 dark:text-gray-50">
                  <input type="checkbox" name="is_public" title="Is Public" value="{{ $user->always_public ? '1' : '0' }}" {{ $user->always_public ? 'checked' : '' }} class="w-4 h-4 mt-3 ml-2 text-indigo-600 transition duration-150 ease-in-out rounded-full form-checkbox">
                  <p class="mt-2 ml-2">Public</p>
                </div>
                @endauth
                <div class="">
                  <button class="px-4 py-2 ml-3 transition duration-300 ease-out bg-indigo-600 rounded text-gray-50 hover:bg-indigo-700 focus:outline-none">Send</button>
                </div>
              </div>
            </form>
            <p class="mt-1 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
              Paste image links to start uploading images. 15 MB per image.
            </p>
          </div>
          <div x-cloak x-show="tab === 'sharex'">
            <textarea id="sharex" class="w-full p-2 text-sm border border-gray-300 border-dashed rounded-md h-41 bg-gray-50 focus:outline-none dark:bg-transparent dark:text-gray-100" style="resize: none;" spellcheck="false">{
"Name": "{{ config('app.name') }}",
"DestinationType": "ImageUploader",
"RequestURL": "{{ route('api_upload') }}",
"FileFormName": "file",
"Arguments": {
    "key": "@auth{{ auth()->user()->api_token }}@else{{ App\User::findOrFail(1)->api_token }}@endif",
    "file": "%guid"
},
"URL": "$json:image.url$"
}</textarea>
            <button class="px-4 py-2 transition duration-300 ease-out bg-indigo-600 rounded text-gray-50 hover:bg-indigo-700 focus:outline-none" onclick=saveShareXFile(sharex.value,'ShareX-{{ config('app.name') }}.sxcu')>Download</button>
            <p class="mt-1 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
              @auth 
              Download the <a href="https://getsharex.com/" target="no_follow" class="text-indigo-500 hover:text-indigo-600">ShareX</a> configuration linked to your account via a token.
              @else 
              Download the <a href="https://getsharex.com/" target="no_follow" class="text-indigo-500 hover:text-indigo-600">ShareX</a> public image configuration, <a href="{{ route('register') }}" class="text-indigo-500 hover:text-indigo-600">create an accout now</a>.
              @endauth
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('javascripts')
<script>
  Dropzone.options.myAwesomeDropzone = {
    dictDefaultMessage: '<i class="mb-1 text-gray-900 dark:text-gray-300 far fa-file-image fa-3x"></i> <p class="mt-1 text-sm text-gray-800 dark:text-gray-300"> <span class="font-medium text-indigo-500 transition duration-150 ease-in-out hover:text-indigo-400 focus:outline-none focus:underline">Upload a file</span> or drag and drop </p> <p class="mt-1 text-xs text-gray-800 dark:text-gray-300">PNG, JPG, GIF up to 15MB</p> ',
    paramName: "image",
    maxFilesize: 15,
    acceptedFiles: 'image/*',
    init: function() {
      myDropzone = this;
      this.on('success', function(file, response) {
        file.previewElement.addEventListener("click", function () {
            window.location.replace(response);
        });
      })
    }
  };
</script>
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