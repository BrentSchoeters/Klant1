@php use App\Models\ParentPerChild;use App\Models\User; @endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Search and Filters Section -->
    <x-tmk.section class="w-full grid grid-cols-12 gap-4 border border-r px-4 rounded-md bg-white border-kvvrood">
        <div class="col-span-12 sm:col-span-5">
            <x-input id="search" type="text" placeholder="Zoek op naam"
                     wire:model.live.debounce.500ms="search"
                     class="block mt-1 w-full"/>
        </div>
        <div class="col-span-12 sm:col-span-2">
            <x-tmk.form.select id="genre" wire:model.live="selectedOption"
                               class="block mt-1 w-full">
                <option value="1" selected>Voornaam | v</option>
                <option value="2">Voornaam | ^</option>
                <option value="3">Achternaam | v</option>
                <option value="4">Achternaam | ^</option>
            </x-tmk.form.select>
        </div>
        <div class="col-span-12 sm:col-span-2">
            <x-tmk.form.select id="perPage" wire:model.live="perPage"
                               class="block mt-1 w-full">
                @foreach ([3,6,9,12,15,18,24] as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </x-tmk.form.select>
        </div>
        <div class="col-span-12 sm:col-span-3 flex items-center justify-end">
            <x-tmk.form.button color="nieuw" wire:click="newUser()">
                Nieuwe Speler
            </x-tmk.form.button>
        </div>
    </x-tmk.section>

    <!-- Pagination Links -->
    <div class="my-4 w-full col-span-12 sm:col-span-3">
        {{ $spelersBeheren->links() }}
    </div>

    <!-- Players Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mt-4">
        @foreach($spelersBeheren as $user)
            <div wire:key="record-{{ $user->id }}"
                 class="relative flex flex-col bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                <img class="w-full h-48 object-cover border-b border-gray-300"
                     src="{{ $user->profile_photo_path ? $user->profile_photo_path : '/storage/photos/test.jpg' }}">
                <div class="flex-1 flex flex-col p-4 relative">
                    <p class="text-md font-medium mb-1">
                        {{ $user->firstname }} {{ $user->surname }}
                    </p>
                    <p class="text-sm mb-1">Nummer: {{$user->shirt_number}}</p>
                    <p class="text-sm mb-1">Ouder(s):
                        @if($parents = $this->findParents($user))
                            @foreach($parents as $parent)
                                <br>{{ $parent->firstname }} {{ $parent->surname }}
                            @endforeach
                        @endif
                    </p>
                    <span class="absolute top-2 right-2">
                        <span data-tippy-content="Edit gebruiker">
                            <x-phosphor-pencil-line-duotone
                                wire:click="editUser({{ $user->id }})"
                                class="w-6 text-black-300 hover:text-green-600 cursor-pointer outline-none transition-all"
                                title="Edit User"/>
                        </span>
                    </span>
                    <span class="absolute bottom-0 right-2">
                        @php
                            $currentYear = date('Y');
                            $previousYear = $currentYear - 1;
                            $season = $previousYear . '/' . $currentYear;
                        @endphp
                        @foreach($user->registrations as $registration)
                            @if($registration->season == $season)
                                @if($registration->payed)
                                    <x-phosphor-money data-tippy-content="Gebruiker heeft betaald"
                                                      class="text-green-500 size-10"/>
                                @else
                                    <x-phosphor-money data-tippy-content="Gebruiker heeft niet betaald"
                                                      class="text-red-500 size-10"/>
                                @endif
                            @endif
                        @endforeach
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse"
         wire:loading>
        <x-tmk.preloader>
            {{ $loading }}
        </x-tmk.preloader>
    </div>

    <x-dialog-modal id="userdModal"
                    wire:model.live="showModal">
        <x-slot name="title">
            <h2>{{ is_null($form->id) ? 'Nieuwe speler' : 'Speler aanpassen' }}</h2>
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
            <div class="flex flex-row gap-4 mt-4">
                <div class="flex-1 flex-col gap-4">
                    @if($update !== false)
                        <x-label class="mt-2 mb-2 block w-full">Ouder(s):<br>
                            @foreach($this->findParents(User::find($form->id)) as $parent)
                                {{ $parent->firstname }} {{ $parent->surname }} <br>
                            @endforeach
                        </x-label>
                    @endif
                    <div class="w-full flex flex-row">
                        <div class="mt-4 w-1/2">
                            <x-label for="profile_photo_path" value="{{ __('Upload een profielfoto') }}"/>
                            <input type="file" id="profile_photo_path" wire:model="form.profile_photo" accept="image/*"
                                   class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-gray-300 file:text-kvvrood
                                hover:file:bg-violet-100
                                "/>
                        </div>

                        <img id="profile_photo_preview" src="#" alt="Profile Photo Preview"
                             class="hidden mt-4 rounded-full w-1/2"/>
                    </div>
                    <x-tmk.form.select id="first_parent"
                                       wire:model.live="form1.parent_id"
                                       class="block mt-2 mb-2 w-full">
                        <option value="">Selecteer eerste ouder</option>
                        @foreach($parentsList->whereIn('role_id', [1, 2, 4]) as $g)
                            <option value="{{ $g->id }}">
                                {{ $g->firstname }} {{ $g->surname }}
                            </option>
                        @endforeach
                    </x-tmk.form.select>
                    <x-tmk.form.select id="second_parent"
                                       wire:model.live="form2.parent_id"
                                       class="block mt-2 mb-3 w-full">
                        <option value="">Selecteer tweede ouder (optioneel)</option>
                        @foreach($parentsList->whereIn('role_id', [1, 2, 4]) as $g)
                            <option value="{{ $g->id }}">
                                {{ $g->firstname }} {{ $g->surname }}
                            </option>
                        @endforeach
                    </x-tmk.form.select>

                    <x-label for="firstname" value="Voornaam"/>
                    <x-input id="firstname" type="text" wire:model="form.firstname" class="mt-3 mb-3 block w-full"/>

                    <x-label for="surname" value="Achternaam"/>
                    <x-input id="surname" type="text" wire:model="form.surname" class="mt-3 mb-3 block w-full"/>

                    <x-label for="date_of_birth" value="Geboortedatum"/>
                    <x-input id="date_of_birth" type="date" wire:model="form.date_of_birth"
                             class="mt-3 mb-3 block w-full"/>

                    <x-label for="t-shirt" value="t-shirt"/>
                        <x-tmk.form.select id="clothing_size_id"
                                           wire:model.live="form3.clothing_size_id"
                                           class="block mt-2 mb-3 w-full">
                        <option value="">Selecteer kledingmaat</option>
                        @foreach ($clothingSizes1 as $clothing)
                                <option value="{{ $clothing->size_id }}">{{$clothing->size->size}}</option>
                        @endforeach
                    </x-tmk.form.select>

                    <x-label for="broek" value="broek"/>
                        <x-tmk.form.select id="clothing_size_id"
                                           wire:model.live="form4.clothing_size_id"
                                           class="block mt-2 mb-3 w-full">
                            <option value="">Selecteer kledingmaat</option>
                            @foreach ($clothingSizes2 as $clothing)
                                    <option value="{{ $clothing->size_id }}">{{$clothing->size->size}}</option>
                            @endforeach
                        </x-tmk.form.select>


                    <x-label for="sokken" value="sokken"/>
                        <x-tmk.form.select id="clothing_size_id"
                                           wire:model.live="form5.clothing_size_id"
                                           class="block mt-2 mb-3 w-full">
                            <option value="">Selecteer kledingmaat</option>
                            @foreach ($clothingSizes3 as $clothing)
                                    <option value="{{ $clothing->size_id }}">{{$clothing->size->size}}</option>
                            @endforeach
                        </x-tmk.form.select>


                    <x-label for="truitjesnummer" value="Truitjes nummer" class="mt-3"/>
                    <x-input id="truitjesnummer" type="text " wire:model="form.shirt_number"
                             class="mt-3 mb-3 block w-full"/>

                    <x-label for="gender_id" value="Selecteer gender"/>
                    <x-tmk.form.select id="gender_id"
                                       wire:model.live="form.gender_id"
                                       class="block mt-2 mb-3 w-full">
                        <option value="">Selecteer gender</option>
                        @foreach($allGenders as $g)
                            <option value="{{ $g->id }}">
                                {{ $g->gender }}
                            </option>
                        @endforeach
                    </x-tmk.form.select>

                    <x-label for="permission_photos" value="Selecteer toestemming voor foto"/>
                    <div class="mt-3 mb-3 flex items-center">
                        <label for="permission_photos" class="inline-flex items-center">
                            <input id="permission_photos" type="radio" wire:model="form.permission_photos" value="1"
                                   class="form-radio h-5 w-5 text-indigo-600">
                            <span class="ml-2 text-sm">Ik geef toestemming</span>
                        </label>
                        <label for="permission_photos" class="inline-flex items-center ml-6">
                            <input id="permission_photos" type="radio" wire:model="form.permission_photos" value="0"
                                   class="form-radio h-5 w-5 text-indigo-600">
                            <span class="ml-2 text-sm">Ik geef geen toestemming</span>
                        </label>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-tmk.form.button color="annuleren" @click="$wire.showModal = false">Annuleer</x-tmk.form.button>
            @if($update === false)
                <x-tmk.form.button color="toevoegen"
                                   wire:click="createUser()"
                                   class="ml-2">Nieuwe speler opslaan
                </x-tmk.form.button>
            @else
                <x-tmk.form.button color="toevoegen"
                                   wire:click="updateUser({{ $form->id }})"
                                   class="ml-2">Speler opslaan
                </x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>
    <x-slot name="footerName">
        Robbe De Busser
    </x-slot>
    <script>
        document.getElementById('profile_photo_path').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('profile_photo_preview');
            if (file) {
                // Create a FileReader object
                const reader = new FileReader();
                // Set up what happens when reading completes
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden'); // Show the preview
                    preview.classList.add('block'); // Display as block element
                };
                // Read the file as a data URL (base64 encoded string of the file)
                reader.readAsDataURL(file);
            }
        });
    </script>
</div>
