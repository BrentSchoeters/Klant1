<?php

namespace App\Livewire\Forms;

use App\Models\Clothing;
use Livewire\Attributes\Validate;
use App\Models\ClothingSize;
use Livewire\Form;

class ClothingSizeForm extends Form
{
    public $id = null;
    public $clothing_id = null;
    public $size_id = null;

    public function read($clothingSize)
    {
        $this->id = $clothingSize->id;
        $this->clothing_id = $clothingSize->clothing_id;
        $this->size_id = $clothingSize->size_id;
    }

    // create a new record
    public function create($clothingId, $sizeIds)
    {
        ClothingSize::create([
            'clothing_id' => $clothingId,
            'size_id' => $sizeIds,
        ]);
    }

    // update the selected record
    public function update(ClothingSize $clothingSize)
    {
        $clothingSize->update([
            'clothing_id' => $this->clothing_id,
            'size_id' => $this->size_id,
        ]);
    }

    // delete the selected record
    public function delete(ClothingSize $clothingSize)
    {
        $clothingSize->delete();
    }
}
