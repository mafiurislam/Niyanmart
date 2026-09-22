@if ($paginator->hasPages())
    <nav class="custom-pagination custom-pagination-simple" role="navigation" aria-label="Pagination Navigation">
        <ul class="pagination-list" style="margin: 0 auto;">
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
