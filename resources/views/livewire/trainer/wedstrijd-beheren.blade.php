<div>
    <h1 class="m-5 font-bold">Wedstrijden Beheren</h1>
    {{-- Filters --}}
    <x-tmk.section class="mb-4 flex gap-2">
        <div class="flex-1">
            <x-input id="search" type="text" placeholder="Filter trainingen"
                     wire:model.live.debounce.500ms="search"
                     class="w-full shadow-md placeholder-gray-300"/>
        </div>
        {{--<x-tmk.form.switch id="showPast" wire:model.live="showPast"
                           text-off="Future"
                           color-off="text-white bg-blue-600"
                           text-on="All"
                           color-on="text-white bg-lime-600"
                           class="w-20 h-auto"/>--}}
        <x-tmk.form.button color="nieuw" wire:click="newMatch()">Nieuwe wedstrijd</x-tmk.form.button>
    </x-tmk.section>

    <x-tmk.section>
        <table class="text-center w-full border border-gray-300">
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                <th>wedstrijd van</th>
                <th>Tegenstander</th>
                <th>Begint om</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            @forelse($wedstrijd as $item)
                <tr class="border-t border-gray-300">
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->opponent }}</td>
                    <td>{{ $item->start }}</td>
                    <td>
                        <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                            <button class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300"
                                    wire:click="editMatch({{ $item->id }})">
                                <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                            </button>
                            <button
                                class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition"
                                wire:click="deleteMatch({{ $item->id }})"
                                wire:confirm="Ben je zeker dat je deze training wilt verwijderen">
                                <x-phosphor-trash-duotone class="inline-block w-5 h-5"
                                />
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border-t border-gray-300 p-4 text-center text-gray-500">
                        <div class="font-bold italic text-sky-800">No records found</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </x-tmk.section>

    {{-- Modal --}}
    <x-dialog-modal wire:model.live="showModal">
        <x-slot name="title">
            <h2>{{ is_null($form->id) ? 'Nieuwe wedstrijd' : 'Edit wedstrijd' }}</h2></x-slot>
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
            <h2>Training</h2>


            <x-label for="opponent" value="Tegenstander"/>
            <x-input id="opponent" type="text" placeholder="Verb. Balen"
                     wire:model="form.opponent"
                     class="mt-1 block w-full"/>

            <x-label value="Datum"/>
            <x-input  id="date" type="date"
                      wire:model="form.date"
                      class="mt-1 block w-full"/>

            <div class="flex">
                <div class="w-1/2">
                    <x-label value="Begint om"/>
                    <x-input id="start" type="time"
                             wire:model="form.start"
                             class="mt-1 block w-full"/>
                </div>
                <div class="w-1/2 ml-2">
                    <x-label value="Eindigt om"/>
                    <x-input id="end" type="time"
                             wire:model="form.end"
                             class="mt-1 block w-full"/>
                </div>
            </div>



            <div class="flex items-start mt-1">
                <div class="flex-grow">
                    <x-label for="address" value="Address"/>
                    <x-input id="address" type="text" placeholder="Address"
                             wire:model="form.address"
                             class="w-full"/>
                </div>
{{--                <div>--}}
{{--                    <x-label for="home" value="Thuis"/>--}}
{{--                    <x-input id="home" type="checkbox"--}}
{{--                             wire:model="form.home"--}}
{{--                             class="ml-1"--}}
{{--                             style="height: 42px;width: 42px;"/>--}}
{{--                </div>--}}
            </div>

            <div class="flex items-start">
                <div class="flex-grow">
                    <x-label for="home" value="Thuis"/>
                    <x-input id="home" type="radio" wire:model="form.home" value="1"/>
                </div>
                <div class="flex-grow">
                    <x-label for="home" value="Niet thuis"/>
                    <x-input id="home" type="radio" wire:model="form.home" value="0"/>
                </div>
            </div>

            <x-label for="kledingWassen" value="Kleding wassen"/>
                <x-tmk.form.select id="kledingWassen"
                                   class="block mt-1 w-full"
                                   wire:model="form.user_id">
                    <option value="null">-- kies een ouder --</option>
                    @foreach($ouders as $ouder)
                        <option value="{{ $ouder->id }}"
                                wire:key="ouder-{{ $ouder->id }}">
                            {{ $ouder->firstname }} {{$ouder->surname}}
                        </option>
                    @endforeach
                </x-tmk.form.select>

            <x-label value="Veld"/>
            <x-input id="field" type="text" placeholder="veld"
                     wire:model="form.field"
                     class="mt-1 block w-full"/>

            <x-label value="Voorbereiding"/>
            <x-tmk.form.textarea  id="preparation" type="text" placeholder="voorbereiding"
                                  wire:model="form.preparation"
                                  class="mt-1 block w-full"/>


        </x-slot>
        <x-slot name="footer">
            <x-tmk.form.button color="annuleren" @click="$wire.showModal = false">Cancel</x-tmk.form.button>
            @if(is_null($form->id))
                <x-tmk.form.button color="toevoegen"
                                   wire:click="createMatch()"
                                   class="ml-2">Nieuwe wedstrijd opslaan
                </x-tmk.form.button>
            @else
                <x-tmk.form.button color="toevoegen"
                                   wire:click="updateMatch({{ $form->id }})"
                                   class="ml-2">veranderingen opslaan
                </x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>

    <x-slot name="footerName">Gerben Theunissen</x-slot>

</div>
