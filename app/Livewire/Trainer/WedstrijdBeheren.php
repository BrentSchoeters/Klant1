<?php

namespace App\Livewire\Trainer;

use App\Livewire\Forms\WedstrijdBeherenForm;
use App\Models\TrainingMatch;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class WedstrijdBeheren extends Component
{
    public WedstrijdBeherenForm $form;
    public $creating = false;
    public $showModal = false;
    public $search;


    #[Layout('layouts.app', ['title' => 'Wedstrijd', 'description' => 'Beheer de wedstrijden',])]
    public function render()
    {
        $ouders = User::where('role_id', 4)
            ->Orderby('id')
            ->get();

        $wedstrijd = TrainingMatch::where('is_match', true)
            ->where('active', true)
            ->Orderby('date')
            ->searchWedstrijd($this->search)
            ->get();

        return view('livewire.trainer.wedstrijd-beheren', compact('wedstrijd', 'ouders'));
    }

    public function newMatch()
    {
        $this->creating = true;
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }
    public function createMatch()
    {

        $this->form->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De wedstrijd tegen <b><i>{$this->form->opponent}</i></b> is toegevoegd",
            'icon' => 'success',
        ]);
    }
    public function editMatch(TrainingMatch $item)
    {
//        $this->creating = false;
        $this->resetErrorBag();
        $this->form->fill($item); // Fill the form with the user data
        $this->showModal = true;
    }
    public function updateMatch(TrainingMatch $item)
    {
        $this->form->update($item);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De wedstrijd op <b><i>{$this->form->date}</i></b> is bijgewerkt",
            'icon' => 'success',
        ]);
    }
    public function deleteMatch(TrainingMatch $item)
    {
        $this->form->delete($item);
        $this->dispatch('swal:toast', [
            'background' => 'warning',
            'html' => "De wedstrijd op <b><i>{$item->date}</i></b> is verwijderd",
            'icon' => 'success',
        ]);
    }
}
