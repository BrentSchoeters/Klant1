<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\TaskForm;
use App\Models\Task;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TakenBeheren extends Component
{
    public $search;

    public $showModal = false;
    public TaskForm $form;

    public function newTask(){
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function createTask()
    {
        $this->form->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Taak <b><i>{$this->form->task}</i> toegevoegd</b>",
            'icon' => 'success',
        ]);
    }

    public function editTask(Task $task)
    {
        $this->resetErrorBag();
        $this->form->fill($task);
        $this->showModal = true;
    }

    public function updateTask(Task $task)
    {
        $this->form->update($task);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Taak <b><i>{$this->form->task}</i></b> is bijgewerkt",
            'icon' => 'success',
        ]);
    }

    public function deleteTask(Task $task)
    {
        if ($task->task_per_activities()->count() > 0) {
            $this->dispatch('swal:toast', [
                'background' => 'warning',
                'html' => "Kan taak niet verwijderen <b><i>{$task->task}</i></b> omdat deze gekoppelde records heeft",
                'icon' => 'warning',
            ]);
        } else {
            $this->form->delete($task);
            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "Taak <b><i>{$task->task}</i></b> is verwijderd",
                'icon' => 'success',
            ]);
        }
    }

    #[Layout('layouts.app', ['title' => 'Taken beheren', 'description' => 'Beheer de taken',])]
    public function render()
    {
        $taken = Task::orderBy('task')
            ->searchTask($this->search)
            ->get();

        return view('livewire.admin.taken-beheren', compact('taken'));
    }
}
