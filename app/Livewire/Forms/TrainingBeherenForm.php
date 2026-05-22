<?php

namespace App\Livewire\Forms;

use App\Models\Presence;
use App\Models\TrainingMatch;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TrainingBeherenForm extends Form
{

    public $date;
    public $start;
    public $end;
    public $address;
    public $field;
    public $preparation;
    public $id = null;
    public $weeks;
    #[Validate('required', as: 'training')]
    public $training = null;


    public function read($training)
    {
        $this->id = $training->id;
        $this->training = $training->date;
    }

    public function delete(TrainingMatch $item)
    {
        $item->update([
            'active' => false
        ]);
    }
    public function create()
    {
        $newDate = $this->date;
        for ($i = 0; $i < $this->weeks; $i++){
            $this->validate([
                'date' => 'required',
                'start' => 'required',
                'address' => 'required',
                'field' => 'required',
                'weeks' => 'required|min:1'
            ]);
            $trainingMatch = TrainingMatch::create([
                'date' => $newDate,
                'start' => $this->start,
                'end' => $this->end,
                'address' => $this->address,
                'home' => true,
                'field' => $this->field,
                'is_match' => false,
                'preparation' => $this->preparation
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

            $newDate = Carbon::parse($newDate)->addWeek();;
        }

    }
    public function update(TrainingMatch $item)
    {
        $this->validate([
            'date' => 'required',
            'start' => 'required',
            'address' => 'required',
            'field' => 'required',
        ]);

        $item->update([
            'date' => $this->date,
            'start' => $this->start,
            'end' => $this->end,
            'address' => $this->address,
            'home' => true,
            'field' => $this->field,
            'is_match' => false,
            'preparation' => $this->preparation
        ]);
    }
}
