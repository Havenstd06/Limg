<footer class="text-gray-200 bg-gray-800 dark:bg-midnight dark:text-white font-firacode" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
  <div class="flex flex-wrap items-center px-16 py-3">
    <div class="w-full text-center lg:w-1/5 lg:text-left">
      <a class="text-xl font-semibold text-white" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
    </div>
    <div class="w-full mt-4 text-center lg:w-3/5 lg:mt-0">
      <span class="block mx-3 mb-4 font-semibold md:inline-block md:mb-0">
        Made with <i :class="{ 'fas': hover === true }" class="far fa-heart"></i> by <a href="https://github.com/havenstd06" target="_nofollow">Havens</a> — 2019-{{ date('Y') }}
      </span>
    </div>
    <div class="flex justify-center w-full my-2 item-center lg:justify-end lg:w-1/5 lg:my-0">
      <a href="https://github.com/Havenstd06/Limg" target="_nofollow">
        <span class="relative mr-2 font-semibold" style="bottom:7px">Open-Source on GitHub</span> 
        <i class="fa-2x fab fa-github"></i>
      </a>
    </div>
  </div>
</footer>
