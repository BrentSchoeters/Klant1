<div>
    <h1 class="m-5 font-bold">Opgeven wedstrijdhulp</h1>

    <x-tmk.section>

        {{--    Match select form    --}}
        <div>
            <x-label>Match</x-label>
            <x-tmk.form.select class="block mt-1 w-full" wire:model.live="match">
                <option value="null" selected>Kies een match</option>
                @foreach($wedstrijden as $item)
                    <option value="{{$item->id}}">Match van {{$item->date}} {{$item->start}}</option>
                @endforeach

            </x-tmk.form.select>
        </div>

        {{--    Voorkeuren    --}}
        @if($taakPerActiviteit->isNotEmpty()) <h2>Voorkeuren</h2>
            <div class="text-lg">
                @foreach($taakPerActiviteit as $i => $taak)
                    <div class="mb-1">
                        <x-input
                            id="{{$taak->id}}"
                            type="checkbox"
                            value="{{$taak->id}}"
                            wire:model.defer="form.tasks"
                        />

                        <label for="{{$taak->id}}">
                            {{$taak->task->task}}
                        </label>
                    </div>
                @endforeach
            </div>

            <x-button class="mt-2" wire:click="voorkeurRegistreren()">Voorkeuren doorgeven</x-button>

        @else
            <h2 class="italic mt-4">Geen match geselecteerd</h2>
        @endif

        {{--    Preloader    --}}
        <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse"
             wire:loading>
            <x-tmk.preloader class="bg-lime-700/60 text-white border border-lime-700 shadow-2xl">
                {{ $loading }}
            </x-tmk.preloader>
        </div>

    </x-tmk.section>

    <x-slot name="footerName">Gerben Theunissen</x-slot>

</div>
