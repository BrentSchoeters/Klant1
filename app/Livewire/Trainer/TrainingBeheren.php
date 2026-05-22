<?php

namespace App\Livewire\Trainer;

use App\Livewire\Forms\TrainingBeherenForm;
use App\Models\TrainingMatch;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TrainingBeheren extends Component
{
    public TrainingBeherenForm $form;
    public $creating = false;
    public $showModal = false;
    public $search;


    #[Layout('layouts.app', ['title' => 'Training', 'description' => 'Beheer de trainingen',])]
    public function render()
    {
        $training = TrainingMatch::where('is_match', false)
            ->where('active', true)
            ->Orderby('date')
            ->searchTraining($this->search)
            ->get();

        return view('livewire.trainer.training-beheren', compact('training'));
    }

    public function newTraining()
    {
        $this->creating = true;
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }
    public function createTraining()
    {

        $this->form->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De training op <b><i>{$this->form->date}</i></b> is toegevoegd",
            'icon' => 'success',
        ]);
    }
    public function editTraining(TrainingMatch $item)
    {
//        $this->creating = false;
        $this->resetErrorBag();
        $this->form->fill($item); // Fill the form with the user data
        $this->showModal = true;
    }
    public function updateTraining(TrainingMatch $item)
    {
        $this->form->update($item);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De training op <b><i>{$this->form->date}</i></b> is bijgewerkt",
            'icon' => 'success',
        ]);
    }
    public function deleteTraining(TrainingMatch $item)
    {
        $this->form->delete($item);
        $this->dispatch('swal:toast', [
            'background' => 'warning',
            'html' => "De training op <b><i>{$item->date}</i></b> is verwijderd",
            'icon' => 'success',
        ]);
    }
}
