<div class="bg-amber-800 pt-6 pb-6 px-6 shadow-lg min-h-screen">
    <h2 class="text-center font-bold text-3xl text-amber-100 mb-2 drop-shadow">Melawai Hotel</h2>
    <div class="flex justify-center">
        <input wire:model.live.debounce.300ms='search' type="text"
            class="text-center bg-amber-100 text-gray-800 rounded-full p-2 w-full max-w-md mb-5 shadow focus:outline-none focus:ring-2 focus:ring-amber-400 placeholder:text-amber-800"
            placeholder="Search here...">
    </div>
    <div class="mb-4 flex justify-end">
        <a href="/roomTypeAdd" wire:navigate
            class="bg-amber-100 hover:bg-amber-200 text-amber-800 hover:text-amber-900 font-semibold py-1 px-2 text-sm rounded-full transition">
            + Room Type
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
                    <th wire:click="sortBy('name')" class="px-4 py-3 cursor-pointer">Room Type Name
                        @if ($sortField === 'name')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('capacity')" class="px-4 py-3 cursor-pointer">Capacity
                        @if ($sortField === 'capacity')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('price')" class="px-4 py-3 cursor-pointer">Price
                        @if ($sortField === 'price')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th class="px-4 py-3">Room View</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-amber-200 text-center">
                @forelse ($room_types as $room_type)
                    <tr class="hover:bg-amber-200 transition">
                        <td class="px-4 py-2">{{ $loop->iteration + $room_types->firstItem() - 1 }}</td>
                        <td class="px-4 py-2">{{ $room_type->name }}</td>
                        <td class="px-4 py-2">{{ $room_type->capacity }}</td>
                        <td class="px-4 py-2">IDR {{ number_format($room_type->price, 0, ',', '.') }}/day</td>
                        <td class="px-4 py-2">
                            <img src="{{ asset('storage/' . $room_type->images_view) }}" alt="Images view"
                                class="w-16 h-16 object-cover rounded-md mx-auto">
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex justify-center gap-2">
                                <a wire:navigate href="/roomType/{{ $room_type->id }}/edit"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-full text-sm transition">
                                    Edit
                                </a>
                                <button wire:navigate wire:click="delete({{ $room_type->id }})"
                                    wire:confirm='Are you sure want to delete this hotel?'
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm transition">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty <tr>
                        <td colspan="11" class="text-center py-4 text-gray-500">
                            No data available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $room_types->links('components.pagination', data: ['scrollTo' => false]) }}
    </div>
</div>
