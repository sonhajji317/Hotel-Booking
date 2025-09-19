@if ($paginator->hasPages())
    <nav class="flex justify-center mt-6">
        <ul class="inline-flex items-center space-x-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-2 text-amber-100">&laquo;</span>
                </li>
            @else
                <li>
                    <button wire:click="previousPage"
                        class="px-3 py-2 rounded-lg bg-amber-300 text-amber-800 hover:ring-2 hover:ring-amber-500 transition duration-200">&laquo;</button>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="px-3 py-2 text-gray-400">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span
                                    class="px-2 py-2 font-bold text-amber-800 bg-amber-500 rounded-lg shadow-md">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <button wire:click="gotoPage({{ $page }})"
                                    class="px-2 py-2 rounded-lg bg-amber-300 text-amber-800 hover:ring-2 hover:ring-amber-500 transition duration-200">
                                    {{ $page }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button wire:click="nextPage"
                        class="px-3 py-2 rounded-lg bg-amber-300 text-amber-800 hover:ring-2 hover:ring-amber-500 transition duration-200">&raquo;</button>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 text-amber-100">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
