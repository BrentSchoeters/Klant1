<?php

namespace App\Livewire\Forms;

use App\Models\Presence;
use App\Models\Task;
use App\Models\TaskPerActivity;
use App\Models\TrainingMatch;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class WedstrijdBeherenForm extends Form
{
    public $user_id;
    public $date;
    public $start;
    public $end;
    public $address;
    public $field;
    public $home;
    public $opponent;
    public $preparation;
    public $id = null;
    #[Validate('required', as: 'training')]
    public $training = null;


    public function read($training)
    {
        $this->id = $training->id;
        $this->opponent = $training->opponent;
        $this->date = $training->date;
        $this->user_id = $training->user_id;
        $this->start = $training->start;
        $this->end = $training->end;
        $this->address = $training->address;
        $this->field = $training->field;
        $this->home = $training->home;
        $this->preparation = $training->preparation;
    }

    public function delete(TrainingMatch $item)
    {
        $item->update([
            'active' => false
        ]);
//        $item->active = false;
//        $item->delete();
    }
    public function create()
    {
        $this->validate([
            'date' => 'required',
            'user_id' => 'required',
            'start' => 'required',
            'address' => 'required',
            'field' => 'required',
            'opponent' => 'required'
        ]);
        $trainingMatch = TrainingMatch::create([
            'date' => $this->date,
            'start' => $this->start,
            'end' => $this->end,
            'address' => $this->address,
            'home' => $this->home,
            'user_id' => $this->user_id,
            'field' => $this->field,
            'is_match' => true,
            'preparation' => $this->preparation,
            'opponent' => $this->opponent
//           preparation_photo_path moet hier nog bij worden gezet, ook in de update en de view
        ]);
        $users = User::whereIn('role_id', [1, 3])->get();
        foreach ($users as $user) {
            Presence::create([
                'user_id' => $user->id,
                'training_match_id' => $trainingMatch->id,
                'present' => true,
                'announced_absent' => false,
                'unannounced_absent' => false,
                'reason' => null
            ]);
        }

        $taken = Task::orderBy('id')->get();

        if ($this->home)
        {
            foreach ($taken as $i => $taak)
            {
                $index = $i + 1;
                $amount = ($index === 2) ? 1 : 2;

                TaskPerActivity::create([
                    'training_match_id' => $trainingMatch->id,
                    'task_id' => $index,
                    'amount' => $amount,
                ]);
            }
        } else {
            TaskPerActivity::create([
                'training_match_id' => $trainingMatch->id,
                'task_id' => 2,
                'amount' => 1,
            ]);
        }

    }
    public function update(TrainingMatch $item)
    {
        $this->validate([
            'date' => 'required',
            'user_id' => 'required',
            'start' => 'required',
            'address' => 'required',
            'field' => 'required',
            'opponent' => 'required'
        ]);

        if ($item->home !== $this->home){
            $tasksPerActivityToDelete = TaskPerActivity::where('training_match_id', $item->id)->get();

            foreach ($tasksPerActivityToDelete as $taskPerActivityToDelete) {
                $taskPerActivityToDelete->delete();
            }

            $taken = Task::orderBy('id')->get();

            if ($this->home){
                foreach ($taken as $i => $taak)
                {
                    $index = $i + 1;
                    $amount = ($index === 2) ? 1 : 2;

                    TaskPerActivity::create([
                        'training_match_id' => $item->id,
                        'task_id' => $index,
                        'amount' => $amount,
                    ]);
                }
            }
            else
            {
                TaskPerActivity::create([
                    'training_match_id' => $item->id,
                    'task_id' => 2,
                    'amount' => 1,
                ]);
            }
        }

        $item->update([
            'opponent' => $this->opponent,
            'date' => $this->date,
            'start' => $this->start,
            'end' => $this->end,
            'address' => $this->address,
            'home' => $this->home,
            'user_id' => $this->user_id,
            'field' => $this->field,
            'is_match' => true,
            'preparation' => $this->preparation
        ]);
    }
}
