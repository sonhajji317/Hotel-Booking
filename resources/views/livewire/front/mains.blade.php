    {{-- Room Type --}}
    <div class="bg-amber-800 px-4 sm:px-6 lg:px-8 pb-7">
        <div class="flex flex-col items-center">
            <h2 class="text-center font-bold text-2xl border-t-2 border-amber-100 inline-block text-amber-100">
                Melawai Hotel Room Type
            </h2>
            <h2 class="text-center font-bold text-2xl text-amber-100 mb-6">
                To Adjust Your Comfort
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse ($room_types as $room_type)
                <div class="p-2 sm:p-4">
                    <div class="block rounded-lg bg-amber-100 shadow-md hover:shadow-xl transition p-4">

                        <!-- Gambar -->
                        <div class="overflow-hidden rounded-lg">
                            <img alt="" src="{{ asset('storage/' . $room_type->images_view) }}"
                                class="h-64 w-full object-cover transition duration-500 ease-in-out hover:scale-105" />
                        </div>

                        <div class="mt-2 space-y-1">
                            <!-- Name -->
                            <dl>
                                <div>
                                    <dt class="sr-only">Name</dt>
                                    <dd class="font-bold text-gray-800 text-center">{{ $room_type->name }}</dd>
                                </div>
                            </dl>

                            <!-- Deskripsi -->
                            <div>
                                <p class="line-clamp-2 text-sm text-gray-700">{{ $room_type->description }}</p>
                            </div>

                            <!-- Icon Info -->
                            <div class="mt-2 flex flex-wrap justify-between gap-4 text-xs">
                                <!-- Price -->
                                <div class="flex items-center gap-2 w-1/2 sm:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <div>
                                        <p class="text-gray-700">Price</p>
                                        <p class="font-bold text-gray-800">IDR {{ $room_type->price }}/day</p>
                                    </div>
                                </div>

                                <!-- Capacity -->
                                <div class="flex items-center gap-2 w-1/2 sm:w-auto">
                                    <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                    <div>
                                        <p class="text-gray-700">Capacity</p>
                                        <p class="font-bold text-gray-800">For {{ $room_type->capacity }} people</p>
                                    </div>
                                </div>

                                <!-- Internet -->
                                <div class="flex items-center gap-2 w-1/2 sm:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
                                    </svg>
                                    <div>
                                        <p class="text-gray-700">Internet</p>
                                        <p class="font-bold text-gray-800">Unlimited</p>
                                    </div>
                                </div>

                                <!-- Media -->
                                <div class="flex items-center gap-2 w-1/2 sm:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                    <div>
                                        <p class="text-gray-700">Media</p>
                                        <p class="font-bold text-gray-800">Smart TV</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-1 sm:col-span-2 md:col-span-2 lg:col-span-4 flex flex-col items-center justify-center h-64">
                    <label class="mb-3 text-amber-100">No Room Type Available</label>
                    <img src="{{ asset('images/placeholder-image.png') }}" alt="RoomType"
                        class="w-32 h-32 object-cover rounded-lg">
                </div>
            @endforelse
        </div>
        <!-- Pagination -->
        <div class="mt-6">
            {{ $room_types->links('components.pagination', data: ['scrollTo' => false]) }}
        </div>
    </div>
