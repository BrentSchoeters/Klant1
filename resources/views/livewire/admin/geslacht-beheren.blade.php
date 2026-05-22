<div>
    <h1 class="m-5 font-bold">Geslacht Beheren</h1>
    {{-- Filters --}}
    <x-tmk.section class="mb-4 flex gap-2">
        <div class="flex-1">
            <x-input id="search" type="text" placeholder="Filter geslachten"
                     wire:model.live.debounce.500ms="search"
                     class="w-full shadow-md placeholder-gray-300"/>
        </div>
        {{--<x-tmk.form.switch id="showPast" wire:model.live="showPast"
                           text-off="Future"
                           color-off="text-white bg-blue-600"
                           text-on="All"
                           color-on="text-white bg-lime-600"
                           class="w-20 h-auto"/>--}}
        <x-tmk.form.button color="nieuw" wire:click="newGender()">Nieuw geslacht</x-tmk.form.button>
    </x-tmk.section>

    <x-tmk.section>
        <table class="text-center w-full border border-gray-300">
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                <th>Kleding</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            @forelse($genders as $gender)
                <tr class="border-t border-gray-300">
                    <td>{{ $gender->gender }}</td>
                    <td>
                        <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                            <button class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300"
                                    wire:click="editGender({{ $gender->id }})">
                                <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                            </button>
                            <button
                                class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition"
                                wire:click="delete({{ $gender->id }})"
                                wire:confirm="Are you sure you want to delete this gender?">
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

    <x-slot name="footerName">Gerben Theunissen</x-slot>

    {{-- Modal --}}
    <x-dialog-modal wire:model.live="showModal">
        <x-slot name="title">
            <h2>{{ is_null($form->id) ? 'Nieuw geslacht' : 'Edit geslacht' }}</h2></x-slot>
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
            <h2>Geslacht</h2>
            <x-input  id="kleding" type="text" placeholder="geslacht"
                      wire:model="form.gender"
                      class="mt-1 block w-full"/>


        </x-slot>
        <x-slot name="footer">
            <x-tmk.form.button color="annuleren" @click="$wire.showModal = false">annuleer</x-tmk.form.button>
            @if(is_null($form->id))
                <x-tmk.form.button color="toevoegen"
                                   wire:click="create()"
                                   class="ml-2">Nieuw geslacht opslaan
                </x-tmk.form.button>
            @else
                <x-tmk.form.button color="toevoegen"
                                   wire:click="updateGender({{ $form->id }})"
                                   class="ml-2">veranderingen opslaan
                </x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>
</div>
