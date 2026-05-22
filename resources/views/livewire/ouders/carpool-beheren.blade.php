<div>
    {{-- Preloader --}}
    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse"
         wire:loading>
        <x-tmk.preloader class="bg-lime-700/60 text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-tmk.preloader>
    </div>

    <h1 class="m-5 font-bold">Carpools</h1>

    {{-- Filters --}}
    <x-tmk.section class="mb-4 flex gap-2">
        <div class="flex-1">
            <x-input id="search" type="text" placeholder="Filter op address"
                     wire:model.live.debounce.500ms="search"
                     class="w-full shadow-md placeholder-gray-300"/>
        </div>

        <x-tmk.form.button color="nieuw" wire:click="newCarpool()">Nieuwe Carpool</x-tmk.form.button>
    </x-tmk.section>

    {{-- cards with carpools --}}
    <div class="my-4">{{ $carpools->links() }}</div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-8">
        @foreach ($carpools as $carpool)
            <div wire:key="record-{{ $carpool->id }}"
                 class="rounded-lg overflow-hidden {{ $carpool->amount == 0 ? 'bg-red-100' : 'bg-green-300' }} shadow-md">
                <div class="p-4 bg-white">
                    <p class="text-lg font-medium flex items-center text-gray-700">
                        <x-phosphor-calendar class="h-5 w-5 mr-2"/>
                        {{ \Carbon\Carbon::parse($this->dateCarpool($carpool))->format('d M Y') }}
                    </p>
                    <p class="text-lg font-medium flex items-center text-gray-700">
                        <x-phosphor-clock class="h-5 w-5 mr-2"/>
                        {{ \Carbon\Carbon::parse($carpool->time)->format('H:i') }}
                    </p>
                    <p class="text-lg font-medium flex items-center text-gray-700">
                        <x-phosphor-map-pin class="h-5 w-5 mr-2"/>
                        {{ $carpool->address }}
                    </p>
                </div>
                <div class="">
                    <div class="flex justify-begin items-center px-3 py-2">
                        <p class="flex items-center text-gray-700 font-medium">
                            <x-phosphor-taxi class="h-5 w-5 mr-2"/>
                            {{ $carpool->user->firstname }} {{ $carpool->user->surname }}
                        </p>
                        <p class="flex items-center text-gray-700 font-medium mx-3">
                            <x-phosphor-person class="h-5 w-5 mr-2"/>
                            {{ $carpool->amount }}
                        </p>
                    </div>
                    <div class="flex justify-end items-center px-3 py-2">
                        @if(auth()->user()->id === $carpool->user->id)
                            <x-tmk.form.button color="carpool"
                                               class="mx-2 text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition"
                                               wire:click="editCarpool({{ $carpool->id }})">Aanpassen
                            </x-tmk.form.button>
                            <x-tmk.form.button color="carpool"
                                               class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition"
                                               wire:click="deleteCarpool({{ $carpool->id }})"
                                               wire:confirm="Weet je zeker dat je deze carpool wilt verwijderen?">Verwijderen
                            </x-tmk.form.button>
                        @else
                            @php
                                $userCarpool = in_array($carpool->id, $this->checkAnnuleer($carpool));
                            @endphp
                            @if($carpool->amount == 0)
                                @if($userCarpool)
                                    <x-tmk.form.button color="annuleren"
                                                       wire:click="annuleerCarpool({{ $carpool->id }})">Annuleer
                                    </x-tmk.form.button>
                                @else
                                    <x-tmk.form.button color="carpool" disabled class="disabled:opacity-75">Volzet
                                    </x-tmk.form.button>
                                @endif
                            @else
                                @if($userCarpool)
                                    <x-tmk.form.button color="annuleren"
                                                       wire:click="annuleerCarpool({{ $carpool->id }})">Annuleer
                                    </x-tmk.form.button>
                                @else
                                    <x-tmk.form.button color="carpool"
                                                       wire:click="registrerenCarpool({{ $carpool->id }})">Registreren
                                    </x-tmk.form.button>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal for create carpool --}}
    <x-dialog-modal wire:model="showModalCarpool">
        <x-slot name="title">
            <h2>{{ is_null($formCarpool->id) ? 'Nieuwe carpool' : 'Pas carpool aan' }}</h2>
        </x-slot>
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
            <x-label for="training_match_id" value="Selecteer match of training"/>
            <x-tmk.form.select id="training_match_id" wire:model.live="formCarpool.training_match_id"
                               class="block mt-2 mb-2 w-full">
                <option value="">Selecteer match of training</option>
                @foreach($training_match as $tm)
                    <option value="{{$tm->id}}">
                        Datum: {{$tm->date}}, Address: {{$tm->address}}
                    </option>
                @endforeach
            </x-tmk.form.select>

            <x-label for="time" value="Kies een tijdstip"/>
            <x-input id="time" type="time"
                     wire:model.defer="formCarpool.time"
                     class="mt-2 mb-2 block w-full"/>

            <x-label for="address" value="Selecteer een vertrekpunt"/>
            <x-input id="address" type="text" placeholder="Address"
                     wire:model="formCarpool.address"
                     class="mt-2 mb-2 block w-full"/>

            <x-label for="amount" value="Selecteer aantal zitplaatsen"/>
            <x-input id="amount" type="number" min="1" placeholder="zitplaatsen"
                     wire:model="formCarpool.amount"
                     class="mt-2 mb-2 block w-full"/>
        </x-slot>
        <x-slot name="footer">
            <x-tmk.form.button color="annuleren" @click="$wire.showModalCarpool = false">annuleer</x-tmk.form.button>
            @if(is_null($formCarpool->id))
                <x-tmk.form.button color="toevoegen"
                                   wire:click="createCarpool()"
                                   class="ml-2">Nieuwe carpool opslaan
                </x-tmk.form.button>
            @else
                <x-tmk.form.button color="toevoegen"
                                   wire:click="updateCarpool({{ $formCarpool->id }})"
                                   class="ml-2">Wijzigingen opslaan
                </x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>

    {{-- Modal for registration carpool --}}
    <x-dialog-modal wire:model="showModalRegistration">
        <x-slot name="title">
            <h2>Registreren</h2>
        </x-slot>
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
            <div>

            </div>
            <x-label for="amount" value="Selecteer aantal zitplaatsen"/>
            <x-tmk.form.select id="amountSelect" wire:model.live="formCarpoolPerson.amount"
                               class="block mt-2 mb-2 w-full">
                <option value="">Selecteer aantal zitplaatsen</option>
                @for($i = 1; $i <= $formCarpool->amount; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </x-tmk.form.select>
        </x-slot>
        <x-slot name="footer">
            <x-tmk.form.button color="annuleren" @click="$wire.showModalRegistration = false">annuleer
            </x-tmk.form.button>
            <x-tmk.form.button color="toevoegen"
                               wire:click="createCarpoolPerson()"
                               class="ml-2">Registreren
            </x-tmk.form.button>
        </x-slot>
    </x-dialog-modal>
    <x-slot name="footerName">
        Lucas Vanden Heede
    </x-slot>
</div>
