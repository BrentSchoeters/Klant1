<?php

namespace App\Livewire\Forms;

use App\Models\Registration;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BetalingRegistrerenForm extends Form
{
    public $id = null;
    public $payed;
    public $seizoen;
    #[Validate('required', as: 'betaling')]
    public $betaling = null;


    public function read($betaling)
    {
        $this->id = $betaling->id;
        $this->payed = $betaling->payed;
        $this->seizoen = $betaling->season;

    }
    public function update(Registration $item)
    {
        $this->validate([
            'payed' => 'required',
        ]);

        $item->update([
            'payed' => $this->payed,
            'season' => $this->seizoen
        ]);
    }

    public function create()
    {
        $users = User::where('role_id', 3)
            ->orderBy('id')
            ->get();

        foreach ($users as $user){
            Registration::create([
                'user_id' => $user->id,
                'payed' => false,
                'season' => $this->seizoen
            ]);
        }
    }
}
