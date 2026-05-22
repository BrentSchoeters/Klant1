@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:ring-kvvrood focus:border-kvvrood rounded-md shadow-sm']) !!}>
