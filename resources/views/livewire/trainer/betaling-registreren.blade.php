<div>
    <h1 class="m-5 font-bold">Betalingen registreren</h1>
    {{-- Filters --}}
    <x-tmk.section class="mb-4 flex gap-2">
        <div class="flex-1">
            <x-input id="search" type="text" placeholder="Filter betalingen"
                     wire:model.live.debounce.500ms="search"
                     class="w-full shadow-md placeholder-gray-300"/>
        </div>
        {{--<x-tmk.form.switch id="showPast" wire:model.live="showPast"
                           text-off="Future"
                           color-off="text-white bg-blue-600"
                           text-on="All"
                           color-on="text-white bg-lime-600"
                           class="w-20 h-auto"/>--}}
{{--        <x-button wire:click="newTraining()">Nieuwe training</x-button>--}}
        <x-tmk.form.button color="nieuw" wire:click="newSeason()">Nieuw seizoen</x-tmk.form.button>
    </x-tmk.section>

    <x-tmk.section>
        <table class="text-center w-full border border-gray-300">
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                <th>Naam</th>
                <th>Seizoen</th>
                <th>Status Betaling</th>
            </tr>
            </thead>
            <tbody>
            @forelse($registraties as $item)
                <tr class="border-t border-gray-300">
                    <td>{{$item->user->firstname}} {{$item->user->surname}}</td>
                    <td>{{ $item->season }}</td>
                    <td>

                        <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid h-10">
                            <button class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300"
                                    wire:click="edit({{ $item->id }})">
                                <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                            </button>
                        </div>


                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border-t border-gray-300 p-4 text-center text-gray-500">
                        <div class="font-bold italic text-sky-800">Geen betalingen gevonden</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </x-tmk.section>

    <x-slot name="footerName">Gerben Theunissen</x-slot>

    {{-- Modal --}}
    <x-dialog-modal wire:model.live="showModal">
        <x-slot name="title">
            <h2>{{ is_null($form->id) ? 'Nieuw seizoen toevoegen of verwijderen' : 'Edit registratie' }}</h2></x-slot>
        <x-slot name="content">
            @if ($errors->any())
                <x-tmk.alert type="danger">
                    <x-tmk.list>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </x-tmk.list>
                </x-tmk.alert>
            @endif
            <h2>Registratie</h2>
                @if(is_null($form->id))
                    <x-label for="seizoen" value="Seizoen"/>
                    <x-input id="seizoen" type="text" placeholder="2023/2024" wire:model="form.seizoen"/>
                @else
                    <div class="m-2 grid grid-cols-2 h-10">
                        <div class="block">
                            <x-label for="betaald" value="Betaald"/>
                            <x-input id="betaald" type="radio" name="betaling" wire:model="form.payed" value="1"/>
                        </div>
                        <div class="block">
                            <x-label for="niet_betaald" value="Niet betaald"/>
                            <x-input id="niet_betaald" type="radio" name="betaling" wire:model="form.payed" value="0"/>
                        </div>
                    </div>
                    <div>
                        <x-label for="seizoen" value="Seizoen"/>
                        <x-input id="seizoen" type="text" placeholder="2023/2024" wire:model="form.seizoen"/>
                    </div>
                @endif


        </x-slot>
        <x-slot name="footer">
            <x-tmk.form.button color="annuleren" @click="$wire.showModal = false">Cancel</x-tmk.form.button>
            @if(is_null($form->id))
                <x-tmk.form.button color="toevoegen"
                                   wire:click="createSeason()"
                                   class="ml-2">Nieuw seizoen aanmaken
                </x-tmk.form.button>

                <x-button wire:click="deleteSeason()"
                          wire:confirm="Ben je zeker dat je dit seizoen wilt verwijderen"
                                   class="ml-2 rounded-xl">Seizoen verwijderen
                </x-button>


            @else
                <x-tmk.form.button color="toevoegen"
                                   wire:click="updateBetaling({{ $form->id }})"
                                   class="ml-2">veranderingen opslaan
                </x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>
</div>
