@if ($paginator->hasPages())
    <div class="pagination mt-3 pt-4">
        <ul class="list-inline">
            @if ($paginator->onFirstPage())
            @else
                <li class="list-inline-item"><a class="prev-posts" href="{{ $paginator->previousPageUrl() }}">
                        <i class="ti-arrow-left"></i></a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="list-inline-item disabled">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="list-inline-item">
                                <a class="active">{{ $page }}</a>
                            </li>
                        @else
                            <li class="list-inline-item">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="list-inline-item"><a href="{{ $paginator->nextPageUrl() }}" class="prev-posts"><i
                            class="ti-arrow-right"></i></a></li>
            @else
            @endif
        </ul>
    </div>
@endif
