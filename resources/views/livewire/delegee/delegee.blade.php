<div>
    <h1 class="font-bold text-center">Startpagina Delegee</h1>

    <article class="justify-evenly m-5">

        <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-10 gap-y-5">
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{route('trainer.wedstrijdBeheren')}}">Wedstrijd beheren</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{route('trainer.trainingBeheren')}}">Training beheren</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{route('trainer.albumsBeheren')}}">Foto's beheren</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{route('trainer.betalingRegistreren')}}">Betaling registreren</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{route('kalender')}}">Afwezigheid trainer melden</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{route('dashboard')}}">Taken voor wedstrijden ingeven</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{route('trainer.spelersbeheren')}}">Spelerslijst opvragen</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{ route('ouder.carpool-beheren') }}">Carpoolen</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{route('kalender')}}">Afwezigheid kind melden</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{route('ouder.opgevenWedstrijdhulp')}}">Opgeven wedstrijdhulp</x-tmk.form.button>
        </section>
    </article>
    <x-slot name="footerName">
        Cisse Vandeweyer
    </x-slot>
</div>
<x-slot name="footerName">
    Robbe De Busser en Cisse Vandeweyer
</x-slot>
