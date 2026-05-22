<nav class="mx-auto p-2 flex justify-between items-center bg-kvvrood">
    <div class="flex items-center space-x-2">
        {{-- Logo --}}
        <div class="rounded-full overflow-hidden">
            <img src="/images/kvvrauw.png" alt="" class="w-12 h-12"/>
        </div>
        <a class="hidden sm:block font-medium text-xl text-white" href="{{ route('home') }}">
            KVV Rauw
        </a>
    </div>
    <div class="relative flex items-right space-x-6">
        @guest
            <x-nav-link href="{{ route('kalender') }}" :active="request()->routeIs('kalender')">
                Kalender
            </x-nav-link>
            <x-nav-link href="{{ route('albums') }}" :active="request()->routeIs('albums')">
                Albums
            </x-nav-link>
            <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                Login
            </x-nav-link>
            <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                Registreren
            </x-nav-link>
        @endguest
        @auth
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                @if(auth()->user()->role_id == 1)
                    <x-nav-link href="{{ route('dashboard') }}"
                                :active="request()->routeIs('trainer.trainer-dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-dropdown align="top">
                        <x-slot name="trigger">
                            <div x-data="{ open: false }" class="flex items-center">
                                <x-nav-link @click="open = !open" class="cursor-pointer h-100 flex items-center"
                                            :active="request()->routeIs(['trainer.wedstrijdBeheren', 'trainer.trainingBeheren', 'trainer.albumsBeheren'])">
                                    Beheren
                                    <template x-if="!open">
                                        <x-phosphor-caret-down-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                    <template x-if="open">
                                        <x-phosphor-caret-up-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                </x-nav-link>
                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('trainer.wedstrijdBeheren') }}">Wedstrijd beheren
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('trainer.trainingBeheren') }}">Training beheren
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('trainer.albumsBeheren') }}">Foto's beheren
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                    <x-dropdown align="top">
                        <x-slot name="trigger">
                            <div x-data="{ open: false }" class="flex items-center">
                                <x-nav-link @click="open = !open" class="cursor-pointer flex items-center"
                                            :active="request()->routeIs('trainer.betalingRegistreren')">
                                    <span>Registreren</span>
                                    <template x-if="!open">
                                        <x-phosphor-caret-down-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                    <template x-if="open">
                                        <x-phosphor-caret-up-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                </x-nav-link>
                            </div>

                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('trainer.betalingRegistreren') }}">Betaling registreren
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                    <x-dropdown align="top">
                        <x-slot name="trigger">
                            <div x-data="{ open: false }" class="flex items-center">
                                <x-nav-link @click="open = !open" class="cursor-pointer flex items-center"
                                            :active="request()->routeIs([])">
                                    <span>Melden</span>
                                    <template x-if="!open">
                                        <x-phosphor-caret-down-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                    <template x-if="open">
                                        <x-phosphor-caret-up-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                </x-nav-link>
                            </div>

                        </x-slot>
                        <x-slot name="content" class="text-center">
                            <x-dropdown-link href="{{ route('kalender') }}">Afwezigheid trainer melden
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('kalender') }}">Afwezigheden registreren</x-dropdown-link>
                            <x-dropdown-link href="{{ route('ouder.opgevenWedstrijdhulp') }}">Opgeven wedstrijdhulp</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                    <x-nav-link href="{{ route('trainer.spelersbeheren') }}"
                                :active="request()->routeIs('trainer.spelersbeheren')">Spelerslijst
                    </x-nav-link>
                    <x-nav-link href="{{ route('ouder.carpool-beheren') }}"
                                :active="request()->routeIs('ouder.carpool-beheren')">Carpool
                    </x-nav-link>
                @elseif(auth()->user()->role_id == 2)
                    <x-nav-link href="{{ route('delegee.delegee-dashboard') }}"
                                :active="request()->routeIs('delegee.delegee-dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-dropdown align="top">
                        <x-slot name="trigger">
                            <div x-data="{ open: false }" class="flex items-center" @click="open = !open">
                                <x-nav-link class="cursor-pointer h-100 flex items-center"
                                            :active="request()->routeIs(['trainer.wedstrijdBeheren', 'trainer.trainingBeheren', 'trainer.albumsBeheren'])">
                                    Beheren
                                    <template x-if="!open">
                                        <x-phosphor-caret-down-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                    <template x-if="open">
                                        <x-phosphor-caret-up-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                </x-nav-link>
                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('trainer.wedstrijdBeheren') }}">Wedstrijd beheren
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('trainer.trainingBeheren') }}">Training beheren
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('trainer.albumsBeheren') }}">Foto's beheren
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <x-dropdown align="top">
                        <x-slot name="trigger">
                            <div x-data="{ open: false }" class="flex items-center" @click="open = !open">
                                <x-nav-link class="cursor-pointer flex items-center"
                                            :active="request()->routeIs('trainer.betalingRegistreren')">
                                    Registreren
                                    <template x-if="!open">
                                        <x-phosphor-caret-down-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                    <template x-if="open">
                                        <x-phosphor-caret-up-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                </x-nav-link>
                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('trainer.betalingRegistreren') }}">Betaling registreren
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <x-dropdown align="top">
                        <x-slot name="trigger">
                            <div x-data="{ open: false }" class="flex items-center" @click="open = !open">
                                <x-nav-link class="cursor-pointer flex items-center"
                                            :active="request()->routeIs([])">
                                    Melden
                                    <template x-if="!open">
                                        <x-phosphor-caret-down-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                    <template x-if="open">
                                        <x-phosphor-caret-up-bold class="ml-2 h-4 w-4 !text-white"/>
                                    </template>
                                </x-nav-link>
                            </div>
                        </x-slot>
                        <x-slot name="content" class="text-center">
                            <x-dropdown-link href="{{ route('kalender') }}">Afwezigheid trainer melden
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('kalender') }}">Afwezigheden registreren</x-dropdown-link>
                            <x-dropdown-link href="{{ route('ouder.opgevenWedstrijdhulp') }}">Opgeven wedstrijdhulp</x-dropdown-link>
                            <x-dropdown-link href="{{ route('ouder.afwezigheidWedstrijdhulp') }}">Afwezigheid wedstrijdhulp</x-dropdown-link>
                            <x-dropdown-link href="{{ route('kalender') }}">Afwezigheid kind opgeven</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <x-nav-link href="{{ route('trainer.spelersbeheren') }}"
                                :active="request()->routeIs('trainer.spelersbeheren')">
                        Spelerslijst
                    </x-nav-link>

                    <x-nav-link href="{{ route('ouder.carpool-beheren') }}"
                                :active="request()->routeIs('ouder.carpool-beheren')">
                        Carpool
                    </x-nav-link>

                @elseif(auth()->user()->role_id == 4)
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('ouder.ouders-dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link href="{{ route('ouder.carpool-beheren') }}"
                                :active="request()->routeIs('ouder.carpool-beheren')">
                        Carpool
                    </x-nav-link>
                    <x-nav-link href="{{ route('ouder.afwezigheidWedstrijdhulp') }}" :active="request()->routeIs('ouder.afwezigheidWedstrijdhulp')">
                        Afwezigheid wedstrijdhulp
                    </x-nav-link>
                    <x-nav-link href="{{ route('kalender') }}" :active="request()->routeIs('kalender')">
                        Afwezigheid kind melden
                    </x-nav-link>
                    <x-nav-link href="{{ route('ouder.opgevenWedstrijdhulp') }}"
                                :active="request()->routeIs('ouder.opgevenWedstrijdhulp')">
                        Opgeven voor wedstrijdhulp
                    </x-nav-link>
                @elseif(auth()->user()->role_id == 5)
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('admin.admin-dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.usersbeheren') }}"
                                :active="request()->routeIs('admin.usersbeheren')">
                        Gebruikers beheren
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.kledingBeheren') }}"
                                :active="request()->routeIs('admin.kledingBeheren')">
                        Kleding beheren
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.takenBeheren') }}"
                                :active="request()->routeIs('admin.takenBeheren')">
                        Beheren taken wedstrijdhulp
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.mailsbeheren') }}"
                                :active="request()->routeIs('admin.mailsbeheren')">
                        Mails beheren
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.geslachtBeheren') }}"
                                :active="request()->routeIs('admin.geslachtBeheren')">
                        Gender beheren
                    </x-nav-link>
                @endif
            </div>
            {{-- Vertical line --}}
            <div class="border-l-4 border-white"></div>
            {{-- Dropdown --}}
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <div class="flex items-center">
                        <x-nav-link class="cursor-pointer">{{ auth()->user()->firstname }}</x-nav-link>
                        <x-fas-user class="size-6 text-white cursor-pointer"/>
                    </div>
                </x-slot>
                <x-slot name="content">
                    {{-- All users --}}
                    <x-dropdown-link href="{{ route('dashboard') }}">Dashboard</x-dropdown-link>
                    <x-dropdown-link href="{{ route('profile.show') }}">Update Profiel</x-dropdown-link>
                    <x-dropdown-link href="{{ route('kalender') }}">Kalender</x-dropdown-link>
                    <x-dropdown-link href="{{ route('albums') }}">Foto's</x-dropdown-link>
                    <div class="border-t border-kvvrood"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-100 transition hover:underline hover:text-kvvrood">
                            Uitloggen
                        </button>
                    </form>
                    <div class="border-t border-kvvrood"></div>
                    @if(auth()->user()->role_id == 5)
                        {{-- Admin dropdown --}}
                        <div class="relative group">
                            <x-dropdown-link class="cursor-pointer flex items-center justify-between">
                                Admin
                                <svg
                                    class="w-4 h-4 ml-2 transform group-hover:rotate-180 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </x-dropdown-link>
                            <div
                                class="absolute right-full top-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover:block">
                                <x-dropdown-link href="{{ route('admin.usersbeheren') }}"
                                                 :active="request()->routeIs('admin.usersbeheren')">
                                    Gebruikers beheren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.kledingBeheren') }}"
                                                 :active="request()->routeIs('admin.kledingBeheren')">
                                    Kleding beheren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.takenBeheren') }}"
                                                 :active="request()->routeIs('admin.takenBeheren')">
                                    Beheren taken wedstrijdhulp
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.mailsbeheren') }}"
                                                 :active="request()->routeIs('admin.mailsbeheren')">
                                    Mails beheren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.geslachtBeheren') }}"
                                                 :active="request()->routeIs('admin.geslachtBeheren')">
                                    Gender beheren
                                </x-dropdown-link>
                            </div>
                        </div>
                    @endif
                    @if(auth()->user()->role_id == 5 || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                        {{-- Trainer dropdown --}}
                        <div class="relative group">
                            <x-dropdown-link class="cursor-pointer flex items-center justify-between">
                                Trainer
                                <svg
                                    class="w-4 h-4 ml-2 transform group-hover:rotate-180 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </x-dropdown-link>
                            <div
                                class="absolute right-full top-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover:block">
                                <x-dropdown-link href="{{ route('trainer.wedstrijdBeheren') }}"
                                                 :active="request()->routeIs('trainer.wedstrijdBeheren')">Wedstrijd
                                    beheren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('trainer.trainingBeheren') }}"
                                                 :active="request()->routeIs('trainer.trainingBeheren')">Training
                                    beheren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('trainer.albumsBeheren') }}"
                                                 :active="request()->routeIs('trainer.albumsBeheren')">Foto's beheren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('trainer.betalingRegistreren') }}"
                                                 :active="request()->routeIs('trainer.betalingRegistreren')">Betaling
                                    registreren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('kalender') }}"
                                                 :active="request()->routeIs('kalender')">Afwezigheid
                                    trainer melden
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('kalender') }}"
                                                 :active="request()->routeIs('kalender')">Afwezigheid
                                    registreren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('ouder.opgevenWedstrijdhulp') }}"
                                                 :active="request()->routeIs('ouder.opgevenWedstrijdhulp')">Opgeven
                                    wedstrijdhulp
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('ouder.afwezigheidWedstrijdhulp') }}"
                                                 :active="request()->routeIs('ouder.afwezigheidWedstrijdhulp')">Afwezigheid
                                    wedstrijdhulp
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('trainer.spelersbeheren') }}"
                                                 :active="request()->routeIs('trainer.spelersbeheren')">Spelerslijst
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('ouder.carpool-beheren') }}"
                                                 :active="request()->routeIs('ouder.carpool-beheren')">Carpool
                                </x-dropdown-link>
                            </div>
                        </div>
                    @endif
                    @if(auth()->user()->role_id == 5 || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                        {{-- Delegee dropdown --}}
                        <div class="relative group">
                            <x-dropdown-link class="cursor-pointer flex items-center justify-between">
                                Delegee
                                <svg
                                    class="w-4 h-4 ml-2 transform group-hover:rotate-180 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </x-dropdown-link>
                            <div
                                class="absolute right-full top-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover:block">
                                <x-dropdown-link href="{{ route('trainer.wedstrijdBeheren') }}"
                                                 :active="request()->routeIs('trainer.wedstrijdBeheren')">Wedstrijd
                                    beheren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('trainer.trainingBeheren') }}"
                                                 :active="request()->routeIs('trainer.trainingBeheren')">Training
                                    beheren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('trainer.albumsBeheren') }}"
                                                 :active="request()->routeIs('trainer.albumsBeheren')">Foto's beheren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('trainer.betalingRegistreren') }}"
                                                 :active="request()->routeIs('trainer.betalingRegistreren')">Betaling
                                    registreren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('kalender') }}"
                                                 :active="request()->routeIs('kalender')">Afwezigheid
                                    trainer melden
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('trainer.spelersbeheren') }}"
                                                 :active="request()->routeIs('trainer.spelersbeheren')">Spelerslijst
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('ouder.carpool-beheren') }}"
                                                 :active="request()->routeIs('ouder.carpool-beheren')">Carpool
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('kalender') }}"
                                                 :active="request()->routeIs('kalender')">Afwezigheid
                                    registreren
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('ouder.opgevenWedstrijdhulp') }}"
                                                 :active="request()->routeIs('ouder.opgevenWedstrijdhulp')">Opgeven
                                    wedstrijdhulp
                                </x-dropdown-link>
                            </div>
                        </div>
                    @endif
                    @if(auth()->user()->role_id == 5 || auth()->user()->role_id == 1 || auth()->user()->role_id == 2 || auth()->user()->role_id == 4)
                        {{-- Ouder dropdown --}}
                        <div class="relative group">
                            <x-dropdown-link class="cursor-pointer flex items-center justify-between">
                                Ouder
                                <svg
                                    class="w-4 h-4 ml-2 transform group-hover:rotate-180 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </x-dropdown-link>
                            <div
                                class="absolute right-full top-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover:block">
                                <x-dropdown-link href="{{ route('ouder.carpool-beheren') }}"
                                                 :active="request()->routeIs('ouder.carpool-beheren')">Carpool
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('ouder.afwezigheidWedstrijdhulp') }}"
                                                 :active="request()->routeIs('ouder.afwezigheidWedstrijdhulp')">Afwezigheid
                                    wedstrijdhulp
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('kalender') }}"
                                                 :active="request()->routeIs('kalender')">Afwezigheid kind
                                    melden
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('ouder.opgevenWedstrijdhulp') }}"
                                                 :active="request()->routeIs('ouder.opgevenWedstrijdhulp')">Opgeven voor
                                    wedstrijdhulp
                                </x-dropdown-link>
                            </div>
                        </div>
                    @endif
                </x-slot>
            </x-dropdown>

        @endauth
    </div>
</nav>
