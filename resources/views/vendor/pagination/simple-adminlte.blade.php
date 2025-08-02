@if ($paginator->hasPages())
    <nav aria-label="Pagination Navigation">
        <ul class="pagination pagination-sm m-0 float-right">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link"><i class="fas fa-angle-left"></i> Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-angle-left"></i> Previous</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next <i class="fas fa-angle-right"></i></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">Next <i class="fas fa-angle-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
