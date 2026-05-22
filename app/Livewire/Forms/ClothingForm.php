<?php

namespace App\Livewire\Forms;

use App\Models\Clothing;
use App\Models\ClothingSize;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ClothingForm extends Form
{
    public $id = null;
    #[Validate('required|unique:clothing,id', as: 'kleding')]
    public $clothing = null;

    protected $messages = [
        'clothing.required' => 'Selecteer een kledingstuk',
        'clothing.unique' => 'kledingstuk moet uniek zijn',
    ];

    // read the selected record
    public function read($clothing)
    {
        $this->id = $clothing->id;
        $this->clothing = $clothing->size;
    }

    // create a new record
    public function create()
    {
        $this->validate();
        return Clothing::create([
            'clothing' => $this->clothing
        ]);
    }

    // update the selected record
    public function update(Clothing $item)
    {
        $this->validate();
        $item->update([
            'clothing' => $this->clothing,
        ]);
    }

    // delete the selected record
    public function delete(Clothing $item)
    {
        $item->delete();
    }
}
