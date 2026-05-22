<x-action-section>
    <x-slot name="title">
        {{ __('Tweestapsverificatie') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Voeg extra beveiliging toe aan uw account met tweestapsverificatie.') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Voltooi het inschakelen van tweestapsverificatie.') }}
                @else
                    {{ __('U heeft tweestapsverificatie ingeschakeld.') }}
                @endif
            @else
                {{ __('U heeft tweestapsverificatie niet ingeschakeld.') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600">
            <p>
                {{ __('Wanneer tweestapsverificatie is ingeschakeld, wordt u tijdens het aanmelden gevraagd om een veilige, willekeurige token. U kunt deze token ophalen uit de Google Authenticator-app op uw telefoon.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        @if ($showingConfirmation)
                            {{ __('Om tweestapsverificatie te voltooien, scant u de volgende QR-code met de authenticator-app op uw telefoon of voert u de installatiesleutel in en geeft u de gegenereerde OTP-code op.') }}
                        @else
                            {{ __('Tweestapsverificatie is nu ingeschakeld. Scan de volgende QR-code met de authenticator-app op uw telefoon of voer de installatiesleutel in.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 p-2 inline-block bg-white">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Installatiesleutel') }}: {{ decrypt($this->user->two_factor_secret) }}
                    </p>
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4">
                        <x-label for="code" value="{{ __('Code') }}"/>

                        <x-input id="code" type="text" name="code" class="block mt-1 w-1/2" inputmode="numeric"
                                 autofocus autocomplete="one-time-code"
                                 wire:model="code"
                                 wire:keydown.enter="confirmTwoFactorAuthentication"/>

                        <x-input-error for="code" class="mt-2"/>
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Sla deze herstelcodes op in een veilige wachtwoordmanager. Ze kunnen worden gebruikt om toegang tot uw account te herstellen als uw tweestapsverificatie-apparaat verloren gaat.') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-button type="button" wire:loading.attr="disabled">
                        {{ __('Inschakelen') }}
                    </x-button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-secondary-button class="me-3">
                            {{ __('Herstelcodes opnieuw genereren') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <x-button type="button" class="me-3" wire:loading.attr="disabled">
                            {{ __('Bevestigen') }}
                        </x-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <x-secondary-button class="me-3">
                            {{ __('Herstelcodes weergeven') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-secondary-button wire:loading.attr="disabled">
                            {{ __('Annuleren') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-danger-button wire:loading.attr="disabled">
                            {{ __('Uitschakelen') }}
                        </x-danger-button>
                    </x-confirms-password>
                @endif

            @endif
        </div>
    </x-slot>
</x-action-section>
