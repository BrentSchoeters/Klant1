<?php

namespace App\Livewire\Forms;

use App\Models\Registration;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class spelerForm extends Form
{
    use WithFileUploads;

    public $id = null;

    #[Validate('required|max:30')]
    public $firstname = null;

    #[Validate('required|max:30')]
    public $surname = null;
    #[Validate('required|date')]
    public $date_of_birth = null;

    public $role_id = null;

    #[Validate('required|notin:0')]
    public $gender_id = null;

    #[Validate('required|in:0,1')]
    public $permission_photos = null;

    #[Validate('required|numeric')]
    public $shirt_number = null;

    #[Validate('nullable|image')]
    public $profile_photo = null;

    protected $messages =[
        'firstname.required' => "Voornaam van de gebruiker is verplicht en mag maximaal 30 karakters bevatten.",
        'surname.required' => "Achternaam van de gebruiker is verplicht en mag maximaal 30 karakters bevatten",
        'email.required' => 'E-mail van de gebruiker is verplicht en moet een geldig e-mailadres zijn',
        'date_of_birth' => 'Geboortedatum van de gebruiker is verplicht en moet een geldige datum zijn',
        'shirt_number.required' => 'Truitjes nummer is verplicht en mag alleen maar cijfers bevatten.',
        'shirt_number.numeric' => 'Truitjes nummer is verplicht en mag alleen maar cijfers bevatten.',
        'street_number.required' => 'Adres van de gebruiker is verplicht en mag maximaal 50 karakters bevatten',
        'zipcode.required' => 'Postcode van de gebruiker is verplicht en mag alleen numerieke karakters bevatten',
        'city.required' => 'Gemeente van de gebruiker is verplicht en mag maximaal 50 karakters bevatten',
        'phone_number.required' => 'Gsmnummer van de gebruiker is verplicht en mag alleen numerieke karakters en het plus-teken bevatten',
        'role_id.required' => 'Kies een geldige rol voor de gebruiker',
        'gender_id' => 'Kies een geldige gender voor de gebruiker',
        'permission_photos.required' => 'Kies een geldige permissie voor de gebruiker',
        'password.required' => 'Wachtwoord is verplicht en moet minimaal 8 tekens bevatten',
    ];
    public function read($user)
    {
        $this->id = $user->id;
        $this->firstname = $user->firstname;
        $this->surname = $user->surname;
        $this->date_of_birth = $user->date_of_birth;
        $this->role_id = $user->role_id;
        $this->gender_id = $user->gender_id;
        $this->permission_photos = $user->permission_photos;
        $this->shirt_number = $user->shirt_number;
        $this->profile_photo = $user->profile_photo;
    }

    public function create()
    {
        $this->validate();
        $profilePhotoPath = null;
        logger(['profile_photo_path' => $this->profile_photo]);
        if ($this->profile_photo) {
            $profilePhotoPath = $this->profile_photo->store('photos', 'public');
            $profilePhotoPath = '/storage/' . $profilePhotoPath;
            logger('Photo is being added', ['profile_photo_path' => $profilePhotoPath]);
        } else {
            logger('geen foto');
        }
        $user = User::create([
            'firstname' => $this->firstname,
            'surname' => $this->surname,
            'date_of_birth' => $this->date_of_birth,
            'role_id' => 3,
            'gender_id' => $this->gender_id,
            'permission_photos' => $this->permission_photos,
            'shirt_number' => $this->shirt_number,
            'profile_photo_path' => $profilePhotoPath,
        ]);

        $currentYear = date('Y');
        $previousYear = $currentYear - 1;
        $season = $previousYear . '/' . $currentYear;

        Registration::create([
            'user_id' => $user->id,
            'payed' => false,
            'season' => $season,
        ]);
    }

    // update the selected record
    public function update(User $user)
    {
        $this->validate([
            'firstname' => 'required|max:30',
            'surname' => 'required|max:30',
            'date_of_birth' => 'required|date',
            'gender_id' => 'required|notin:0',
            'permission_photos' => 'required|in:0,1',
            'shirt_number' => 'required|numeric',
        ]);

        if ($this->profile_photo) {
            $profilePhotoPath = $this->profile_photo->store('photos', 'public');
            $profilePhotoPath = '/storage/' . $profilePhotoPath;
            logger('Photo is being added', ['profile_photo_path' => $profilePhotoPath]);
            $user->profile_photo_path = $profilePhotoPath;
        }

        $user->update([
            'firstname' => $this->firstname,
            'surname' => $this->surname,
            'date_of_birth' => $this->date_of_birth,
            'role_id' => 3,
            'gender_id' => $this->gender_id,
            'permission_photos' => $this->permission_photos,
            'shirt_number' => $this->shirt_number,
            'profile_photo_path' => $user->profile_photo_path,
        ]);
    }
}
