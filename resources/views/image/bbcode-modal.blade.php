<!--bbcode modal-->
<div data-target="modal.container" data-action="click->modal#closeBackground keyup@window->modal#closeWithKeyboard" class="fixed inset-0 flex items-center justify-center hidden overflow-y-auto animated fadeIn" style="z-index: 9999;">
  <!-- Modal Inner Container -->
  <div class="relative w-full max-w-lg max-h-screen">
    <!-- Modal Card -->
    <div class="m-1 bg-white rounded shadow">
      <div class="p-8">
        <div class="text-left modal-content">
          <div class="flex items-center justify-between pb-3">
            <p class="text-2xl font-bold">BBCode</p>
            <div class="z-50 cursor-pointer modal-close">
              <svg class="text-black fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
              </svg>
            </div>
          </div>
          <textarea name="image" id="bbcode" cols="55" rows="4" class="p-1 bg-gray-100 border">[url={{ route('image.show', ['image' => $image->name]) }}][img]{{ route('image.show', ['image' => $image->fullname]) }}[/img][/url]</textarea>
          <div class="flex justify-center">
            <p class="text-center text-md">
              To change the image size add <code class="bg-gray-500">/{Size}</code> at the end of the link [img]
            </p>
          </div>
          <div class="flex justify-end pt-4">
            <button class="px-4 py-2 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-600"onclick="copyBbcode()">Copie</button>
            <button class="px-4 py-2 ml-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-600" data-action="click->modal#close">Close</button>
          </div>
        </div>
        </div>

    </div>
  </div>
</div>
