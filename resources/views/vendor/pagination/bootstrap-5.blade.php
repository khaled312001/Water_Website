@if ($paginator->hasPages())
    <nav aria-label="صفحات النتائج" class="d-flex justify-content-center">
        <ul class="pagination pagination-lg mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link">
                        <i class="fas fa-chevron-right me-1"></i>
                        السابق
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fas fa-chevron-right me-1"></i>
                        السابق
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{{ $element }}</span>
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
                                <a class="page-link" href="{{ $url }}" aria-label="@lang('pagination.goto_page', ['page' => $page])">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        التالي
                        <i class="fas fa-chevron-left ms-1"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link">
                        التالي
                        <i class="fas fa-chevron-left ms-1"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>

    {{-- Results Info --}}
    <div class="text-center mt-3">
        <div class="pagination-info">
            <p class="mb-0">
                عرض 
                <span class="fw-bold">{{ $paginator->firstItem() ?? 0 }}</span>
                إلى 
                <span class="fw-bold">{{ $paginator->lastItem() ?? 0 }}</span>
                من 
                <span class="fw-bold">{{ $paginator->total() }}</span>
                نتيجة
            </p>
        </div>
    </div>
@endif
