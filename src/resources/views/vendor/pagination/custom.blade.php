@if ($paginator->hasPages())
    <nav class="inline-flex items-center space-x-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 bg-gray-200 text-gray-500 rounded cursor-not-allowed">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-2 bg-gray-200 text-gray-500 rounded">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 bg-blue-600 text-white rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-blue-500 hover:text-white transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">&raquo;</a>
        @else
            <span class="px-3 py-2 bg-gray-200 text-gray-500 rounded cursor-not-allowed">&raquo;</span>
        @endif
    </nav>
@endif
