<!-- Hero -->
<div class="relative overflow-hidden bg-cover bg-no-repeat lg:grid lg:h-screen lg:place-content-center"
    style="background-image: url('{{ asset('images/view-hotel.jpeg') }}')">
    <div class="absolute inset-0 bg-gray-600/30"></div>

    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-10">
        <div class="relative mx-auto max-w-4xl grid gap-6 sm:gap-8">
            <div class="text-center">
                @if (session('success'))
                    <small x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                        class="bg-green-500 text-white font-bold p-3 rounded-full mb-4">
                        {{ session('success') }}
                    </small>
                @endif
            </div>
            <!-- Title -->
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800">
                    Your choice is our responsibility
                    <strong class="text-amber-800">to enhance</strong>
                    your experience
                </h1>
            </div>

            <!-- Form -->
            <form wire:submit.prevent='searchHotelSelected' class="flex justify-center">
                <div
                    class="bg-amber-100 rounded-2xl shadow-lg border border-amber-100 px-4 sm:px-6 py-6 w-full max-w-md space-y-4">

                    <!-- Input lokasi -->
                    <div>
                        <label class="block text-sm font-semibold text-amber-800 mb-1">
                            Location
                        </label>
                        <select wire:model='hotel'
                            class="w-full bg-amber-50 border border-amber-300 rounded-lg px-3 py-2 text-center focus:outline-none focus:ring-2 focus:ring-amber-400">
                            <option value=""> We are available at </option>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->city }}</option>
                            @endforeach
                        </select>
                        @error('hotel')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Check In & Check Out -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-amber-800 mb-1">Check In Date</label>
                            <input type="date" wire:model='check_in_date'
                                class="bg-amber-50 w-full border border-amber-300 rounded-lg px-3 py-2 text-center focus:outline-none focus:ring-2 focus:ring-amber-400">
                            @error('check_in_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-amber-800 mb-1">Check Out Date</label>
                            <input type="date" wire:model='check_out_date'
                                class="bg-amber-50 w-full border border-amber-300 rounded-lg px-3 py-2 text-center focus:outline-none focus:ring-2 focus:ring-amber-400">
                            @error('check_out_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div>
                        <button type="submit"
                            class="w-full bg-amber-800 text-amber-100 font-semibold rounded-lg py-2 hover:bg-amber-900 transition focus:ring focus:ring-amber-300">
                            Search Hotel
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End Hero -->
