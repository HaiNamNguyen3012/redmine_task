<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 13/06/2022
 * Time: 11:13
 */
?>

@if(!empty($paginator))
    @if ($paginator->hasPages())
        <nav aria-label="Page navigation example" class="pagination-page">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    {{--                    <li class="page-item">--}}
                    {{--                        <a class="page-link disable">--}}
                    {{--                            <span aria-hidden="true"><11</span>--}}
                    {{--                            <span class="sr-only">Previous</span>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                            <span aria-hidden="true"><</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                @endif


                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item"><a class="disable">{{ $element }}</a></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                            <span aria-hidden="true">></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                @else
                    {{--                    <li class="page-item">--}}
                    {{--                        <a class="page-link disable">--}}
                    {{--                            <span aria-hidden="true">></span>--}}
                    {{--                            <span class="sr-only">Next</span>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}
                @endif
            </ul>
        </nav>
    @endif
@endif
