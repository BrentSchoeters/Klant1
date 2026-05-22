<?php

namespace App\Livewire\Forms;

use App\Models\Carpool;
use App\Models\CarpoolPerson;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CarpoolRegistrationForm extends Form
{
    public $id = null;
    public $user_id = null;
    public $carpool_id = null;
    #[Validate('required|numeric', as: 'aantal plaatsen')]
    public $amount = null;

    protected $messages = [
        'amount.required' => 'De hoeveelheid zitplaatsen is verplicht.',
        'amount.numeric' => 'De hoeveelheid zitplaatsen moet een nummer zijn.',
    ];

    // Read the selected record
    public function read($carpoolPerson)
    {
        $this->id = $carpoolPerson->id;
        $this->user_id = $carpoolPerson->user_id;
        $this->carpool_id = $carpoolPerson->carpool_id;
        $this->amount = $carpoolPerson->amount;
    }

    // Update the selected record
    public function update(CarpoolPerson $carpoolPerson)
    {
        $this->validate();
        $carpoolPerson->update([
            'user_id' => $this->user_id,
            'carpool_id' => $this->carpool_id,
            'amount' => $this->amount,
        ]);
    }

    // Delete the selected record
    public function delete(CarpoolPerson $carpoolPerson)
    {
        $carpoolPerson->delete();
    }
}
