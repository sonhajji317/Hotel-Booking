<div class="bg-amber-800 pt-6 pb-6 px-6 shadow-lg min-h-screen">
    <h2 class="text-center font-bold text-3xl text-amber-100 mb-2 drop-shadow">Booking list - Melawai Hotel</h2>
    <div class="flex justify-center">
        <input wire:model.live.debounce.300ms='search' type="text"
            class="text-center bg-amber-100 text-gray-800 rounded-full p-2 w-full max-w-md mb-5 shadow focus:outline-none focus:ring-2 focus:ring-amber-400 placeholder:text-amber-800"
            placeholder="Search here...">
    </div>
    <div class="flex justify-end mb-4">
        <a class="bg-amber-100 hover:bg-amber-200 text-amber-800 hover:text-amber-900 font-semibold py-1 px-2 text-sm rounded-full transition"
            wire:navigate href="/bookingAdd">+ Booking</a>
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
        <table class="min-w-full divide-y divide-amber-100 text-sm">
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
                    <th wire:click="sortBy('room_id')" class="px-4 py-3 cursor-pointer">Room
                        @if ($sortField === 'room_id')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th class="px-4 py-3">Floor</th>
                    <th class="px-4 py-3">Room Number</th>
                    <th class="px-4 py-3">Order ID</th>
                    <th wire:click="sortBy('check_in_date')" class="px-4 py-3 cursor-pointer">Check In
                        @if ($sortField === 'check_in_date')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('check_out_date')" class="px-4 py-3 cursor-pointer">Check Out
                        @if ($sortField === 'check_out_date')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('total_price')" class="px-4 py-3 cursor-pointer">Total Price
                        @if ($sortField === 'total_price')
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
                    <th wire:click="sortBy('guest_name')" class="px-4 py-3 cursor-pointer">Guest Name
                        @if ($sortField === 'guest_name')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('guest_email')" class="px-4 py-3 cursor-pointer">Guest Email
                        @if ($sortField === 'guest_email')
                            @if ($sortDirection == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('guest_phone')" class="px-4 py-3 cursor-pointer">Guest Phone
                        @if ($sortField === 'guest_phone')
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
            <tbody class="divide-y divide-gray-200 text-center ">
                @forelse ($bookings as $booking)
                    <tr class="hover:bg-amber-200 transition ">
                        <td class="px-4 py-2">{{ $loop->iteration + $bookings->firstItem() - 1 }}</td>
                        <td class="px-4 py-2 font-semibold text-gray-700">{{ $booking->hotel->name }}</td>
                        <td class="px-4 py-2">{{ $booking->room->room_type->name }}</td>
                        <td class="px-4 py-2">{{ $booking->room->floor }}</td>
                        <td class="px-4 py-2">{{ $booking->room->room_number }}</td>
                        <td class="px-4 py-2">{{ $booking->payment->order_id ?? '-' }}</td>
                        <td class="px-4 py-2">{{ date('d M y', strtotime($booking->check_in_date)) }}</td>
                        <td class="px-4 py-2">{{ date('d M y', strtotime($booking->check_out_date)) }}</td>
                        <td class="px-4 py-2 font-semibold text-green-700">IDR
                            {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                {{ $booking->status == 'pending' ? 'bg-yellow-400 text-gray-900' : ($booking->status == 'complete' ? 'bg-green-600' : 'bg-red-500') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $booking->guest_name }}</td>
                        <td class="px-4 py-2">{{ $booking->guest_email }}</td>
                        <td class="px-4 py-2">{{ $booking->guest_phone }}</td>
                        <td class="px-4 py-2 my-auto flex justify-center gap-2">
                            <a wire:navigate href="/booking/{{ $booking->id }}/edit"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-full text-sm transition font-semibold">Edit</a>
                            <button wire:click="delete({{ $booking->id }})"
                                wire:confirm='Are you sure want to delete it?'
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm transition font-semibold">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center py-4 text-gray-500">
                            No data available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $bookings->links('components.pagination', data: ['scrollTo' => false]) }}
    </div>
</div>
