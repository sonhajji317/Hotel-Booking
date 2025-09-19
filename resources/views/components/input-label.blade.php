@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-amber-100']) }}>
    {{ $value ?? $slot }}
</label>
