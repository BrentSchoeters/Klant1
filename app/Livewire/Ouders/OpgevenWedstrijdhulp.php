<?php

namespace App\Livewire\Ouders;

use App\Livewire\Forms\OpgevenWedstrijdhulpForm;
use App\Models\TaskPerActivity;
use App\Models\TrainingMatch;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\PersonPerTask;
use Illuminate\Support\Facades\Auth;


class OpgevenWedstrijdhulp extends Component
{
    public $match;
    public $loading = 'Even wachten...';
    public OpgevenWedstrijdhulpForm $form;
    public $initialSelectedTasks = [];

    #[Layout('layouts.app', ['title' => 'opgeven wedstrijdhulp', 'description' => 'opgeven wedstrijdhulp'])]
    public function render()
    {
        $wedstrijden = TrainingMatch::where('is_match', true)
            ->where('active', true)
            ->whereDate('date', '>=', Carbon::today()) // kijk dat de match nog niet geweest is
            ->orderBy('id')
            ->get();

        $taakPerActiviteit = $this->match ? TaskPerActivity::where('training_match_id', $this->match)
            ->orderBy('id')
            ->get() : collect();

        if ($this->match) {
            $this->initialSelectedTasks = $this->getSelectedTasks();
            $this->form->tasks = $this->initialSelectedTasks;
        }

        return view('livewire.ouders.opgeven-wedstrijdhulp', compact('wedstrijden', 'taakPerActiviteit'));
    }

    public function updatedMatch($value)
    {
        // Handle match selection change
        $this->match = $value;
        $this->initialSelectedTasks = $this->getSelectedTasks();
        $this->form->tasks = $this->getSelectedTasks();
    }

    protected function getSelectedTasks()
    {
        $taakPerActiviteit = TaskPerActivity::where('training_match_id', $this->match)
            ->pluck('id')
            ->toArray();

        return PersonPerTask::where('user_id', Auth::id())
            ->whereIn('task_per_activity_id', $taakPerActiviteit)
            ->pluck('task_per_activity_id')
            ->toArray();
    }

    public function voorkeurRegistreren()
    {
        $currentTasks = collect($this->form->tasks)->filter();
        $tasksToDelete = collect($this->initialSelectedTasks)->diff($currentTasks);
        $tasksToAdd = $currentTasks->diff($this->initialSelectedTasks);

        // Add new tasks
        foreach ($tasksToAdd as $task) {
            PersonPerTask::updateOrCreate([
                'user_id' => Auth::id(),
                'task_per_activity_id' => $task
            ]);
        }

        // Delete unselected tasks
        foreach ($tasksToDelete as $task) {
            PersonPerTask::where('user_id', Auth::id())
                ->where('task_per_activity_id', $task)
                ->delete();
        }

        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Uw voorkeuren zijn opgeslagen",
            'icon' => 'success',
        ]);
    }

}
