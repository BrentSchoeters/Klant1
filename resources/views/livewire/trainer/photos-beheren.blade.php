<div>
    <div class="flex flex-row">
        <h1 class="w-1/2">{{ $albumName }}</h1>
        <p class="text-right w-1/2 mt-4"><i class="fas fa-info-circle"></i> Druk op een foto voor meer info.</p>
    </div>
    <div class="pt-4 flex flex-row">
        <div class="w-1/4">
            <a href="{{ route('trainer.albumsBeheren') }}"><x-button><i class="fa-solid fa-arrow-left"></i> Terug</x-button></a>
        </div>
        <div class="w-3/4 text-right">
            <x-button wire:click="newPhoto">Toevoegen</x-button>
            <x-tmk.form.button wire:click="deleteSelected" color="kvv">Verwijderen</x-tmk.form.button>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-8 mt-8">
        @forelse ($photos as $photo)
            <div class="flex flex-col bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                <img src="{{ $photo->photo_path }}" alt="{{ $photo->info }}" wire:click="openModal({{ $photo->id }})" class="w-full h-full object-center object-cover">
                <div class="p-4 text-center">
                    <input type="checkbox" wire:model="selectedPhotos" value="{{ $photo->id }}" class="form-checkbox">
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center p-4 text-gray-500">
                <div class="font-bold italic text-sky-800">Geen foto's in dit album</div>
            </div>
        @endforelse
    </div>

    @if ($showModal && $selectedPhoto)
        <div class="fixed inset-0 z-50 bg-gray-600 bg-opacity-75 flex items-center justify-center overflow-y-auto" wire:click.self="closeModal">
            <div class="flex items-center justify-center w-full h-full p-4">
                <!-- Modal Content Container -->
                <div class="relative w-3/4 h-3/4 bg-white p-5 border shadow-lg rounded-md overflow-hidden flex">
                    <div class="flex items-center justify-center w-full h-full">
                        <!-- Previous Photo Button -->
                        @if($selectedPhotoIndex != 0)
                            <button wire:click="previousPhoto" class="absolute left-0 p-4 z-50">
                                <i class="fa-solid fa-2xl fa-chevron-left"></i>
                            </button>
                        @endif

                        <!-- Image Display -->
                        <img src="{{ $selectedPhoto ? $selectedPhoto->photo_path : '' }}" alt="Selected Photo" class="max-w-full max-h-full text-center">

                        <!-- Description Section -->
                        <div class="p-4 w-1/2">
                            <h2>Beschrijving</h2>
                            {{ $selectedPhoto && !empty($selectedPhoto->info) ? $selectedPhoto->info : 'Geen beschrijving' }}
                        </div>

                        <!-- Next Photo Button -->
                        @if($selectedPhotoIndex < ($photos->count() - 1))
                            <button wire:click="nextPhoto" class="absolute right-0 p-4 z-50">
                                <i class="fa-solid fa-2xl fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>

                    <!-- Close Button -->
                    <button wire:click="closeModal" class="absolute top-0 right-0 cursor-pointer p-2 text-black z-50">
                        <i class="fa-solid fa-2xl fa-xmark"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif
    <x-dialog-modal wire:model="showModal2">
        <x-slot name="title">
            <h2>{{ 'Nieuwe photo' }}</h2>
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
            <h2>Foto</h2>
                <div class="mt-4">
                    <input type="file" wire:model="form.photo" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:border-0
                        file:text-sm file:font-semibold
                        file:bg-violet-50 file:text-violet-700
                        hover:file:bg-violet-100
                    "/>
                </div>
            <h2>Beschrijving</h2>
            <x-input id="beschrijving" type="text" placeholder="info" wire:model="form.info" class="mt-1 block w-full"/>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button @click="$wire.showModal2 = false">annuleer</x-secondary-button>
            <x-tmk.form.button color="success"
                               wire:click="createPhoto()"
                               class="ml-2">Nieuwe foto opslaan
            </x-tmk.form.button>
        </x-slot>
    </x-dialog-modal>
    <x-slot name="footerName">
        Kobe Schoeters
    </x-slot>
</div>




