@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'border-white text-md focus:outline-none focus:border-white'
                : 'border-transparent text-md hover:border-white focus:outline-none focus:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes . 'inline-flex items-center px-1 pt-1 border-b-2 text-md font-medium text-white transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</a>
