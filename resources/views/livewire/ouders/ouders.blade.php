@php use App\Livewire\Ouders\AfwezigheidWedstrijdhulp; @endphp
<div>
    <h1 class="font-bold text-center">Startpagina Ouders</h1>

    <article class="mt-6 md:mt-12 lg:mt-24">

        <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-x-16 gap-y-8 mx-8 lg:mx-64">
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{ route('ouder.carpool-beheren') }}">Carpools</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{ route('ouder.afwezigheidWedstrijdhulp') }}">Afwezigheid wedstrijdhulp</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{ route('kalender') }}">Afwezigheid kind melden</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{route('ouder.opgevenWedstrijdhulp')}}">Opgeven voor wedstrijdhulp</x-tmk.form.button>
        </section>
    </article>
    <x-slot name="footerName">
        Cisse Vandeweyer
    </x-slot>
</div>
<x-slot name="footerName">
    Robbe De Busser en Cisse Vandeweyer
</x-slot>
