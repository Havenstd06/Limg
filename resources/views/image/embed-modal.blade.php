<div class="text-left">
  <div class="flex items-center justify-between pb-3">
    <p class="text-2xl font-bold">Embed Code</p>
    <div class="z-50 cursor-pointer" @click="open = false">
      <svg class="text-black fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
      </svg>
    </div>
  </div>
  <textarea name="image" id="embed" cols="55" rows="4" class="p-1 bg-gray-100 border"><a href="{{ route('image.show', ['image' => $image->pageName]) }}"><img src="{{ route('image.show', ['image' => $image->fullname]) }}" alt="Limg" title="{{ $image->title ? $image->title . ' - Limg' : 'Limg' }}"></a></textarea>
  <div class="flex justify-center">
    <p class="text-center text-md">
      To change the image size add <code class="bg-gray-500">/{Size}</code> at the end of the link in &lt;img.>
    </p>
  </div>
  <div class="flex justify-end pt-4">
    <button class="px-4 py-2 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-600" onclick="copyEmbed()">Copie</button>
    <button class="px-4 py-2 ml-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-600" @click="open = false">Close</button>
  </div>
</div>