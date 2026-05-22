@props([
    'color' => 'dark',
    'disabled' => false,
])
@php
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $options = [
        'dashboard' => 'flex items-center justify-center !border-2 !border-kvvrood bg-gray-200 !text-black py-8 px-4 rounded-xl shadow-sm hover:bg-opacity-75 hover:ring-2 hover:ring-kvvrood hover:underline',
        'verwijderen' => 'bg-gray-200 border-2 border-kvvrood shadow-lg shadow-black font-bold mt-5 py-2 m-3 px-4 rounded-full hover:bg-gray-100 hover:border-red-700 transition duration-300 focus:border-red-900 focus:ring-kvvrood',
        'nieuw' => 'flex items-center justify-center !border-2 !border-kvvrood bg-kvvrood !text-white py-2 px-2 rounded-xl shadow-sm hover:bg-gray-500 hover:ring-2 hover:ring-kvvrood hover:underline',
        'toevoegen' => 'flex items-center justify-center bg-green-400 !text-black py-1 px-1 rounded-xl shadow-sm hover:bg-green-500 hover:ring-2 hover:ring-emerald-300 hover:underline',
        'annuleren' => 'flex items-center justify-center bg-red-400 !text-black py-1 px-1 rounded-xl shadow-sm hover:bg-red-500 hover:ring-2 hover:ring-red-300 hover:underline',
        'kvv' => 'flex items-center justify-center bg-kvv-rood !text-black py-1 px-1 rounded-xl shadow-sm hover:bg-red-500 hover:ring-2 hover:ring-red-300 hover:underline',
        'carpool' => 'flex items-center justify-center bg-gray-800 !text-white py-1 px-1 rounded-xl shadow-sm hover:bg-gray-500 hover:ring-2 hover:ring-gray-300 hover:underline',
        'info' => 'flex items-center justify-center bg-gray-800 !text-white py-1 px-1 rounded-xl shadow-sm hover:bg-blue-500 hover:ring-2 hover:ring-gray-300 hover:underline'
    ];
    $style = $options[$color] ?? $options['verwijderen'];
    if($disabled) {
        $style .= ' cursor-not-allowed disabled:opacity-25 ';
    }
@endphp
<button
    {{ $attributes->merge([
           'type' => 'submit',
           'class' => "
               $style
               inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white text-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 hover:bg-gray-100"
    ])}}
    {{ $disabled ? 'disabled' : '' }}>
    {{ $slot }}
</button>
