<div class="d-flex justify-content-center">
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm">
            @if ($items->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo; Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $items->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                </li>
            @endif

            @foreach ($items->links()->elements[0] as $page => $url)
                @if ($page == $items->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            @if ($items->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $items->nextPageUrl() }}" rel="next">Next &raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next &raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
</div>