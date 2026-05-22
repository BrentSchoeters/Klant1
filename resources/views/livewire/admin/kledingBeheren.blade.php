<div>
    <h1 class="m-5 font-bold">{{ $currentView === 'kleding' ? 'Kleding beheren' : 'Kledingmaten beheren' }}</h1>

    {{-- Filters --}}
    <x-tmk.section class="mb-4 flex gap-2">
        <x-tmk.form.button color="nieuw" wire:click="toggleView" class="flex items-center gap-2">
            {{ $currentView === 'kleding' ? 'Overschakelen naar Kledingmaten' : 'Overschakelen naar Kleding' }}
        </x-tmk.form.button>
        <div class="flex-1">
            @if($currentView === 'kleding')
                <x-input id="search" type="text" placeholder="Filter op kleding"
                         wire:model.live.debounce.500ms="search"
                         class="w-full shadow-md placeholder-gray-300"/>
            @else
                <x-input id="search" type="text" placeholder="Filter op kledingmaat"
                         wire:model.live.debounce.500ms="search"
                         class="w-full shadow-md placeholder-gray-300"/>
            @endif
        </div>
        <x-tmk.form.button color="nieuw" wire:click="newClothing()">Nieuwe kledingstuk</x-tmk.form.button>
        <x-tmk.form.button color="nieuw" wire:click="newSize()">Nieuwe kledingmaat</x-tmk.form.button>
    </x-tmk.section>

    @if($currentView === 'kleding')
        {{-- Table with clothing --}}
        <x-tmk.section>
            <table class="text-center w-full border border-gray-300">
                <thead>
                <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                    <th>Kleding</th>
                    <th>Acties</th>
                </tr>
                </thead>
                <tbody>
                @forelse($clothing as $clothing_item)
                    <tr class="border-t border-gray-300">
                        <td>{{ $clothing_item->clothing }}</td>
                        <td>
                            <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                                <button
                                    class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300"
                                    wire:click="editClothing({{ $clothing_item->id }})">
                                    <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                                </button>
                                <button
                                    class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition"
                                    wire:click="deleteClothing({{ $clothing_item->id }})"
                                    wire:confirm="Are you sure you want to delete this show?">
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
    @else
        {{-- Table with clothingsizes --}}
        <x-tmk.section>
            <table class="text-center w-full border border-gray-300">
                <thead>
                <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                    <th>Kledingmaten</th>
                    <th>Acties</th>
                </tr>
                </thead>
                <tbody>
                @forelse($Sizes as $size)
                    <tr class="border-t border-gray-300">
                        <td>{{ $size->size }}</td>
                        <td>
                            <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                                <button
                                    class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300"
                                    wire:click="editSize({{ $size->id }})">
                                    <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                                </button>
                                <button
                                    class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition"
                                    wire:click="deleteSize({{ $size->id }})"
                                    wire:confirm="Are you sure you want to delete this show?">
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
    @endif

    {{-- Modal Clothing --}}
    <x-dialog-modal wire:model.live="showModalClothing">
        <x-slot name="title">
            <h2>{{ is_null($formClothing->id) ? 'Nieuw kledingstuk' : 'Edit kledingstuk' }}</h2></x-slot>
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
            <div class="mt-1">
                <x-label for="kleding" value="Kledingstuk"/>
                <x-input id="kleding" type="text" placeholder="kledingstuk"
                         wire:model="formClothing.clothing"
                         class="mt-1 block w-full"/>
            </div>

            <div class="mt-1">
                <x-label for="size_id" value="Selecteer kledingmaten"/>
                @foreach($Sizes as $Size)
                    <div>
                        <input id="size_{{ $Size->id }}" type="checkbox"
                               wire:model="selectedSizes.{{ $Size->id }}"
                               value="{{ $Size->id }}"
                               class="form-checkbox h-4 w-4 text-kvvrood transition duration-150 ease-in-out"/>
                        <label for="size_{{ $Size->id }}" class="ml-2">{{ $Size->size}}</label>
                    </div>
                @endforeach
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-tmk.form.button color="annuleren" @click="$wire.showModalClothing = false">Cancel</x-tmk.form.button>
            @if(is_null($formClothing->id))
                <x-tmk.form.button color="toevoegen"
                                   wire:click="createClothing()"
                                   class="ml-2">Nieuw kledingstuk opslaan
                </x-tmk.form.button>
            @else
                <x-tmk.form.button color="toevoegen"
                                   wire:click="updateClothing({{ $formClothing->id }})"
                                   class="ml-2">veranderingen opslaan
                </x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Size --}}
    <x-dialog-modal wire:model.live="showModalSize">
        <x-slot name="title">
            <h2>{{ is_null($formSize->id) ? 'Nieuw kledingmaat' : 'Edit kledingmaat' }}</h2>
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
            <h2>Kledingmaat</h2>
            <x-input id="kledingmaat" type="text" placeholder="kledingmaat"
                     wire:model="formSize.size"
                     class="mt-1 block w-full"/>

        </x-slot>
        <x-slot name="footer">
            <x-tmk.form.button color="annuleren" @click="$wire.showModalSize = false">Cancel</x-tmk.form.button>
            @if(is_null($formSize->id))
                <x-tmk.form.button color="toevoegen"
                                   wire:click="createSize()"
                                   class="ml-2">Nieuw kledingmaat opslaan
                </x-tmk.form.button>
            @else
                <x-tmk.form.button color="toevoegen"
                                   wire:click="updateSize({{ $formSize->id }})"
                                   class="ml-2">veranderingen opslaan
                </x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>

    <x-slot name="footerName">
        Lucas Vanden Heede - Cisse Vandeweyer
    </x-slot>
</div>
