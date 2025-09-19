<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-amber-100 text-amber-500 hover:text-amber-600 hover:bg-amber-200 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-amber-200 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
