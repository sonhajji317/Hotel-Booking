<div class="bg-amber-800 pt-6 pb-6 px-6 shadow-lg min-h-screen">
    <h2 class="text-center font-bold text-3xl text-amber-100 mb-2 drop-shadow">
        Melawai Hotel Room
    </h2>
    {{-- <div class="flex justify-center">
        <input wire:model.live.debounce.300ms='search' type="text"
            class="text-center bg-amber-100 text-amber-800 rounded-full p-2 w-full max-w-md mb-5 shadow focus:outline-none focus:ring-2 focus:ring-amber-500 placeholder:text-amber-800"
            placeholder="Search here...">
    </div> --}}
    <div class="flex justify-end mb-4">
        <a wire:navigate href="{{ route('room.add') }}"
            class="bg-amber-100 hover:bg-amber-200 text-amber-800 hover:text-amber-900 font-semibold py-1 px-2 text-sm rounded-full transition">
            + Room
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
        <table class="min-w-full divide-y divide-amber-200 text-sm">
            <thead class="bg-amber-200 text-center text-amber-800">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th wire:click="sortBy('hotel_id')" class="px-4 py-3 cursor-pointer">Hotel
                        @if ($sortField === 'hotel_id')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('room_type_id')" class="px-4 py-3 cursor-pointer">Room Type
                        @if ($sortField === 'room_type_id')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th class="px-4 py-3">Room Price
                    </th>
                    <th wire:click="sortBy('room_number')" class="px-4 py-3 cursor-pointer">Room Number
                        @if ($sortField === 'room_number')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('floor')" class="px-4 py-3 cursor-pointer">Room Floor
                        @if ($sortField === 'floor')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('status')" class="px-4 py-3 cursor-pointer">Status
                        @if ($sortField === 'status')
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
                @forelse ($rooms as $room)
                    <tr class="hover:bg-amber-200 transition">
                        <td class="px-4 py-2 text-gray-800">{{ $loop->iteration + $rooms->firstItem() - 1 }}</td>
                        <td class="px-4 py-2 font-medium text-gray-900">{{ $room->hotel->name }}</td>
                        <td class="px-4 py-2 text-gray-800">{{ $room->room_type->name }}</td>
                        <td class="px-4 py-2 text-gray-800">IDR
                            {{ number_format($room->room_type->price, 0, ',', '.') }}/day</td>
                        <td class="px-4 py-2 text-gray-800">{{ $room->room_number }}</td>
                        <td class="px-4 py-2 text-gray-800">{{ $room->floor }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="px-3 py-1 rounded-full text-white text-xs font-semibold 
                                {{ $room->status == 'available'
                                    ? 'bg-green-600'
                                    : ($room->status == 'booked'
                                        ? 'bg-red-500'
                                        : 'bg-yellow-400 text-gray-900') }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 flex justify-center gap-2">
                            <a wire:navigate href="/room/{{ $room->id }}/edit"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-full text-sm transition">
                                Edit
                            </a>
                            <button wire:click='delete({{ $room->id }})'
                                wire:confirm='Are you sure want to delete it?'
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm transition">
                                Delete
                            </button>
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
        {{ $rooms->links('components.pagination', data: ['scrollTo' => false]) }}
    </div>
</div>
