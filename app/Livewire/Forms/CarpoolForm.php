<?php

namespace App\Livewire\Forms;

use App\Models\Carpool;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CarpoolForm extends Form
{
    public $id = null;
    public $user_id = null;
    #[Validate('required', as: 'match')]
    public $training_match_id = null;
    #[Validate('required', as: 'tijdstip van de carpool')]
    public $time = null;
    #[Validate('required|max:30', as: 'vertrekplaats van de carpool')]
    public $address = null;
    #[Validate('required|numeric|min:1', as: 'aantal zitplaatsen')]
    public $amount = null;

    protected $messages = [
        'training_match_id.required' => 'Selecteer een match of training',
        'time.required' => 'Tijdstip is verplicht',
        'address.required' => 'Address is verplicht',
        'address.max' => 'The vertrekplaats van de carpool mag maximum :max characters lang zijn',
        'amount.required' => 'De hoeveelheid zitplaatsen is verplicht',
        'amount.min' => 'De hoeveelheid zitplaatsen moet groter zijn dan 0',
    ];

    // Read the selected record
    public function read($carpool)
    {
        $this->id = $carpool->id;
        $this->user_id = $carpool->user_id;
        $this->training_match_id = $carpool->training_match_id;
        $this->amount = $carpool->amount;
        $this->time = $carpool->time;
        $this->address = $carpool->address;
    }

    // Create a new record
    public function create()
    {
        $this->validate();

        $userId = auth()->id();

        Carpool::create([
            'user_id' => $userId,
            'training_match_id' => $this->training_match_id,
            'time' => $this->time,
            'address' => $this->address,
            'amount' => $this->amount,
        ]);
    }

    // Update the selected record
    public function update(Carpool $carpool)
    {
        $this->validate();
        $carpool->update([
            'user_id' => $this->user_id,
            'training_match_id' => $this->training_match_id,
            'amount' => $this->amount,
            'time' => $this->time,
            'address' => $this->address,
        ]);
    }

    // Delete the selected record
    public function delete(Carpool $carpool)
    {
        $carpool->delete();
    }
}
