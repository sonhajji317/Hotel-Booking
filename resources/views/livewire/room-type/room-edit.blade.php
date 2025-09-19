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
                    Edit Room Type
                </p>
            </div>

            <form wire:submit.prevent='update' enctype="multipart/form-data">
                <!-- Section -->
                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Name
                    </label>
                    <div class="mt-2">
                        <input wire:model='name' type="text"
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            placeholder="Insert Hotel Name">
                    </div>
                    @error('name')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                {{-- <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Hotel
                    </label>
                    <div class="mt-2">
                        <select name="hotel_id" wire:model='hotel_id' id="hotel_id"
                            class="border w-full bg-white focus:outline-amber-300 px-3 py-2 rounded-lg">
                            <option value="">Pick Hotel</option>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('hotel_id')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div> --}}

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Price
                    </label>
                    <div class="mt-2">
                        <input wire:model='price' type="number"
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            placeholder="Insert Price">
                    </div>
                    @error('price')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Capacity
                    </label>
                    <div class="mt-2">
                        <input wire:model='capacity' type="number"
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            placeholder="Insert Capacity">
                    </div>
                    @error('capacity')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Description
                    </label>
                    <div class="mt-2">
                        <textarea wire:model='description'
                            class="text-gray-800 bg-white rounded-lg shadow px-3 py-2 w-full border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            placeholder="Description of Hotel"></textarea>
                    </div>
                    @error('description')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div class="py-6 border-t border-yellow-300">
                    <label class="inline-block text-sm font-semibold text-gray-800">
                        Room Type View
                    </label>

                    <div class="flex">
                        <div class="py-6 border-yellow-300 mx-auto">
                            @if ($images_view instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                {{-- Kalau user baru upload file --}}
                                <img src="{{ $images_view->temporaryUrl() }}" alt="Thumbnail"
                                    class="w-32 h-32 object-cover rounded-lg">
                            @elseif ($existing_image)
                                {{-- Kalau sedang edit dan sudah ada di DB --}}
                                <img src="{{ Storage::url($existing_image) }}" alt="Thumbnail"
                                    class="w-32 h-32 object-cover rounded-lg">
                            @else
                                {{-- Default placeholder --}}
                                <img src="{{ asset('images/placeholder-image.png') }}" alt="Thumbnail"
                                    class="w-32 h-32 object-cover rounded-lg">
                            @endif
                        </div>
                    </div>
                    <label for="File"
                        class="block rounded border border-yellow-300 p-4 text-gray-800 bg-white shadow-sm hover:ring-2 hover:ring-yellow-400 transition duration-200">
                        <div class="flex items-center justify-center gap-4">
                            <span class="font-medium">Upload Room Type View</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 h-6" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25" />
                            </svg>
                        </div>
                        <input wire:model='images_view' type="file" id="File" class="sr-only" />
                    </label>

                </div>
                @error('images_view')
                    <small class="text-red-400">
                        {{ $message }}
                    </small>
                @enderror

                <div class="mt-5 flex justify-end gap-x-2">
                    <a wire:navigate href="/roomTypeTable"
                        class="px-3 py-2 bg-white text-gray-800 border border-yellow-300 rounded-lg shadow hover:bg-yellow-100 hover:text-gray-900 transition duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        Back
                    </a>
                    <button type="submit" onclick="return confirm('Are you sure want to update this data?')"
                        class="px-3 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-400">
                        Update Hotel
                    </button>
                </div>
            </form>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Card Section -->
</div>
