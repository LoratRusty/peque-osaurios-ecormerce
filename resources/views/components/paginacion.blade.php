@if ($paginator->hasPages())
    <div class="mt-6 sm:mt-8 flex justify-center">
        <div
            class="bg-white/80 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-lg border border-pink-200/50 p-2 w-full sm:w-auto overflow-x-auto">
            <div class="flex justify-center min-w-max">
                <ul class="pagination">
                    {{-- Botón Anterior --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">‹ Anterior</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Anterior</a>
                        </li>
                    @endif

                    {{-- Enlaces de páginas --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Botón Siguiente --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente ›</a>
                        </li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Siguiente ›</span></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif
