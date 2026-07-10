<style>
    /* Custom Pagination Styles */
    .pagination { display: flex; list-style: none; padding: 0; margin: 0; gap: 0.5rem; flex-wrap: wrap; align-items: center; justify-content: center; }
    .pagination li { display: inline-block; margin: 0; }
    .pagination li a, .pagination li span { display: flex; align-items: center; justify-content: center; min-width: 2.25rem; height: 2.25rem; padding: 0 0.5rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; background: white; color: #4b5563; text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: all 0.2s; box-sizing: border-box; }
    .pagination li a:hover { background: #f3f4f6; color: #111827; border-color: #d1d5db; }
    .pagination li.active span { background: #10b981; color: white; border-color: #10b981; }
    .pagination li.disabled span { color: #9ca3af; background: #f9fafb; cursor: not-allowed; border-color: #e5e7eb; }
</style>

@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
