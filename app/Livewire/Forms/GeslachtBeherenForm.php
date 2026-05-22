<?php

namespace App\Livewire\Forms;

use App\Models\Gender;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GeslachtBeherenForm extends Form
{

    public $id = null;
    #[Validate('required', as: 'gender')]
    public $gender = null;


    public function read($gender)
    {
        $this->id = $gender->id;
        $this->gender = $gender->gender;
    }

    public function delete(Gender $gender)
    {
        $gender->delete();
    }
    public function create()
    {
        $this->validate([
            'gender' => 'required|unique:genders,gender'
        ]);
        Gender::create([
            'gender' => $this->gender
        ]);
    }
    public function update(Gender $gender)
    {
        $this->validate([
            'gender' => 'required|unique:genders,gender'
        ]);

        $gender->update([
            'gender' => $this->gender,
        ]);
    }
}
