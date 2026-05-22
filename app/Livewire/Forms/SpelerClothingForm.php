<?php

namespace App\Livewire\Forms;

use App\Models\ClothingPerPlayer;
use App\Models\ClothingSize;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SpelerClothingForm extends Form
{
    public $user_id = null;
    public $clothing_size_id = null;

    public function read($SpelerClothing)
    {
        $this->user_id = $SpelerClothing->user_id;
        $this->clothing_size_id = $SpelerClothing->clothing_size_id;
    }
    public function create($clothingNumber)
    {
        $clothingId = $clothingNumber;
        $sizeId = 'clothing_size_id';

        $clothing_size_id = ClothingSize::where('clothing_id', $clothingId)
            ->where('size_id', $sizeId)
            ->value('id');

        $lastChildId = User::orderBy('id', 'desc')->value('id');

        $this->user_id = $lastChildId;

        ClothingPerPlayer::create([
            'user_id' => $this->user_id,
            'clothing_size_id' => $this->clothing_size_id
        ]);
    }
    public function update(ClothingPerPlayer $user)
    {
        $user->update([
            'firstname' => $this->firstname,
            'surname' => $this->surname,
            'date_of_birth' => $this->date_of_birth,
            'role_id' => 3,
            'gender_id' => $this->gender_id,
            'permission_photos' => $this->permission_photos,
            'shirt_number' => $this->shirt_number,
        ]);
    }
}
