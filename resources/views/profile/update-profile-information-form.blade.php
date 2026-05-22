<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profielinformatie') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Werk de profielinformatie en het e-mailadres van uw account bij.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Naam -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="firstname" value="{{ __('Voornaam') }}"/>
            <x-input id="firstname" type="text" class="mt-1 block w-full" wire:model="state.firstname" required
                     autocomplete="firstname"/>
            <x-input-error for="firstname" class="mt-2"/>
            <x-label for="surname" value="{{ __('Achternaam') }}"/>
            <x-input id="surname" type="text" class="mt-1 block w-full" wire:model="state.surname" required
                     autocomplete="surname"/>
            <x-input-error for="surname" class="mt-2"/>
        </div>

        <!-- E-mail -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('E-mail') }}"/>
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required
                     autocomplete="username"/>
            <x-input-error for="email" class="mt-2"/>

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Uw e-mailadres is niet geverifieerd.') }}

                    <button type="button"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            wire:click.prevent="sendEmailVerification">
                        {{ __('Klik hier om de verificatie-e-mail opnieuw te verzenden.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('Er is een nieuwe verificatielink naar uw e-mailadres verzonden.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Opgeslagen.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Opslaan') }}
        </x-button>
    </x-slot>
</x-form-section>
