@if ($paginator->hasPages())
    <nav class="sj-pagination">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="sj-prevpage"><span><i class="fa fa-angle-left"></i> {{ trans('prs.previous') }}</span></li>
            @else
                <li class="sj-prevpage"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"> <i class="fa fa-angle-left"></i> {{ trans('prs.previous') }}</a></li>
            @endif
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="sj-active"><span>0{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">0{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="sj-nextpage"><a href="{{ $paginator->nextPageUrl() }}" rel="next">{{ trans('prs.next') }} <i class="fa fa-angle-right"></i> </a></li>
            @else
                <li class="disabled sj-nextpage"><span>{{ trans('prs.next') }} <i class="fa fa-angle-right"></i> </span></li>
            @endif
        </ul>
    </nav>
@endif
