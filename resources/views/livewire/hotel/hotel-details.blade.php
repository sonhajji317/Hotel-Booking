<div class="px-4 py-4 bg-amber-800">
    <div class="flex justify-end mb-4 px-4 md:px-36">
        @if ($hotel->status === 'inactive')
            <a href="/hotelAll" wire:navigate
                class="ml-auto text-sm font-semibold bg-amber-100 text-amber-800 hover:bg-amber-200 hover:text-amber-900 rounded-full px-2 py-1 shadow-sm">
                View Hotel
            </a>
        @else
            <a href="/hotelAll" wire:navigate
                class="ml-auto text-sm font-semibold bg-amber-100 text-amber-800 hover:bg-amber-200 hover:text-amber-900 rounded-full px-2 py-1 shadow-sm">
                Back
            </a>
        @endif
    </div>

    <!-- Hotel Inactive Message -->
    <div class="px-4 md:px-36">
        @if ($hotel->status === 'inactive')
            <div class="text-center px-4 py-2 mb-4 text-red-700 bg-red-100 rounded-full">
                <h4 class="font-semibold">
                    Sorry, this hotel is inactive. Please search another hotel.
                </h4>
            </div>
        @endif
    </div>

    <!-- Booking Form -->
    <div class="max-w-full md:max-w-5xl mx-auto">
        <div
            class="bg-yellow-100 rounded-2xl shadow-md p-5 hover:shadow-xl hover:ring-2 hover:ring-yellow-300 transition duration-300 ease-in-out">

            <div class="space-y-4">
                <!-- Hotel Thumbnail -->
                <img src="{{ asset('storage/' . $hotel->thumbnail) }}" alt="{{ $hotel->name }}"
                    class="object-cover w-full h-48 md:h-60 rounded-xl shadow-sm">

                <!-- Hotel Info -->
                <h4 class="text-lg font-semibold text-gray-800">{{ $hotel->name }}</h4>
                <p class="text-gray-700 text-sm">{{ $hotel->description }}</p>
                <p class="text-gray-600 text-sm">{{ $hotel->city }}, {{ $hotel->address }}</p>

                <!-- Stars -->
                <div class="flex items-center space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $hotel->rating)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                class="w-5 h-5 text-yellow-500">
                                <path
                                    d="M22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                class="w-5 h-5 text-gray-300">
                                <path
                                    d="M22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24z" />
                            </svg>
                        @endif
                    @endfor

                    <span class="ml-2 text-sm font-bold text-gray-600">{{ $hotel->rating }}</span>
                </div>

                <!-- Rating & Status -->
                <div class="flex flex-wrap items-center justify-between gap-2 pt-2">
                    <!-- Non Refundable -->
                    <span
                        class="text-xs sm:text-sm font-bold uppercase px-3 py-1 bg-purple-100 text-purple-700 rounded-full shadow-sm">
                        Non-Refundable
                    </span>

                    <!-- Status -->
                    <span
                        class="text-xs sm:text-sm font-bold capitalize px-3 py-1 rounded-full shadow-sm
                        {{ $hotel->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $hotel->status }}
                    </span>
                </div>

                <form wire:submit.prevent='bookingNow' class="space-y-6">

                    <!-- Room Selection -->
                    <div class="border-t border-yellow-300 pt-4">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Room</label>
                        <select name="room_id" id="room_id" wire:model.live="room_id"
                            class="w-full px-3 py-2 bg-white border border-yellow-300 rounded-lg shadow text-gray-900 capitalize focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="">Pick Room</option>
                            @if ($hotel_id)
                                @forelse ($rooms as $room)
                                    <option value="{{ $room->id }}"
                                        @if ($room->status === 'booked' || $room->status === 'maintenance' || $hotel->status === 'inactive') disabled class="text-red-500" @endif>
                                        {{ $room->room_type->name }} | IDR
                                        {{ number_format($room->room_type->price, 0, ',', '.') }}/Day |
                                        {{ $room->status }}
                                    </option>
                                @empty
                                    <option disabled>No Room Available</option>
                                @endforelse
                            @endif
                        </select>

                        @error('room_id')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Check In -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Check In Date</label>
                            <input type="date" wire:model.live="check_in_date"
                                class="w-full px-3 py-2 bg-white border border-yellow-300 rounded-lg text-gray-900 text-center shadow focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            @error('check_in_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Check Out -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Check Out Date</label>
                            <input type="date" wire:model.live="check_out_date"
                                class="w-full px-3 py-2 bg-white border border-yellow-300 rounded-lg text-gray-900 text-center shadow focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            @error('check_out_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Guest Info + Price -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Total Price -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Total Price</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600">IDR </span>
                                <input type="text" value="{{ number_format($total_price, 0, ',', '.') }}" readonly
                                    class="w-full pl-10 px-3 py-2 bg-white border border-yellow-300 rounded-lg text-gray-900 shadow focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            </div>
                        </div>

                        <!-- Guest Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Guest Name</label>
                            <input type="text" wire:model='guest_name'
                                class="w-full px-3 py-2 bg-white border border-yellow-300 rounded-lg text-gray-900 shadow focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            @error('guest_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Guest Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Guest Email</label>
                            <input type="email" wire:model='guest_email'
                                class="w-full px-3 py-2 bg-white border border-yellow-300 rounded-lg text-gray-900 shadow focus:outline-none focus:ring-2 focus:ring-yellow-400 lowercase">
                            @error('guest_email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Guest Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Guest Phone</label>
                            <input type="number" wire:model='guest_phone'
                                class="w-full px-3 py-2 bg-white border border-yellow-300 rounded-lg text-gray-900 shadow focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            @error('guest_phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Room View --}}
                    <div class="flex flex-col items-center space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Room View</label>
                        @if ($selected_room && $selected_room->room_type->images_view)
                            <img src="{{ Storage::url($selected_room->room_type->images_view) }}" alt="Room View"
                                class="w-full max-w-xs sm:max-w-md md:max-w-lg h-80 object-cover rounded-lg shadow">
                        @else
                            <img src="{{ asset('images/placeholder-image.png') }}" alt="Room View"
                                class="w-full max-w-xs sm:max-w-md md:max-w-lg h-80 object-cover rounded-lg shadow">
                        @endif
                    </div>

                    <!-- Room Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Room Description</label>
                        <textarea wire:model="room_description" readonly
                            class="w-full px-3 py-2 bg-white border border-yellow-300 rounded-lg text-gray-900 shadow focus:outline-none focus:ring-2 focus:ring-yellow-400"></textarea>
                    </div>

                    <div>
                        <span class="text-blue-700 text-sm bg-blue-100 font-bold px-2 py-1 rounded-full">Read the room
                            description for
                            more
                            details!</span>
                    </div>

                    <div class="mt-5 flex justify-end">
                        @auth
                            <button type="submit" onclick="return confirm('Are you sure want to booking now?')"
                                class="px-4 py-2 text-sm bg-green-100 text-green-700 font-semibold rounded-full shadow hover:bg-green-200 hover:text-green-800 focus:outline-none focus:ring-2 focus:ring-green-400">
                                Confirm & Booking Now
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 text-sm bg-red-100 text-red-700 font-semibold rounded-full shadow hover:bg-red-200 hover:text-red-800">
                                Login Before Booking The Hotel
                            </a>
                        @endauth
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
