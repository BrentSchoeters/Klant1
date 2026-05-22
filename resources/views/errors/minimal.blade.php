<x-app-layout>
    <div class="grid grid-rows-2 grid-flow-col gap-4">
        <p class="row-span-2 text-5xl text-right border-r-2 border-gray-700 pr-4">
            @yield('code')
        </p>
        <p class="text-2xl font-light text-gray-600">
            @yield('message')
        </p>
        <div>
            <x-button class="!bg-gray-400 hover:!bg-gray-800">
                <a href="{{ route('home') }}">Home</a>
            </x-button>
            <x-button class="!bg-gray-400 hover:!bg-gray-800">
                <a onclick="window.history.back();">Back</a>
            </x-button>
        </div>
    </div>
</x-app-layout>
