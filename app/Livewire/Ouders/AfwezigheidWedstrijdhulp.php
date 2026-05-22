<?php

namespace App\Livewire\Ouders;


use App\Models\PersonPerTask;
use App\Models\TrainingMatch;
use Auth;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AfwezigheidWedstrijdhulp extends Component
{
    public function delete(PersonPerTask $personPerTask)
    {
        $personPerTask->delete(); // Call the delete method on the PersonPerTask model instance
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Afmelding was succesvol",
            'icon' => 'success',
        ]);
    }

    #[Layout('layouts.app', ['title' => 'afwezigheid wedstrijdhulp', 'description' => 'afwezigheid wedstrijdhulp'])]
    public function render()
    {
        $userId = Auth::id(); // Get the ID of the logged-in user

        $wedstrijden = TrainingMatch::where('is_match', true)
            ->whereDate('date', '>=', Carbon::today()) // Ensure the match is in the future or today
            ->whereHas('task_per_activities.person_per_tasks', function($query) use ($userId) {
                $query->where('user_id', $userId); // Check if the user is connected to a task through personPerTask
            })
            ->orderBy('id')
            ->get();

        return view('livewire.ouders.afwezigheid-wedstrijdhulp', compact('wedstrijden', 'userId'));
    }
}
