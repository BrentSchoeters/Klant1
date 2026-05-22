<?php

namespace App\Livewire\Forms;

use App\Models\Size;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SizeForm extends Form
{
    public $id = null;
    #[Validate('required|unique:sizes,id', as: 'kledingmaat')]
    public $size = null;

    protected $messages = [
        'size.required' => 'Selecteer een kledingmaat',
        'size.unique' => 'kledingmaat moet uniek zijn',
    ];

    // read the selected record
    public function read($size)
    {
        $this->id = $size->id;
        $this->size = $size->size;
    }

    // create a new record
    public function create()
    {
        $this->validate();

        Size::create([
            'size' => $this->size,
        ]);
    }

    // update the selected record
    public function update(Size $size)
    {
        $this->validate();
        $size->update([
            'size' => $this->size,
        ]);
    }

    // delete the selected record
    public function delete(Size $size)
    {
        $size->delete();
    }
}
