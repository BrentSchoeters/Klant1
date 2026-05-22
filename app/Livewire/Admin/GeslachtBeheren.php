<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\GeslachtBeherenForm;
use App\Models\Gender;
use Livewire\Component;
use Livewire\Attributes\Layout;


class GeslachtBeheren extends Component
{

    public GeslachtBeherenForm $form;
    public $creating = false;
    public $showModal = false;
    public $search;
    #[Layout('layouts.app', ['title' => 'Geslacht', 'description' => 'Beheer de geslachten',])]
    public function render()
    {
        $genders = Gender::OrderBy('id')
            ->searchGender($this->search)
            ->get();
        return view('livewire.admin.geslacht-beheren', compact('genders'));
    }
    public function newGender()
    {
        $this->creating = true;
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }
    public function create()
    {

        $this->form->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Het geslacht <b><i>{$this->form->gender}</i></b> is toegevoegd",
            'icon' => 'success',
        ]);
    }
    public function editGender(Gender $gender)
    {
//        $this->creating = false;
        $this->resetErrorBag();
        $this->form->fill($gender); // Fill the form with the user data
        $this->showModal = true;
    }
    public function updateGender(Gender $gender)
    {
        $this->form->update($gender);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Het geslacht <b><i>{$this->form->gender}</i></b> is geüdpatet",
            'icon' => 'success',
        ]);
    }
    public function delete(Gender $gender)
    {
        $this->form->delete($gender);
        $this->dispatch('swal:toast', [
            'background' => 'warning',
            'html' => "Het geslacht <b><i>{$gender->gender}</i></b> is verwijdered",
            'icon' => 'success',
        ]);
    }
}
