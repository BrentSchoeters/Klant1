<?php

namespace App\Livewire;

use App\Models\Album;
use Livewire\Component;

class Albums extends Component
{
    public function render()
    {
        $albums = Album::orderBy('name')->get();
        return view('livewire.albums', compact('albums'))->layout('layouts.app');
    }
}
