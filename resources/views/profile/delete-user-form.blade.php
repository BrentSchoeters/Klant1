<x-action-section>
    <x-slot name="title">
        {{ __('Account Verwijderen') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Verwijder uw account permanent.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Zodra uw account is verwijderd, worden al zijn bronnen en gegevens permanent verwijderd. Voordat u uw account verwijdert, downloadt u alstublieft alle gegevens of informatie die u wilt behouden.') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Account Verwijderen') }}
            </x-danger-button>
        </div>

        <!-- Bevestigingsmodaal voor het verwijderen van gebruiker -->
        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Account Verwijderen') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Weet u zeker dat u uw account wilt verwijderen? Zodra uw account is verwijderd, worden al zijn bronnen en gegevens permanent verwijderd. Voer alstublieft uw wachtwoord in om te bevestigen dat u uw account permanent wilt verwijderen.') }}

                <div class="mt-4" x-data="{}"
                     x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4"
                             autocomplete="current-password"
                             placeholder="{{ __('Wachtwoord') }}"
                             x-ref="password"
                             wire:model="password"
                             wire:keydown.enter="deleteUser"/>

                    <x-input-error for="password" class="mt-2"/>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Annuleren') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Account Verwijderen') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
