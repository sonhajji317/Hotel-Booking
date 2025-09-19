<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}"
        class="bg-amber-100 p-6 rounded-2xl shadow-lg border border-amber-100">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="text-amber-800 font-semibold" />
            <x-text-input id="email"
                class="block mt-1 w-full bg-amber-50 border-amber-300 rounded-lg shadow-sm focus:border-amber-800 focus:ring focus:ring-amber-500 focus:ring-opacity-50"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" class="text-amber-800 font-semibold" />
            <x-text-input id="password"
                class="block mt-1 w-full bg-amber-50 border-amber-300 rounded-lg shadow-sm focus:border-amber-800 focus:ring focus:ring-amber-500 focus:ring-opacity-50"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mb-4">
            <input id="remember_me" type="checkbox"
                class="rounded bg-amber-50 border-amber-800 text-amber-800 shadow-sm focus:ring-amber-900"
                name="remember">
            <label for="remember_me" class="ms-2 text-sm text-amber-800">
                {{ __('Remember me') }}
            </label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <div>
                @if (Route::has('register'))
                    <a class="text-sm text-amber-800 hover:text-amber-900 font-medium" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center">
                @if (Route::has('password.request'))
                    <a class="text-sm text-amber-800 hover:text-amber-900 me-3 font-medium"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button
                    class="bg-amber-800 hover:bg-amber-900 focus:ring focus:ring-amber-300 text-amber-200 hover:text-amber-100 px-4 py-2 rounded-lg shadow-md">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
