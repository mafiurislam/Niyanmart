@if ($paginator->hasPages())
    <nav class="custom-pagination" role="navigation" aria-label="Pagination Navigation">
        <div class="pagination-info">
            Showing
            <span class="pagination-highlight">{{ $paginator->firstItem() }}</span>
            to
            <span class="pagination-highlight">{{ $paginator->lastItem() }}</span>
            of
            <span class="pagination-highlight">{{ $paginator->total() }}</span>
            results
        </div>

        <ul class="pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="Previous page">
                    <span class="page-link page-link-prev">
                        <i class="bi bi-chevron-left" aria-hidden="true"></i>
                        <span class="page-link-text">Prev</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link page-link-prev" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page">
                        <i class="bi bi-chevron-left" aria-hidden="true"></i>
                        <span class="page-link-text">Prev</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link page-link-dots">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link page-link-next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page">
                        <span class="page-link-text">Next</span>
                        <i class="bi bi-chevron-right" aria-hidden="true"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="Next page">
                    <span class="page-link page-link-next">
                        <span class="page-link-text">Next</span>
                        <i class="bi bi-chevron-right" aria-hidden="true"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
