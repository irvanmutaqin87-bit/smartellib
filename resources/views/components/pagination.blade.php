@if ($paginator->hasPages())
<div id="paginationWrapper"
    class="flex items-center justify-center gap-1.5 py-4 border-t border-slate-100">

    {{-- PREV --}}
    <a href="{{ $paginator->previousPageUrl() }}"
        class="pagination-link w-9 h-9 flex items-center justify-center rounded-lg
        transition-all duration-200 hover:bg-slate-100 hover:text-slate-700
        hover:scale-105 active:scale-95
        {{ $paginator->onFirstPage() ? 'opacity-30 pointer-events-none' : '' }}">
        
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
            class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" 
                d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
    </a>

    {{-- NUMBERS --}}
    @foreach ($paginator->getUrlRange(
        max(1, $paginator->currentPage() - 2),
        min($paginator->lastPage(), $paginator->currentPage() + 2)
    ) as $page => $url)

        @if ($page == $paginator->currentPage())
            <span class="w-9 h-9 bg-slate-700 text-white flex items-center justify-center rounded-lg text-sm font-medium shadow-sm">
                {{ $page }}
            </span>
        @else
            <a href="{{ $url }}" 
               class="pagination-link w-9 h-9 flex items-center justify-center rounded-lg
               text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-800
               transition-all duration-200">
                {{ $page }}
            </a>
        @endif

    @endforeach

    {{-- NEXT --}}
    <a href="{{ $paginator->nextPageUrl() }}"
        class="pagination-link w-9 h-9 flex items-center justify-center rounded-lg
        transition-all duration-200 hover:bg-slate-100 hover:text-slate-700
        hover:scale-105 active:scale-95
        {{ !$paginator->hasMorePages() ? 'opacity-30 pointer-events-none' : '' }}">
        
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
            class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" 
                d="M8.25 4.5L15.75 12l-7.5 7.5" />
        </svg>
    </a>

</div>
@endif