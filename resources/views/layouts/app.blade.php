<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-layout.favicons/>
    <meta name="description" content="{{ $description ?? 'Welcome to the KVV Rauw' }}">
    <title>KVV Rauw: {{ $title ?? 'Homepage' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
<div class="flex flex-col space-y-4 min-h-screen text-gray-800 bg-gray-100">
    <header class="shadow bg-white/70 sticky inset-0 backdrop-blur-sm z-10">
        {{--  Navigation  --}}
        <x-layout.nav/>
    </header>
    <main class="container mx-auto p-4 flex-1 px-4">
        {{-- Main content --}}
        {{ $slot }}
    </main>
    <footer class="container mx-auto p-4 text-sm border-t flex justify-between items-center">
        <div>KVV Rauw - Anke Coomans - ACO-A - © {{ date('Y') }}</div>
        <div>{{ $footerName ?? ''  }}</div>
    </footer>
</div>
@stack('script')
@livewireScripts
</body>
</html>
