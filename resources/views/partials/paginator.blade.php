@if ($paginator->hasPages())
    <div class="row align-items-center mt-4">
        <!-- Pagination Info -->
        <div class="col-sm-12 col-md-6">
            <div class="d-flex align-items-center">
                <small class="text-muted me-3">
                    <i class="fas fa-info-circle me-1"></i>
                    Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} 
                    of {{ $paginator->total() }} results
                </small>
                @if(request('search'))
                    <span class="badge bg-info text-white">
                        <i class="fas fa-search me-1"></i>
                        Filter: "{{ request('search') }}"
                        <a href="{{ url()->current() }}" class="text-white ms-1" title="Clear filter">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
            </div>
        </div>
        
        <!-- Pagination Navigation -->
        <div class="col-sm-12 col-md-6">
            <nav aria-label="Pagination navigation" role="navigation">
                <ul class="pagination pagination-sm justify-content-end mb-0">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link" tabindex="-1">
                                <i class="fas fa-chevron-left" aria-hidden="true"></i>
                                <span class="sr-only">Previous</span>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}" 
                               rel="prev" aria-label="Previous page">
                                <i class="fas fa-chevron-left" aria-hidden="true"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $start = max($paginator->currentPage() - 2, 1);
                        $end = min($start + 4, $paginator->lastPage());
                        $start = max($end - 4, 1);
                    @endphp

                    @if($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url(1) }}{{ request()->has('search') ? '&search=' . request('search') : '' }}">1</a>
                        </li>
                        @if($start > 2)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $paginator->url($page) }}{{ request()->has('search') ? '&search=' . request('search') : '' }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endfor

                    @if($end < $paginator->lastPage())
                        @if($end < $paginator->lastPage() - 1)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}{{ request()->has('search') ? '&search=' . request('search') : '' }}">{{ $paginator->lastPage() }}</a>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}" 
                               rel="next" aria-label="Next page">
                                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link" tabindex="-1">
                                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                <span class="sr-only">Next</span>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endif