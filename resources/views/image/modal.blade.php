<!--Embed modal-->
<div class="fixed top-0 left-0 flex items-center justify-center w-full h-full opacity-0 pointer-events-none modal">
  <div class="absolute w-full h-full bg-gray-900 opacity-50 modal-overlay"></div>
  <div class="z-50 w-11/12 mx-auto overflow-y-auto bg-white rounded shadow-lg modal-container md:max-w-md">
    <div class="absolute top-0 right-0 z-50 flex flex-col items-center mt-4 mr-4 text-sm text-white cursor-pointer modal-close">
      <svg class="text-white fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
      </svg>
      <span class="text-sm">(Esc)</span>
    </div>
    <div class="px-6 py-4 text-left modal-content">
      <div class="flex items-center justify-between pb-3">
        <p class="text-2xl font-bold">Embed Code</p>
        <div class="z-50 cursor-pointer modal-close">
          <svg class="text-black fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
          </svg>
        </div>
      </div>
      <textarea name="image" id="embed" cols="55" rows="4" class="p-1 bg-gray-100 border"><a href="{{ route('image.show', ['image' => $image->name]) }}"><img src="{{ route('image.show', ['image' => $image->fullname]) }}" alt="LaraImg" title="{{ $image->title ? $image->title . ' - LaraImg' : 'LaraImg' }}"></a></textarea>
      <div class="flex justify-center">
        <p class="text-center text-md">
          To change the image size add <code class="bg-gray-500">/{Size}</code> at the end of the link in &lt;img.>
        </p>
      </div>
      <div class="flex justify-end pt-4">
        <button class="p-3 px-4 text-white bg-indigo-600 rounded-lg hover:bg-indigo-800" onclick="copyEmbed()">Copie</button>
      </div>
    </div>
    <hr>
    <div class="px-6 py-4 text-left modal-content">
      <div class="flex items-center justify-between pb-3">
        <p class="text-2xl font-bold">BBCode</p>
      </div>
      <textarea name="image" id="bbcode" cols="55" rows="4" class="p-1 bg-gray-100 border">[url={{ route('image.show', ['image' => $image->name]) }}][img]{{ route('image.show', ['image' => $image->fullname]) }}[/img][/url]</textarea>
      <div class="flex justify-center">
        <p class="text-center text-md">
          To change the image size add <code class="bg-gray-500">/{Size}</code> at the end of the link [img]
        </p>
      </div>
      <div class="flex justify-end pt-4">
        <button class="p-3 px-4 text-white bg-indigo-600 rounded-lg hover:bg-indigo-800" onclick="copyBbcode()">Copie</button>
      </div>
    </div>
  </div>
</div>
<script>
  var openmodal = document.querySelectorAll('.modal-open-tools')
  for (var i = 0; i < openmodal.length; i++) {
    openmodal[i].addEventListener('click', function(event){
    event.preventDefault()
    toggleModal()
    })
  }
  
  const overlay = document.querySelector('.modal-overlay')
  overlay.addEventListener('click', toggleModal)
  
  document.onkeydown = function(evt) {
    evt = evt || window.event
    var isEscape = false
    if ("key" in evt) {
    isEscape = (evt.key === "Escape" || evt.key === "Esc")
    } else {
    isEscape = (evt.keyCode === 27)
    }
    if (isEscape && document.body.classList.contains('modal-active')) {
    toggleModal()
    }
  };
  
  
  function toggleModal () {
    const body = document.querySelector('body')
    const modal = document.querySelector('.modal')
    modal.classList.toggle('opacity-0')
    modal.classList.toggle('pointer-events-none')
    body.classList.toggle('modal-active')
  }
  
</script>
<style>
  input[type='number']::-webkit-inner-spin-button,
  input[type='number']::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  .custom-number-input input:focus {
    outline: none !important;
  }

  .custom-number-input button:focus {
    outline: none !important;
  }
</style>
<script>
  function decrement(e) {
    const btn = e.target.parentNode.parentElement.querySelector(
      'button[data-action="decrement"]'
    );
    const target = btn.nextElementSibling;
    let value = Number(target.value);
    value--;
    target.value = value;
  }

  function increment(e) {
    const btn = e.target.parentNode.parentElement.querySelector(
      'button[data-action="decrement"]'
    );
    const target = btn.nextElementSibling;
    let value = Number(target.value);
    value++;
    target.value = value;
  }

  const decrementButtons = document.querySelectorAll(
    `button[data-action="decrement"]`
  );

  const incrementButtons = document.querySelectorAll(
    `button[data-action="increment"]`
  );

  decrementButtons.forEach(btn => {
    btn.addEventListener("click", decrement);
  });

  incrementButtons.forEach(btn => {
    btn.addEventListener("click", increment);
  });
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