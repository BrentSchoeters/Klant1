<?php

namespace App\Livewire\Trainer;

use Livewire\Component;

class Trainer extends Component
{
    public function render()
    {
        return view('livewire.trainer.trainer')->layout('layouts.app');
    }
}
