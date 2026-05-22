<?php

namespace App\Livewire\Forms;

use App\Models\Task;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TaskForm extends Form
{
    public $id = null;
    #[Validate('required|unique:tasks', as: 'Task')]
    public $task = null;

    // read the selected record
    public function read($task)
    {
        $this->id = $task->id;
        $this->task = $task->task;
    }

    // create a new record
    public function create()
    {
        $this->validate();
        Task::create([
            'task' => $this->task,
        ]);
    }

    // update the selected record
    public function update(Task $task)
    {
        $this->validate();
        $task->update([
            'task' => $this->task,
        ]);
    }

    // delete the selected record
    public function delete(Task $task)
    {
        $task->delete();
    }
}
