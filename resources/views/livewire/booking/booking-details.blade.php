<div class="bg-amber-800 pt-6 pb-6 px-6 shadow-lg min-h-screen">
    <h1 class="text-center font-bold text-amber-100 mb-2 drop-shadow">Your Booking Data</h1>
    <div class="flex justify-end mb-4">
        <a class="bg-amber-100 hover:bg-amber-200 text-amber-800 hover:text-amber-900 font-semibold py-1 px-2 text-sm rounded-full transition"
            wire:navigate href="/hotelAll">Booking Hotel</a>
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
                    <th class="px-4 py-3">Hotel</th>
                    <th class="px-4 py-3">Room</th>
                    <th class="px-4 py-3">Floor</th>
                    <th class="px-4 py-3">Room number</th>
                    <th class="px-4 py-3">Check In</th>
                    <th class="px-4 py-3">Check Out</th>
                    <th class="px-4 py-3">Total Price</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Guest Name</th>
                    <th class="px-4 py-3">Guest Email</th>
                    <th class="px-4 py-3">Guest Phone</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-center">
                @forelse ($bookings as $booking)
                    <tr class="hover:bg-amber-200 transition">
                        {{-- <td class="px-4 py-2">{{ $loop->iteration + $bookings->firstItem() - 1 }}</td> --}}
                        <td class="px-4 py-2 font-semibold text-gray-700">{{ $booking->hotel->name }}</td>
                        <td class="px-4 py-2">{{ $booking->room->room_type->name }}</td>
                        <td class="px-4 py-2">{{ $booking->room->floor }}</td>
                        <td class="px-4 py-2">{{ $booking->room->room_number }}</td>
                        <td class="px-4 py-2">{{ date('d M y', strtotime($booking->check_in_date)) }}</td>
                        <td class="px-4 py-2">{{ date('d M y', strtotime($booking->check_out_date)) }}</td>
                        <td class="px-4 py-2 font-semibold text-green-700">IDR
                            {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                {{ $booking->status == 'pending' ? 'bg-yellow-500 text-yellow-100' : ($booking->status == 'complete' ? 'bg-green-600 text-green-100' : 'bg-red-500 text-red-100') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $booking->guest_name }}</td>
                        <td class="px-4 py-2">{{ $booking->guest_email }}</td>
                        <td class="px-4 py-2">{{ $booking->guest_phone }}</td>
                        <td class="px-4 py-2">
                            <div class="flex flex-nowrap gap-2" x-data="{ open: false }">
                                @if ($booking->status === 'complete')
                                    <a href="#"
                                        class="px-2 py-1 text-sm font-semibold text-green-800 bg-green-100 hover:text-green-900 hover:bg-green-200 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </a>
                                @else
                                    <!-- Trigger Modal -->
                                    <button @click="open = true"
                                        class="px-2 py-1 text-sm font-semibold text-green-800 bg-green-100 hover:text-green-900 hover:bg-green-200 rounded-full">
                                        Pay
                                    </button>

                                    <!-- Modal -->
                                    <div x-show="open"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                        x-transition>
                                        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
                                            <h2 class="text-lg font-bold text-gray-800 mb-4">Confirm Payment</h2>
                                            <p class="text-gray-600 mb-6">Are you sure you want to pay this booking?</p>

                                            <div class="flex justify-end gap-3">
                                                <button @click="open = false"
                                                    class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300">
                                                    Cancel
                                                </button>
                                                <button wire:click="pay({{ $booking->id }})"
                                                    class="px-4 py-2 rounded-full bg-green-600 text-white font-semibold hover:bg-green-700">
                                                    Pay Now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($booking->status === 'complete')
                                    <button disabled
                                        class="bg-gray-200 font-semibold text-gray-500 px-3 py-1 rounded-full text-sm cursor-not-allowed">
                                        Delete
                                    </button>
                                @else
                                    <button wire:click="delete({{ $booking->id }})"
                                        wire:confirm='Are you sure want to delete this booking?'
                                        class="bg-red-100 font-semibold hover:bg-red-200 text-red-800 hover:text-red-900 px-3 py-1 rounded-full text-sm">
                                        Delete
                                    </button>
                                @endif
                            </div>
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-4 text-amber-800">
                            No data available
                        </td>
                    </tr>
                @endforelse
            </tbody>
            {{ $bookings->links() }}
        </table>
    </div>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <script>
        window.addEventListener('midtrans:pay', function(event) {
            const snapToken = event.detail.snapToken;

            snap.pay(snapToken, {
                onSuccess: function(result) {
                    Livewire.dispatch('refreshBookings');
                    alert('Pembayaran berhasil!');
                },
                onPending: function(result) {
                    Livewire.dispatch('refreshBookings');
                    alert('Menunggu pembayaran...');
                },
                onError: function(result) {
                    alert('Terjadi error!');
                },
                onClose: function() {
                    console.log('Popup ditutup tanpa bayar');
                }
            });
        });
    </script>

</div>
