<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\ClothingForm;
use App\Livewire\Forms\ClothingSizeForm;
use App\Livewire\Forms\SizeForm;
use App\Models\Clothing;
use App\Models\ClothingSize;
use App\Models\Size;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class kledingBeheren extends Component
{
    public $search;
    public $currentView = 'kleding';

    public SizeForm $formSize;
    public ClothingForm $formClothing;
    public ClothingSizeForm $formClothingSize;

    public $showModalClothing = false;
    public $showModalSize = false;
    public $selectedSizes = [];
    public $selectedClothing = [];

    public function toggleView()
    {
        $this->currentView = $this->currentView === 'kleding' ? 'kledingmaten' : 'kleding';
    }

    // Clothing
    public function newClothing()
    {
        $this->formClothing->reset();
        $this->selectedSizes = [];
        $this->resetErrorBag();
        $this->showModalClothing = true;
    }

    public function createClothing()
    {
        $clothing = $this->formClothing->create();

        foreach ($this->selectedSizes as $sizeId => $selected) {
            if ($selected) {
                $this->formClothingSize->create($clothing->id, $sizeId);
            }
        }

        $this->showModalClothing = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Kleding <b>{$this->formClothing->clothing}</b> toegevoegd",
            'icon' => 'success',
        ]);
    }

    public function editClothing(Clothing $item)
    {
        $this->resetErrorBag();

        $currentSizes = ClothingSize::where('clothing_id', $item->id)->get();
        $this->selectedSizes = [];
        foreach ($currentSizes as $size) {
            $this->selectedSizes[$size->size_id] = true;
        }

        $this->formClothing->fill($item);
        $this->showModalClothing = true;
    }

    public function updateClothing(Clothing $item)
    {
        $this->formClothing->update($item);

        ClothingSize::where('clothing_id', $item->id)->delete();
        foreach ($this->selectedSizes as $sizeId => $selected) {
            if ($selected) {
                $this->formClothingSize->create($item->id, $sizeId);
            }
        }

        $this->showModalClothing = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Kleding <b>{$this->formClothing->clothing}</b> is bijgewerkt",
            'icon' => 'success',
        ]);
    }

    public function deleteClothing(Clothing $clothing)
    {
        $this->formClothing->delete($clothing);
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Kleding <b><i>{$clothing->clothing}</i></b> is verwijderd",
            'icon' => 'success',
        ]);
    }

    // Size
    public function newSize()
    {
        $this->formSize->reset();
        $this->resetErrorBag();
        $this->showModalSize = true;
    }

    public function createSize()
    {
        $this->formSize->create();

        $this->showModalSize = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Kledingmaat <b><i>{$this->formSize->size}</i> toegevoegd</b>",
            'icon' => 'success',
        ]);
    }

    public function editSize(Size $size)
    {
        $this->resetErrorBag();
        $this->formSize->fill($size);
        $this->showModalSize = true;
    }

    public function updateSize(Size $size)
    {
        $this->formSize->update($size);
        $this->showModalSize = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Kledingmaat <b><i>{$this->formSize->size}</i></b> is bijgewerkt",
            'icon' => 'success',
        ]);
    }

    public function deleteSize(size $size)
    {
        $this->formSize->delete($size);
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Kledingmaat <b><i>{$size->size}</i></b> is verwijderd",
            'icon' => 'success',
        ]);
    }

    #[Layout('layouts.app', ['title' => 'Kleding', 'description' => 'Beheer de kleding',])]
    public function render()
    {
        $clothingSizes = ClothingSize::all();

        $clothing = Clothing::OrderBy('id')
            ->searchClothing($this->search)
            ->get();

        $Sizes = Size::orderBy('size')
            ->searchSize($this->search)
            ->get();

        return view('livewire.admin.kledingBeheren', compact('clothing', 'Sizes', 'clothingSizes'));
    }
}
