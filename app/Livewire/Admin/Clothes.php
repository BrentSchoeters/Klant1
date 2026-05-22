<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\ClothingForm;
use App\Models\Clothing;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Clothes extends Component
{
    public ClothingForm $form;
    public $creating = false;
    public $showModal = false;
    public $search;

    #[Layout('layouts.app', ['title' => 'Kleding', 'description' => 'Beheer de kleding',])]
    public function render()
    {
        $kleding = Clothing::OrderBy('id')
            ->searchClothing($this->search)
            ->get();
        return view('livewire.admin.clothes', compact('kleding'));
    }
    public function newClothing()
    {
        $this->creating = true;
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }
    public function createClothing()
    {

        $this->form->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Het kledingstuk <b><i>{$this->form->clothing}</i></b> is toegevoegd",
            'icon' => 'success',
        ]);
    }
    public function editClothing(Clothing $item)
    {
//        $this->creating = false;
        $this->resetErrorBag();
        $this->form->fill($item); // Fill the form with the user data
        $this->showModal = true;
    }
    public function updateClothing(Clothing $item)
    {
        $this->form->update($item);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Het kledingstuk <b><i>{$this->form->clothing}</i></b> is bijgewerkt",
            'icon' => 'success',
        ]);
    }
    public function deleteClothing(Clothing $item)
    {
        $this->form->delete($item);
        $this->dispatch('swal:toast', [
            'background' => 'warning',
            'html' => "Het kledingstuk <b><i>{$this->form->clothing}</i></b> is verwijderd",
            'icon' => 'success',
        ]);
    }
}
