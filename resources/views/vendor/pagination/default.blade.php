@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation">
    <ul class="flex justify-center text-sm">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li aria-label="@lang('pagination.previous')">
            <span class="block px-4 py-3 text-gray-500 border border-r-0 border-gray-300 rounded-l dark:text-gray-300"
                aria-hidden="true"><i class="fas fa-angle-left"></i></span>
        </li>
        @else
        <li>
            <button wire:click.prevent="previousPage" rel="prev"
                class="block px-4 py-3 text-blue-900 transition-all duration-150 border border-r-0 border-gray-300 rounded-l hover:text-white hover:bg-blue-900 focus:outline-none focus:shadow-outline"
                aria-label="@lang('pagination.previous')">
                <i class="fas fa-angle-left"></i>
            </button>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li aria-disabled="true">
            <span class="hidden px-4 py-3 text-gray-500 border border-r-0 border-gray-300 md:block">{{ $element }}</span>
        </li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li aria-current="page">
            <span class="block px-4 py-3 text-white bg-blue-900 border border-r-0 border-gray-300">{{ $page }}</span>
        </li>
        @else
        <li>
            <button
                class="hidden px-4 py-3 text-blue-900 transition-all duration-150 border border-r-0 border-gray-300 dark:text-blue-500 md:block hover:text-white hover:bg-blue-900 focus:outline-none focus:shadow-outline"
                aria-label="@lang('pagination.goto_page', ['page' => $page])" wire:click="gotoPage({{ $page }})">
                {{ $page }}
            </button>
        </li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li>
            <button rel="next"
                class="block px-4 py-3 text-blue-900 transition-all duration-150 border border-gray-300 rounded-r dark:text-blue-500 hover:text-white hover:bg-blue-900 focus:outline-none focus:shadow-outline"
                aria-label="@lang('pagination.next')"
                wire:click.prevent="nextPage">
                <i class="fas fa-angle-right"></i>
            </button>
        </li>
        @else
        <li aria-disabled="true" aria-label="@lang('pagination.next')">
            <span
            class="block px-4 py-3 text-gray-500 border border-gray-300 rounded-r"
            aria-hidden="true"><i class="fas fa-angle-right"></i></span>
        </li>
        @endif
    </ul>
</nav>
@endif