@inject('paginationService', 'App\Services\PaginationService')

<!--Start Pagination Area-->
@if($paginationTools->pagesNumber > 0)
    <nav aria-label="Page navigation">
        <ul class="pagination">
            @if($paginationTools->previousPage !== 0)
                <li class="page-item">
                    <a class="page-link text-theme-1" href="{{ $paginationService->getPageUrl($paginationTools->url, $paginationTools->previousPage) }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">@lang('general.previous')</span>
                    </a>
                </li>
                @for($i = $paginationTools->currentPage -  $paginationTools->itemsBeforeAndAfter; $i < $paginationTools->currentPage; $i++)
                    @if($i > 0)
                        <li class="page-item">
                            <a class="page-link text-theme-1" href="{{ $paginationService->getPageUrl($paginationTools->url, $i) }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endif
                @endfor
            @endif

            <li class="page-item active">
                <span class="bg-theme-1 border-theme-1">
                    {{ $paginationTools->currentPage }}
                    <span class="sr-only">(current)</span>
                </span>
            </li>

            @for($i = $paginationTools->currentPage + 1; $i <= $paginationTools->pagesNumber; $i++)
                <li class="page-item">
                    <a class="page-link text-theme-1" href="{{ $paginationService->getPageUrl($paginationTools->url, $i) }}">
                        {{ $i }}
                    </a>
                </li>
                @if($i >= $paginationTools->currentPage + $paginationTools->itemsBeforeAndAfter)
                    @break
                @endif
            @endfor

            @if($paginationTools->nextPage !== 0)
                <li class="page-item">
                    <a class="page-link text-theme-1" href="{{ $paginationService->getPageUrl($paginationTools->url, $paginationTools->nextPage) }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">@lang('general.next')</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
<!--End Pagination Area-->