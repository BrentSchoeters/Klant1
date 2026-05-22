<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <x-tmk.section class="w-full gap-4 border border-r px-4 rounded-md bg-white border-kvvrood">
        <div class="flex gap-10 mb-3">
            <div class="w-full">
                <x-input id="search" type="text" placeholder="Filter op naam of email"
                         wire:model.live.debounce.500ms="search"
                         class="block mt-1 w-full focus:ring-kvvrood focus:border-kvvrood rounded-md px-3 py-2"/>
            </div>
            <div class="w-1/4">
                <x-tmk.form.select id="perPage" wire:model.live="perPage"
                                   class="block mt-1 w-full focus:ring-kvvrood focus:border-kvvrood rounded-md px-3 py-2">
                    @foreach ([3,6,9,12,15,18,24] as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </x-tmk.form.select>
            </div>
        </div>
        <div class="flex justify-end mt-4 sm:mt-0">
            <x-tmk.form.button color="nieuw" wire:click="newUser()" class="mt-2">
                Nieuwe gebruiker
            </x-tmk.form.button>
        </div>
    </x-tmk.section>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-8 gap-x-16 mt-5 bg-white p-8 border-kvvrood border rounded-lg">
        @foreach($usersBeheren as $user)
            <div wire:key="user-{{ $user->id }}" class="border border-gray-00 p-4 rounded-lg shadow-xl
            @if($user->role_id === 5)
                @if(auth()->user()->id === $user->id) bg-blue-100 @endif
            @elseif($user->active === 1)
                bg-green-100
            @else
                bg-red-100
            @endif">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-black">{{ $user->firstname }} {{$user->surname}}</h3>
                        <a class="text-sm hidden sm:block underline text-gray-700 hover:text-kvvrood" href="mailto:{{$user->email}}">{{ $user->email }}</a>
                    </div>
                    <div class="flex gap-5">
                    <span data-tippy-content="Edit gebruiker">
                        <x-phosphor-pencil-line-duotone wire:click="editUser({{ $user->id }})" class="w-6 text-black-300 hover:text-green-600 cursor-pointer transition-all" title="Edit User"/>
                    </span>
                        @if($user->active === 1)
                            <span data-tippy-content="Gebruiker actief">
                            <x-heroicon-m-lock-open class="w-6 h-6 text-green-600" wire:click="switchActive({{ $user->id }})"/>
                        </span>
                        @else
                            <span data-tippy-content="Gebruiker inactief">
                            <x-heroicon-m-lock-closed class="w-6 h-6 text-red-600" wire:click="switchActive({{ $user->id }})"/>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="my-4 w-full">
        {{ $usersBeheren->links() }}
    </div>


    <div class="fixed top-8 left-1/2 transform -translate-x-1/2 z-50 animate-pulse" wire:loading>
        <x-tmk.preloader class="bg-lime-700/60 text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-tmk.preloader>
    </div>

    <x-dialog-modal id="userModal" wire:model.live="showModal">
        <x-slot name="title">
            <h2>{{ is_null($form->id) ? 'Nieuwe gebruiker' : 'Gebruiker aanpassen' }}</h2>
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
            <div class="flex flex-col gap-4 mt-4">
                <x-label for="firstname" value="Voornaam"/>
                <x-input id="firstname" type="text" wire:model="form.firstname" class="mb-2 block w-full"/>

                <x-label for="surname" value="Achternaam"/>
                <x-input id="surname" type="text" wire:model="form.surname" class="mb-2 block w-full"/>

                <x-label for="email" value="Email"/>
                <x-input id="email" type="email" wire:model="form.email" class="mb-2 block w-full"/>
                @if($update === false)
                    <x-label for="password" value="Password"/>
                    <x-input id="password" type="password" wire:model="form.password" class="mb-2 block w-full"/>
                @endif
                <x-label for="date_of_birth" value="Geboortedatum"/>
                <x-input id="date_of_birth" type="date" wire:model="form.date_of_birth" class="mb-2 block w-full"/>

                <x-label for="street_number" value="Straat + nr"/>
                <x-input id="street_number" type="text" wire:model="form.street_number" class="mb-2 block w-full"/>

                <x-label for="zipcode" value="Postcode"/>
                <x-input id="zipcode" type="text" wire:model="form.zipcode" class="mb-2 block w-full"/>

                <x-label for="city" value="Gemeente"/>
                <x-input id="city" type="text" wire:model="form.city" class="mb-2 block w-full"/>

                <x-label for="phone_number" value="Gsm nummer"/>
                <x-input id="phone_number" type="text" wire:model="form.phone_number" class="mb-2 block w-full"/>

                <x-label for="role_id" value="Selecteer rol"/>
                <x-tmk.form.select id="role_id" wire:model.live="form.role_id" class="block mt-1 w-full">
                    <option value="">Selecteer rol</option>
                    @foreach($allRoles as $r)
                        <option value="{{ $r->id }}">
                            {{ $r->role }}
                        </option>
                    @endforeach
                </x-tmk.form.select>

                <x-label for="gender_id" value="Selecteer gender"/>
                <x-tmk.form.select id="gender_id" wire:model.live="form.gender_id" class="block mt-1 w-full">
                    <option value="">Selecteer gender</option>
                    @foreach($allGenders as $g)
                        <option value="{{ $g->id }}">
                            {{ $g->gender }}
                        </option>
                    @endforeach
                </x-tmk.form.select>

                <x-label for="permission_photos" value="Selecteer toestemming voor foto"/>
                <div class="mt-2 flex items-center">
                    <label class="inline-flex items-center">
                        <input id="permission_photos" type="radio" wire:model="form.permission_photos" value="1" class="form-radio h-5 w-5 text-indigo-600">
                        <span class="ml-2 text-sm">Ik geef toestemming</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input id="permission_photos" type="radio" wire:model="form.permission_photos" value="0" class="form-radio h-5 w-5 text-indigo-600">
                        <span class="ml-2 text-sm">Ik geef geen toestemming</span>
                    </label>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-tmk.form.button color="annuleren" @click="$wire.showModal = false">Annuleer</x-tmk.form.button>
            @if($update === false)
                <x-tmk.form.button color="toevoegen" wire:click="createUser()" class="ml-2">Nieuwe gebruiker opslaan</x-tmk.form.button>
            @else
                <x-tmk.form.button color="toevoegen" wire:click="updateUser({{ $form->id }})" class="ml-2">Gebruiker opslaan</x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>
    <x-slot name="footerName">
        Robbe De Busser
    </x-slot>
</div>
