<div class="bg-amber-800 pt-8 pb-7 px-4 sm:px-6 lg:px-8 shadow-inner">
    <h3 class="text-center mb-6 font-bold text-amber-100 text-3xl tracking-wide">Search Hotel By Your Location</h3>

    <!-- Search Input -->
    <div class="flex justify-center">
        <input wire:model.live.debounce.500ms='search' type="text"
            class="text-center text-amber-800 bg-amber-100 rounded-full p-2 w-full max-w-md mb-5 shadow focus:outline-none focus:ring-2 focus:ring-black placeholder:text-amber-800"
            placeholder="Search here...">
    </div>

    <!-- See All Button -->
    <div class="px-0 sm:px-6 mb-4 flex">
        <a href="/hotelAll" wire:navigate
            class="ml-auto text-sm font-semibold bg-amber-100 text-amber-800 hover:bg-amber-200 hover:text-amber-900 rounded-full px-2 py-1 shadow-sm">
            See all
        </a>
    </div>

    <!-- Hotel Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 px-0 sm:px-6">
        @forelse ($hotels as $hotel)
            <div class="bg-amber-100 rounded-2xl shadow-md p-4 hover:shadow-xl transition">
                <a wire:navigate href="/hotel/{{ $hotel->id }}/details" class="block space-y-3">
                    <div class="overflow-hidden rounded-lg">
                        <img src="{{ $hotel->thumbnail ? asset('storage/' . $hotel->thumbnail) : asset('storage/placeholder-image.png') }}"
                            alt="{{ $hotel->name }}"
                            class="h-48 w-full object-cover transition duration-500 ease-in-out hover:scale-105">
                    </div>

                    <h4 class="text-lg font-semibold text-gray-800 text-center">{{ $hotel->name }}</h4>
                    <p class="text-gray-800 text-sm line-clamp-1">{{ $hotel->description }}</p>
                    <p class="text-gray-800 text-sm font-bold">{{ $hotel->city }}, {{ $hotel->address }}</p>

                    <div class="flex items-center justify-between pt-2">
                        <div class="flex items-center space-x-1">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $hotel->rating)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                        class="w-5 h-5 text-yellow-500">
                                        <path d="M22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27
                                            18.18 21l-1.64-7.03L22 9.24z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21
                                            12 17.27 18.18 21l-1.64-7.03L22 9.24z" />
                                    </svg>
                                @endif
                            @endfor
                            <span class="ml-2 text-sm text-gray-600 font-bold">{{ $hotel->rating }}</span>
                        </div>

                        <span
                            class="text-sm font-bold capitalize px-3 py-1 {{ $hotel->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-full shadow-inner">
                            {{ $hotel->status }}
                        </span>
                    </div>
                </a>
            </div>
        @empty
            <div
                class="col-span-1 sm:col-span-2 md:col-span-2 lg:col-span-4 flex flex-col items-center justify-center h-64">
                <label class="mb-3 text-amber-100">No Hotel Available</label>
                <img src="{{ asset('images/placeholder-image.png') }}" alt="Thumbnail"
                    class="w-32 h-32 object-cover rounded-lg">
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $hotels->links('components.pagination', data: ['scrollTo' => false]) }}
    </div>

</div>
