<div class="bg-amber-300">
    <!-- Card Section -->
    <div class="max-w-2xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Card -->
        <div class="bg-yellow-100 rounded-xl shadow-xs p-4 sm:p-7">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                    Melawai Hotel
                </h2>
                <p class="text-sm text-gray-700">
                    Add Room
                </p>
            </div>

            <form wire:submit.prevent='save' enctype="multipart/form-data">
                <!-- Section -->
                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Hotel
                    </label>
                    <div class="mt-2">
                        <select name="hotel_id" wire:model='hotel_id' id="hotel_id"
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="">Pick Hotel</option>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('hotel_id')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Room Type
                    </label>
                    <div class="mt-2">
                        <select name="room_type_id" wire:model='room_type_id' id="room_type_id"
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="">Pick Room Type</option>
                            @foreach ($room_types as $room_type)
                                <option value="{{ $room_type->id }}">{{ $room_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('room_type_id')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Room Number
                    </label>
                    <div class="mt-2">
                        <input wire:model='room_number' type="number"
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            placeholder="Insert Room Number">
                    </div>
                    @error('room_number')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Floor
                    </label>
                    <div class="mt-2">
                        <input wire:model="floor" type="text"
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400
                            ">
                    </div>
                    @error('floor')
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
                            <option value="">Choose status</option>
                            <option value="available">Available</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="booked">Booked</option>
                        </select>
                    </div>
                    @error('status')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mt-5 flex justify-end gap-x-2">
                    <a wire:navigate href="/roomList"
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
