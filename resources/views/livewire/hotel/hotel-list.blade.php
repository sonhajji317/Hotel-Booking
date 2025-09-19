<div class="bg-amber-800 pt-6 pb-6 px-6 shadow-lg min-h-screen">
    <h2 class="text-center font-bold text-3xl text-amber-100 mb-2 drop-shadow">Melawai Hotel</h2>
    <div class="flex justify-center">
        <input wire:model.live.debounce.300ms='search' type="text"
            class="text-center bg-amber-100 text-amber-800 rounded-full p-2 w-full max-w-md mb-5 shadow focus:outline-none focus:ring-2 focus:ring-amber-500 placeholder:text-amber-800"
            placeholder="Search here...">
    </div>
    <div class="mb-4 flex justify-end">
        <a href="/hotelAdd" wire:navigate
            class="bg-amber-100 hover:bg-amber-200 text-amber-800 hover:text-amber-900 font-semibold py-1 px-2 text-sm rounded-full transition">
            + Hotel
        </a>
    </div>
    <div class="text-center">
        @if (session('success'))
            <small x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="bg-green-500 text-white font-bold p-3 rounded-full mb-4">
                {{ session('success') }}
            </small>
        @endif
    </div>
    <div class="overflow-x-auto rounded-lg shadow-md bg-amber-100">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-amber-200 text-center text-amber-800">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th wire:click="sortBy('name')" class="px-4 py-3 cursor-pointer">Name
                        @if ($sortField == 'name')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('address')" class="px-4 py-3 cursor-pointer">Address
                        @if ($sortField == 'address')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('city')" class="px-4 py-3 cursor-pointer">City
                        @if ($sortField == 'city')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Thumbnail</th>
                    <th wire:click="sortBy('rating')" class="px-4 py-3 cursor-pointer">Rating
                        @if ($sortField == 'rating')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('status')" class="px-4 py-3 cursor-pointer">Status
                        @if ($sortField == 'status')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-center">
                @forelse ($hotels as $hotel)
                    <tr class="hover:bg-amber-200 transition">
                        <td class="px-4 py-2">{{ $loop->iteration + $hotels->firstItem() - 1 }}</td>
                        <td class="px-4 py-2">{{ $hotel->name }}</td>
                        <td class="px-4 py-2">{{ $hotel->address }}</td>
                        <td class="px-4 py-2">{{ $hotel->city }}</td>
                        <td class="px-4 py-2 max-w-xs truncate" title="{{ $hotel->description }}">
                            {{ $hotel->description }}
                        </td>
                        <td class="px-4 py-2">
                            <img src="{{ asset('storage/' . $hotel->thumbnail) }}" alt="Thumbnail-hotel"
                                class="w-16 h-16 object-cover rounded-md mx-auto">
                        </td>
                        <td class="px-4 py-2">{{ $hotel->rating }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                {{ $hotel->status === 'active'
                                    ? 'bg-green-600'
                                    : ($hotel->status === 'inactive'
                                        ? 'bg-red-500'
                                        : 'bg-yellow-400 text-gray-900') }}">
                                {{ ucfirst($hotel->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex justify-center gap-2">
                                <a wire:navigate href="/hotel/{{ $hotel->id }}/edit"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-full text-sm transition">
                                    Edit
                                </a>
                                <button wire:navigate wire:click="delete({{ $hotel->id }})"
                                    wire:confirm='Are you sure want to delete this hotel?'
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm transition">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-4 text-gray-500">
                            No data available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $hotels->links('components.pagination', data: ['scrollTo' => false]) }}
    </div>
</div>
