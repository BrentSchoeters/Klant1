<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public $id = null;
    public $isCreating = true;

    #[Validate('required|max:30')]
    public $firstname = null;

    #[Validate('required|max:30')]
    public $surname = null;

    #[Validate('required|email')]
    public $email = null;

    #[Validate('required|date')]
    public $date_of_birth = null;

    #[Validate('required|max:50')]
    public $street_number = null;

    #[Validate('required|regex:/^\d+$/')]
    public $zipcode = null;

    #[Validate('required|max:50')]
    public $city = null;

    #[Validate('required|regex:/^[\d\+]+$/')]
    public $phone_number = null;

    #[Validate('required|notin:0')]
    public $role_id = null;

    #[Validate('required|notin:0')]
    public $gender_id = null;

    #[Validate('required|in:0,1')]
    public $permission_photos = null;

   #[Validate('required|min:8')]
    public $password = null;

   protected $messages =[
     'firstname.required' => "Voornaam van de gebruiker is verplicht en mag maximaal 30 karakters bevatten.",
       'surname.required' => "Achternaam van de gebruiker is verplicht en mag maximaal 30 karakters bevatten",
       'email.required' => 'E-mail van de gebruiker is verplicht en moet een geldig e-mailadres zijn',
       'date_of_birth' => 'Geboortedatum van de gebruiker is verplicht en moet een geldige datum zijn',
       'street_number.required' => 'Adres van de gebruiker is verplicht en mag maximaal 50 karakters bevatten',
       'zipcode.required' => 'Postcode van de gebruiker is verplicht en mag alleen numerieke karakters bevatten',
       'city.required' => 'Gemeente van de gebruiker is verplicht en mag maximaal 50 karakters bevatten',
       'phone_number.required' => 'Gsmnummer van de gebruiker is verplicht en mag alleen numerieke karakters en het plus-teken bevatten',
       'role_id.required' => 'Kies een geldige rol voor de gebruiker',
       'gender_id' => 'Kies een geldige gender voor de gebruiker',
       'permission_photos.required' => 'Kies een geldige permissie voor de gebruiker',
       'password.required' => 'Wachtwoord is verplicht en moet minimaal 8 tekens bevatten'
   ];
    public function read($user)
    {
        $this->id = $user->id;
        $this->firstname = $user->firstname;
        $this->surname = $user->surname;
        $this->email = $user->email;
        $this->date_of_birth = $user->date_of_birth;
        $this->street_number = $user->street_number;
        $this->zipcode = $user->zipcode;
        $this->city = $user->city;
        $this->phone_number = $user->phone_number;
        $this->role_id = $user->role_id;
        $this->gender_id = $user->gender_id;
        $this->permission_photos = $user->permission_photos;
    }

    public function create()
    {
        $this->validate();
        User::create([
            'firstname' => $this->firstname,
            'surname' => $this->surname,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'street_number' => $this->street_number,
            'zipcode' => $this->zipcode,
            'city' => $this->city,
            'phone_number' => $this->phone_number,
            'role_id' => $this->role_id,
            'gender_id' => $this->gender_id,
            'permission_photos' => $this->permission_photos,
            'password' => Hash::make($this->password),
        ]);
    }

    // update the selected record
    public function update(User $user)
    {
        $this->validate([
            'firstname' => 'required|min:2|max:30',
            'surname' => 'required|max:30',
            'email' => 'required|email',
            'date_of_birth' => 'required|date',
            'street_number' => 'required|max:50',
            'zipcode' => 'required|regex:/^\d+$/',
            'city' => 'required|max:50',
            'phone_number' => 'required|regex:/^[\d\+]+$/',
            'role_id' => 'required|notin:0',
            'gender_id' => 'required|notin:0',
            'permission_photos' => 'required|in:0,1',
        ]);
            $user->update([
            'firstname' => $this->firstname,
            'surname' => $this->surname,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'street_number' => $this->street_number,
            'zipcode' => $this->zipcode,
            'city' => $this->city,
            'phone_number' => $this->phone_number,
            'role_id' => $this->role_id,
            'gender_id' => $this->gender_id,
            'permission_photos' => $this->permission_photos,
        ]);
    }
}
