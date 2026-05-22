<div>
    <h1 class="m-5 font-bold">Taken beheren</h1>

    {{-- Filters --}}
    <x-tmk.section class="mb-4 flex gap-2">
        <div class="flex-1">
            <x-input id="search" type="text" placeholder="Filter op taken"
                     wire:model.live.debounce.500ms="search"
                     class="w-full shadow-md placeholder-gray-300"/>
        </div>
        <x-tmk.form.button color="nieuw" wire:click="newTask()">Nieuwe taak</x-tmk.form.button>
    </x-tmk.section>

    {{-- Table with taken --}}
    <x-tmk.section>
        <table class="text-center w-full border border-gray-300">
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                <th>Taken</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            @forelse($taken as $taak)
                <tr wire:key="{{ $taak->id }}" class="border-t border-gray-300">
                    <td>{{ $taak->task }}</td>
                    <td>
                        <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                            <button wire:click="editTask({{ $taak->id }})"
                                    class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300">
                                <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                            </button>
                            <button wire:click="deleteTask({{ $taak->id }})"
                                    wire:confirm="Weet je zeker dat je deze taak wilt verwijderen?"
                                    class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                                <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border-t border-gray-300 p-4 text-center text-gray-500">
                        <div class="font-bold italic text-sky-800">Geen gegevens gevonden</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </x-tmk.section>

    {{-- Modal --}}
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <h2>{{ is_null($form->id) ? 'Nieuwe taak' : 'Pas taak aan' }}</h2>
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
            <h2>Taak</h2>
            <x-input  id="task" type="text" placeholder="taak"
                      wire:model="form.task"
                      class="mt-1 block w-full"/>
        </x-slot>
        <x-slot name="footer">
            <x-tmk.form.button color="annuleren" @click="$wire.showModal = false">annuleer</x-tmk.form.button>
            @if(is_null($form->id))
                <x-tmk.form.button color="toevoegen"
                                   wire:click="createTask()"
                                   class="ml-2">Nieuwe taak opslaan
                </x-tmk.form.button>
            @else
                <x-tmk.form.button color="toevoegen"
                                   wire:click="updateTask({{ $form->id }})"
                                   class="ml-2">Wijzigingen opslaan
                </x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>
</div>
