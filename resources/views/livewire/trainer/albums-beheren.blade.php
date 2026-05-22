<div>

    <h1 class="m-5 font-bold grid-cols-1">Albums</h1>

    <div class="text-right">
        <x-tmk.form.button color="nieuw" wire:click="newAlbum()">
            Nieuw album
        </x-tmk.form.button>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-8 mt-8">
        @forelse ($albums as $album)
            <div wire:key="album-{{$album->id}}" class="flex flex-col bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                <a href="{{ route('trainer.photosBeheren', ['albumId' => $album->id]) }}"><img class="w-full h-80 object-cover"
                                                                           src="{{ $album->cover_photo_path ?? asset('storage/covers/no-cover.jpg') }}"
                                                                           title="{{$album->name}}"></a>

                <div class="p-4 flex flex-row">
                    <h3 class="text-lg font-medium w-1/2">{{ $album->name }}</h3>
                    <div class="w-1/2 text-right pt-2">
                        <button wire:click="editAlbum({{ $album->id }})"
                                class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition">
                            <x-phosphor-pencil-duotone class="inline-block w-10 h-10"/>
                        </button>
                        <button wire:click="deleteAlbum({{ $album->id }})"
                                wire:confirm="Weet je zeker dat je dit album wilt verwijderen?"
                                class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                            <x-phosphor-trash-duotone class="inline-block w-10 h-10"/>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center p-4 text-gray-500">
                <div class="font-bold italic text-sky-800">No albums found</div>
            </div>
        @endforelse
    </div>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <h2>{{ is_null($form->id) ? 'Nieuw album' : 'Pas album aan' }}</h2>
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
                <h2>Album</h2>
                <x-input id="album" type="text" placeholder="naam" wire:model="form.name" class="required mt-1 block w-full"/>

                <div class="mt-4">
                    <input type="file" wire:model="form.cover" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:border-0
                        file:text-sm file:font-semibold
                        file:bg-violet-50 file:text-violet-700
                        hover:file:bg-violet-100
                    "/>
                </div>
        </x-slot>
        <x-slot name="footer">
            <x-tmk.form.button color="annuleren" @click="$wire.showModal = false">annuleer</x-tmk.form.button>
            @if(is_null($form->id))
                <x-tmk.form.button color="toevoegen"
                                   wire:click="createAlbum()"
                                   class="ml-2">Nieuw album opslaan
                </x-tmk.form.button>
            @else
                <x-tmk.form.button color="toevoegen"
                                   wire:click="updateAlbum({{ $form->id }})"
                                   class="ml-2">Wijzigingen opslaan
                </x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>

    <x-slot name="footerName">
        Kobe Schoeters
    </x-slot>
    {{-- Detail section --}}
</div>
