@props(['disabled' => false])

<select
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'border-gray-300 focus:ring-kvvrood focus:border-kvvrood rounded-md shadow-sm']) !!}>
    {{ $slot }}
</select>
