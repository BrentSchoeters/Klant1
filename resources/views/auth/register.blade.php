<x-app-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="flex-row">
            @csrf
            <h2>Profielfoto van het kind:</h2>
            <div class="w-full flex flex-row">
                <div class="mt-4 w-1/2">
                    <x-label for="profile_photo_path" value="{{ __('Upload een profielfoto') }}" />
                    <input type="file" id="profile_photo_path" name="profile_photo_path" accept="image/*" class="block w-full text-sm text-gray-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-full file:border-0
                      file:text-sm file:font-semibold
                      file:bg-violet-50 file:text-violet-700
                      hover:file:bg-violet-100
                    "/>
                </div>

                <img id="profile_photo_preview" src="#" alt="Profile Photo Preview" class="hidden mt-4 rounded-full w-1/2"/>
            </div>
            <div class="flex-row flex">
                <div class="w-1/2">
                    <h2>Gegevens kind: *</h2>
                    <div>
                        <x-label for="child_firstname" value="{{ __('Voornaam') }}" />
                        <x-input id="child_firstname" class="block mt-1 w-full" type="text" name="child_firstname" :value="old('child_firstname')" required autofocus autocomplete="given-name" />
                    </div>

                    <div class="mt-4">
                        <x-label for="child_surname" value="{{ __('Achternaam') }}" />
                        <x-input id="child_surname" class="block mt-1 w-full" type="text" name="child_surname" :value="old('child_surname')" required autofocus autocomplete="family-name" />
                    </div>

                    <div class="mt-4">
                        <x-label for="birthdate" value="{{ __('Geboortedatum') }}" />
                        <x-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" placeholder="dd/mm/jjjj" :value="old('birthdate')" required autofocus autocomplete="bday" />
                    </div>

                    <div class="mt-4">
                        <x-label for="gender" value="{{ __('Gender') }}" />
                        <select class="rounded-md mt-1 w-full" name="gender" required>
                            <option value="">Select Gender</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender->id }}">{{ $gender->gender}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="w-1/2 ps-3">
                    <h3 class="mt-3">Kledingmaten</h3>

                    <div>
                        <x-label for="t-shirt" value="{{ __('T-shirt') }}" />
                        <select class="rounded-md mt-1 w-full" name="t-shirt" id="t-shirt" class="form-control">
                            <option value="">Selecteer kledingmaat</option>
                            @foreach ($clothingSizes as $clothing)
                                @if ($clothing->clothing_id == 1) <!-- Adjust condition as needed -->
                                <option value="{{ $clothing->size_id }}">{{$clothing->size->size}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="broek" value="{{ __('Broek') }}" />
                        <select class="rounded-md mt-1 w-full" name="broek" id="broek" class="form-control">
                            <option value="">Selecteer kledingmaat</option>
                            @foreach ($clothingSizes as $clothing)
                                @if ($clothing->clothing_id == 2) <!-- Adjust condition as needed -->
                                <option value="{{ $clothing->size_id }}">{{$clothing->size->size}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="sokken" value="{{ __('Sokken') }}" />
                        <select class="rounded-md mt-1 w-full" name="sokken" id="sokken" class="form-control">
                            <option value="">Selecteer kledingmaat</option>
                            @foreach ($clothingSizes as $clothing)
                                @if ($clothing->clothing_id == 3) <!-- Adjust condition as needed -->
                                <option value="{{ $clothing->size_id }}">{{$clothing->size->size}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="mt-4 flex flex-row">
                <x-input class="block mt-2 text-kvvrood" type="checkbox" id="child_permissionPhotos" name="child_permissionPhotos" :value="1"/>
                <x-label class="p-2" for="child_permissionPhotos" value="{{__('Ik geef toestemming om fotos van mijn kind te laten maken en uploaden.')}}"/>
            </div>

            <h2>Gegevens ouder 1: *</h2>
            <div class="flex-row flex">
                <div class="w-1/2">
                    <x-label for="parent1_firstname" value="{{ __('Voornaam') }}" />
                    <x-input id="parent1_firstname" class="block mt-1 w-full" type="text" name="parent1_firstname" :value="old('parent1_firstname')" required autofocus autocomplete="given-name" />
                </div>

                <div class="w-1/2 ps-3">
                    <x-label for="parent1_surname" value="{{ __('Achternaam') }}" />
                    <x-input id="parent1_surname" class="block mt-1 w-full" type="text" name="parent1_surname" :value="old('parent1_surname')" required autofocus autocomplete="family-name" />
                </div>
            </div>
            <div class="flex-row flex">
                <div class="mt-4 w-1/2">
                    <x-label for="parent1_email" value="{{ __('Email') }}" />
                    <x-input id="parent1_email" class="block mt-1 w-full" type="email" name="parent1_email" :value="old('parent1_email')" required autocomplete="username" />
                </div>

                <div class="w-1/2 mt-4 ps-3">
                    <x-label for="parent1_phoneNumber" value="{{ __('Gsm nummer') }}" />
                    <x-input id="parent1_phoneNumber" class="block mt-1 w-full" type="text" name="parent1_phoneNumber" :value="old('parent1_phoneNumber')" required autofocus autocomplete="tel" />
                </div>
            </div>
            <div class="flex-row flex">
                <div class="mt-4 w-1/2">
                    <x-label for="parent1_password" value="{{ __('Wachtwoord') }}" />
                    <x-input id="parent1_password" class="block mt-1 w-full" type="password" name="parent1_password" required autocomplete="new-password" />
                </div>

                <div class="mt-4 w-1/2 ps-3">
                    <x-label for="parent1_password_confirmation" value="{{ __('Bevestig Wachtwoord') }}" />
                    <x-input id="parent1_password_confirmation" class="block mt-1 w-full" type="password" name="parent1_password_confirmation" required autocomplete="new-password" />
                </div>
            </div>

            <h3>Adres</h3>
            <div class="flex-row flex">
                <div class="w-1/2">
                    <x-label for="parent1_streetNumber" value="{{ __('Straat en huisnummer') }}" />
                    <x-input id="parent1_streetNumber" class="block mt-1 w-full" type="text" name="parent1_streetNumber" :value="old('parent1_streetNumber')" required autofocus autocomplete="address-line1" />
                </div>

                <div class="w-1/2 ps-3">
                    <x-label for="parent1_postcode" value="{{ __('Postcode') }}" />
                    <x-input id="parent1_postcode" class="block mt-1 w-full" type="text" name="parent1_postcode" :value="old('parent1_postcode')" required autofocus autocomplete="postal-code" />
                </div>
            </div>
            <div class="mt-4">
                <x-label for="parent1_city" value="{{ __('Gemeente') }}" />
                <x-input id="parent1_city" class="block mt-1 w-full" type="text" name="parent1_city" :value="old('parent1_city')" required autofocus autocomplete="address-level2" />
            </div>
            <div class="mt-4 flex flex-row">
                <x-input class="block mt-2 text-kvvrood" type="checkbox" id="parent1_permissionPhotos" name="parent1_permissionPhotos" :value="1"/>
                <x-label class="p-2" for="parent1_permissionPhotos" value="{{__('Ik geef toestemming om fotos van mijn kind te laten maken en uploaden.')}}"/>
            </div>

            <h2>Gegevens ouder 2: </h2>

            <div class="flex-row flex">
                <div class="w-1/2">
                    <x-label for="parent2_firstname" value="{{ __('Voornaam') }}" />
                    <x-input id="parent2_firstname" class="require-group block mt-1 w-full" type="text" name="parent2_firstname" :value="old('parent2_firstname')" autofocus autocomplete="given-name" />
                </div>

                <div class="w-1/2 ps-3">
                    <x-label for="parent2_surname" value="{{ __('Achternaam') }}" />
                    <x-input id="parent2_surname" class="require-group block mt-1 w-full" type="text" name="parent2_surname" :value="old('parent2_surname')" autofocus autocomplete="family-name" />
                </div>
            </div>

            <div class="flex-row flex">
                <div class="mt-4 w-1/2">
                    <x-label for="parent2_email" value="{{ __('Email') }}" />
                    <x-input id="parent2_email" class="require-group block mt-1 w-full" type="email" name="parent2_email" :value="old('parent2_email')" autocomplete="username" />
                </div>

                <div class="w-1/2 mt-4 ps-3">
                    <x-label for="parent2_phoneNumber" value="{{ __('Gsm nummer') }}" />
                    <x-input id="parent2_phoneNumber" class="require-group block mt-1 w-full" type="text" name="parent2_phoneNumber" :value="old('parent2_phoneNumber')" autofocus autocomplete="tel" />
                </div>
            </div>

            <div class="flex-row flex">
                <div class="mt-4 w-1/2">
                    <x-label for="parent2_password" value="{{ __('Wachtwoord') }}" />
                    <x-input id="parent2_password" class="require-group block mt-1 w-full" type="password" name="parent2_password" autocomplete="new-password" />
                </div>

                <div class="mt-4 w-1/2 ps-3">
                    <x-label for="parent2_password_confirmation" value="{{ __('Bevestig Wachtwoord') }}" />
                    <x-input id="parent2_password_confirmation" class="require-group block mt-1 w-full" type="password" name="parent2_password_confirmation" autocomplete="new-password" />
                </div>
            </div>

            <h3>Adres</h3>

            <div class="flex-row flex">
                <div class="w-1/2">
                    <x-label for="parent2_streetNumber" value="{{ __('Straat en huisnummer') }}" />
                    <x-input id="parent2_streetNumber" class="require-group block mt-1 w-full" type="text" name="parent2_streetNumber" :value="old('parent2_streetNumber')" autofocus autocomplete="address-line1" />
                </div>

                <div class="w-1/2 ps-3">
                    <x-label for="parent2_postcode" value="{{ __('Postcode') }}" />
                    <x-input id="parent2_postcode" class="require-group block mt-1 w-full" type="text" name="parent2_postcode" :value="old('parent2_postcode')" autofocus autocomplete="postal-code" />
                </div>
            </div>

            <div class="mt-4">
                <x-label for="parent2_city" value="{{ __('Gemeente') }}" />
                <x-input id="parent2_city" class="require-group block mt-1 w-full" type="text" name="parent2_city" :value="old('parent2_city')" autofocus autocomplete="address-level2" />
            </div>

            <div class="mt-4 flex flex-row">
                <x-input class="block mt-2 text-kvvrood" type="checkbox" id="parent2_permissionPhotos" name="parent2_permissionPhotos" :value="1"/>
                <x-label class="p-2" for="parent2_permissionPhotos" value="{{__('Ik geef toestemming om fotos van mijn kind te laten maken en uploaden.')}}"/>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>²
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Al een account?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Registreer') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
    <x-slot name="footerName">
        Kobe Schoeters
    </x-slot>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputs = document.querySelectorAll('.require-group');

            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    let isAnyFieldFilled = Array.from(inputs).some(input => input.value !== '');
                    inputs.forEach(input => {
                        input.required = isAnyFieldFilled;
                    });
                });
            });
        });
    </script>
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
</x-app-layout>
