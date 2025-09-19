<div class="bg-amber-300">
    <!-- Card Section -->
    <div class="max-w-2xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Card -->
        <div class="bg-yellow-100 rounded-xl shadow-xs p-4 sm:p-7">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                    Melawai booking
                </h2>
                <p class="text-sm text-gray-700">
                    Add Booking Data
                </p>
            </div>

            <form wire:submit.prevent='save'>
                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Hotel
                    </label>
                    <div class="mt-2">
                        <select name="hotel_id" wire:model.live='hotel_id' id="hotel_id"
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="">Pick Hotel</option>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                            @endforeach
                        </select>
                        @error('hotel_id')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Room
                    </label>
                    <div class="mt-2">
                        <select name="room_id" wire:model.live='room_id' id="room_id"
                            class="text-gray-900 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="">Pick Room</option>
                            @if ($hotel_id)
                                @forelse ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_type->name }} |
                                        IDR {{ $room->room_type->price }}/Day</option>
                                @empty
                                    <option disabled>No Room Available</option>
                                @endforelse
                            @endif
                        </select>
                        @error('room_id')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label for="" class="inline-block text-sm font-semibold text-gray-800">Description of
                        Room</label>
                    <textarea readonly placeholder="Please pick the room first" wire:model="description"
                        class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </textarea>
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Check In Date
                    </label>
                    <div class="mt-2">
                        <input wire:model.live='check_in_date' type="date"
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        @error('check_in_date')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Check Out Date
                    </label>
                    <div class="mt-2">
                        <input wire:model.live='check_out_date' type="date"
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        @error('check_out_date')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Total Price
                    </label>
                    <div class="mt-2">
                        <input type="number" wire:model='total_price' readonly
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>
                    @error('total_price')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Status
                    </label>
                    <div class="mt-2">
                        <select wire:model='status'
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="">Pick Status</option>
                            <option value="pending">Pending</option>
                            <option value="complete">Complete</option>
                            <option value="canceled">Canceled</option>
                        </select>
                        @error('status')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Guest Name
                    </label>
                    <div class="mt-2">
                        <input type="text" wire:model='guest_name'
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            required placeholder="Insert Guest Name">
                        @error('guest_name')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Guest Email
                    </label>
                    <div class="mt-2">
                        <input type="email" wire:model='guest_email'
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            required placeholder="Insert Guest Email">
                        @error('guest_email')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Guest Phone
                    </label>
                    <div class="mt-2">
                        <input type="number" wire:model='guest_phone'
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            required placeholder="Insert Guest Phone">
                        @error('guest_phone')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mt-5 flex justify-end gap-x-2">
                    <a wire:navigate href="/bookingList"
                        class="px-3 py-2 bg-white text-gray-800 border border-yellow-300 rounded-lg shadow hover:bg-yellow-100 hover:text-gray-900 transition duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        Back
                    </a>
                    <button type="submit"
                        class="px-3 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-400">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Card Section -->
</div>
