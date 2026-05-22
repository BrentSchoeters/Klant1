<?php

namespace App\Livewire\Forms;

use App\Models\User;
use App\Models\ParentPerChild;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ParentPerChildForm extends Form
{
    public $child_id = null;
    public $parent_id = null;


    public function read($parentPerChild)
    {
        $this->child_id = $parentPerChild->child_id;
        $this->parent_id = $parentPerChild->parent_id;
    }

    public function setData($child_id)
    {
        $this->child_id = $child_id;
    }

    public function create()
    {


        ParentPerChild::create([
            'child_id' => $this->child_id,
            'parent_id' => $this->parent_id
        ]);
    }

    public function update(ParentPerChild $parentPerChild)
    {
        $childId = $parentPerChild->child_id;

        $parentPerChild->update([
            'child_id' => $childId,
            'parent_id' => $this->parent_id
        ]);
    }
}
