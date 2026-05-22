<div {{ $attributes->merge(['class' => "my-4 p-4 rounded-md !flex items-center gap-4 bg-gray-400 text-black border border-gray-700 shadow-2xl"]) }} >
    <img src="/images/kvvrauw-transparent.png" class="animate-spin w-10 h-10">
    <span class="flex-1">
        @if($slot->isEmpty())
            <p>Laden...</p>
        @else
            {{ $slot }}
        @endif
    </span>
</div>
