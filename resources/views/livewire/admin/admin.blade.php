<div class="flex flex-col items-center">
    <h1 class="font-bold text-center">Startpagina Admin</h1>

    <article class="mt-10 flex flex-wrap justify-center w-full">
        <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-10 gap-y-5">
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{ route('admin.usersbeheren') }}">Gebruikers beheren</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{ route('admin.kledingBeheren') }}">Kleding beheren</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{ route('admin.takenBeheren') }}">Beheren taken wedstrijdhulp</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{ route('admin.mailsbeheren') }}">Mails beheren</x-tmk.form.button>
            <x-tmk.form.button type="button" color="dashboard" wire:navigate href="{{ route('admin.geslachtBeheren') }}">Gender beheren</x-tmk.form.button>
        </section>
    </article>
    <x-slot name="footerName">
        Cisse Vandeweyer
    </x-slot>
</div>
<x-slot name="footerName">
    Robbe De Busser en Cisse Vandeweyer
</x-slot>
