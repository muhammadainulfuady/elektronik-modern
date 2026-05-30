@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">

        <div class="flex gap-2 items-center justify-between sm:hidden w-full">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-g400 bg-g50 border border-g200 cursor-not-allowed rounded-xl transition-all h-[42px]">
                    <i class="fi fi-rr-angle-small-left mr-1"></i> {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-g700 bg-white border border-g200 rounded-xl hover:text-primary hover:border-primary focus:outline-none transition-all shadow-sm h-[42px]">
                    <i class="fi fi-rr-angle-small-left mr-1"></i> {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-g700 bg-white border border-g200 rounded-xl hover:text-primary hover:border-primary focus:outline-none transition-all shadow-sm h-[42px]">
                    {!! __('pagination.next') !!} <i class="fi fi-rr-angle-small-right ml-1"></i>
                </a>
            @else
                <span class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-g400 bg-g50 border border-g200 cursor-not-allowed rounded-xl transition-all h-[42px]">
                    {!! __('pagination.next') !!} <i class="fi fi-rr-angle-small-right ml-1"></i>
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-[13px] font-medium text-g500">
                    Menampilkan
                    @if ($paginator->firstItem())
                        <span class="font-extrabold text-g900">{{ $paginator->firstItem() }}</span>
                        sampai
                        <span class="font-extrabold text-g900">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    dari
                    <span class="font-extrabold text-g900">{{ $paginator->total() }}</span>
                    hasil
                </p>
            </div>

            <div>
                <span class="inline-flex items-center gap-2">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="inline-flex items-center justify-center w-10 h-10 text-lg text-g400 bg-g50 border border-g200 cursor-not-allowed rounded-xl" aria-hidden="true">
                                <i class="fi fi-rr-angle-small-left mt-1"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center w-10 h-10 text-lg text-g700 bg-white border border-g200 rounded-xl hover:text-primary hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all shadow-sm" aria-label="{{ __('pagination.previous') }}">
                            <i class="fi fi-rr-angle-small-left mt-1"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="inline-flex items-center justify-center w-10 h-10 text-[13px] font-extrabold text-g400 cursor-default">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="inline-flex items-center justify-center w-10 h-10 text-[13px] font-extrabold text-white bg-primary shadow-[0_4px_12px_rgba(26,92,255,0.3)] rounded-xl">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center justify-center w-10 h-10 text-[13px] font-extrabold text-g700 bg-white border border-g200 rounded-xl hover:text-primary hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all shadow-sm" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center w-10 h-10 text-lg text-g700 bg-white border border-g200 rounded-xl hover:text-primary hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all shadow-sm" aria-label="{{ __('pagination.next') }}">
                            <i class="fi fi-rr-angle-small-right mt-1"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="inline-flex items-center justify-center w-10 h-10 text-lg text-g400 bg-g50 border border-g200 cursor-not-allowed rounded-xl" aria-hidden="true">
                                <i class="fi fi-rr-angle-small-right mt-1"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
