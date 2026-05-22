<?php

namespace App\Actions\Fortify;

use App\Models\Gender;
use App\Models\ParentPerChild;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Livewire\WithFileUploads;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    use WithFileUploads;

    /**
     * Validate and create a newly registered user.
     *
     * @param array<string, string> $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'child_firstname' => ['required', 'string', 'max:255'],
            'child_surname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'exists:genders,id'], // Adjust based on your application's needs
            't-shirt' => ['required', 'string'],
            'broek' => ['required', 'string'],
            'sokken' => ['required', 'string'], // Use 'accepted' if it's a checkbox that must be checked for consent
            'child_permissionPhotos' => ['sometimes', 'boolean'],
            'profile_photo_path' => ['nullable', 'image', 'max:2048'],
            // Parent 1 Fields
            'parent1_firstname' => ['required', 'string', 'max:255'],
            'parent1_surname' => ['required', 'string', 'max:255'],
            'parent1_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'parent1_phoneNumber' => ['required', 'string', 'unique:users,phone_number'],
            'parent1_password' =>  $this->passwordRules(),
            'parent1_streetNumber' => ['required', 'string'],
            'parent1_postcode' => ['required', 'string'],
            'parent1_city' => ['required', 'string'],
            'parent1_permissionPhotos' => ['sometimes', 'boolean'],
            // Parent 2 Fields (assuming they are optional)
            'parent2_firstname' => ['nullable', 'string', 'max:255'],
            'parent2_surname' => ['nullable', 'string', 'max:255'],
            'parent2_email' => ['nullable', 'string', 'email', 'max:255'],
            'parent2_phoneNumber' => ['nullable', 'string', 'unique:users,phone_number'],
            'parent2_password' =>  ['nullable', 'string', Password::default(), 'confirmed'],
            'parent2_streetNumber' => ['nullable', 'string'],
            'parent2_postcode' => ['nullable', 'string'],
            'parent2_city' => ['nullable', 'string'],
            'parent2_permissionPhotos' => ['sometimes', 'boolean'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->after(function ($validator) use ($input) {
            // Check if any of the parent2 fields are filled
            $parent2FieldsFilled = !empty($input['parent2_firstname']) || !empty($input['parent2_surname']) || !empty($input['parent2_email']) || !empty($input['parent2_phoneNumber']) || !empty($input['parent2_streetNumber']) || !empty($input['parent2_city']) || !empty($input['parent2_postcode']);

            if ($parent2FieldsFilled) {
                $parent2Rules = [
                    'parent2_firstname' => 'required|string|max:255',
                    'parent2_surname' => 'required|string|max:255',
                    'parent2_email' => 'required|string|email|max:255',
                    'parent2_phoneNumber' => 'required|string',
                    'parent2_password' =>  ['required', 'string', Password::default(), 'confirmed'],
                    'parent2_streetNumber' => ['required', 'string'],
                    'parent2_postcode' => ['required', 'string'],
                    'parent2_city' => ['required', 'string'],
                ];

                foreach ($parent2Rules as $field => $rule) {
                    $validator->addRules([$field => $rule]);
                }
            }
        })->validate();

        $parent2FieldsFilled = !empty($input['parent2_firstname']) || !empty($input['parent2_surname']) || !empty($input['parent2_email']) || !empty($input['parent2_phoneNumber']) || !empty($input['parent2_streetNumber']) || !empty($input['parent2_city']) || !empty($input['parent2_postcode']);

        $gender = Gender::where('id', $input['gender'])->firstOrFail();

        if (isset($input['profile_photo_path'])) {
            $profilePhotoPath = $input['profile_photo_path']->store('photos', 'public');
            $profilePhotoPath = '/storage/' . $profilePhotoPath;
            logger('Photo is being added', ['profile_photo_path' => $profilePhotoPath]);
        } else {
            $profilePhotoPath = null; // Default path or handling if no image is uploaded
            logger('geen photo');
        }

        $child = User::create([
            'firstname' => $input['child_firstname'],
            'surname' => $input['child_surname'],
            'date_of_birth' => $input['birthdate'],
            'gender_id' => $gender->id,
            'permission_photos' => $input['child_permissionPhotos'] ?? 0,
            'role_id' => 3,
            'profile_photo_path' => $profilePhotoPath,
            'created_at' => now()
        ]);

        $parent1 = User::create([
            'firstname' => $input['parent1_firstname'],
            'surname' => $input['parent1_surname'],
            'email' => $input['parent1_email'],
            'phone_number' => $input['parent1_phoneNumber'],
            'password' => Hash::make($input['parent1_password']),
            'street_number' => $input['parent1_streetNumber'],
            'zipcode' => $input['parent1_postcode'],
            'city' => $input['parent1_city'],
            'permission_photos' => $input['parent1_permissionPhotos'] ?? 0,
            'role_id' => 4,
            'created_at' => now()
        ]);

        if ($parent2FieldsFilled) { // Check if parent2 fields are filled
            $parent2 = User::create([
                'firstname' => $input['parent2_firstname'],
                'surname' => $input['parent2_surname'],
                'email' => $input['parent2_email'],
                'phone_number' => $input['parent2_phoneNumber'],
                'password' => Hash::make($input['parent2_password']),
                'street_number' => $input['parent2_streetNumber'],
                'zipcode' => $input['parent2_postcode'],
                'city' => $input['parent2_city'],
                'permission_photos' => $input['parent2_permissionPhotos'] ?? 0,
                'role_id' => 4,
                'created_at' => now()
            ]);
        }

        ParentPerChild::create([
            'child_id' => $child->id,
            'parent_id' => $parent1->id
        ]);

        if ($parent2FieldsFilled) { // Check if parent2 fields are filled
            ParentPerChild::create([
                'child_id' => $child->id,
                'parent_id' => $parent2->id
            ]);
        }

        return $parent1;
    }
}
