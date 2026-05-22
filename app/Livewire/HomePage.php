<?php

namespace App\Livewire;

use App\Models\TrainingMatch;
use Livewire\Attributes\Layout;
use Livewire\Component;

class HomePage extends Component
{
    #[Layout('layouts.app', ['title' => 'Homepage', 'description' => 'Homepagina van KVV Rauw',])]
    public function render()
    {
        $nextMatches = TrainingMatch::where('is_match', true)
            ->where('date', '>=', now()->toDateString())
            ->where('active', true)
            ->orderBy('date')
            ->take(3)
            ->get();

        return view('livewire.home-page', compact('nextMatches'));
    }
}
