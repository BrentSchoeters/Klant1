<?php

namespace App\Livewire\Forms;

use App\Models\Album;
use App\Models\Photo;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class PhotoForm extends Form
{
    use WithFileUploads;

    public $id = null;
    public $info = 'Geen beschrijving';
    public $photo;

    public function create($albumId)
    {
        $this->validate([
            'photo' => 'image|max:2048'
        ]);

        logger($this->photo);
        if ($this->photo) {
            $photoPath = $this->photo->store('photos', 'public');
            logger('photoPath =', ['photoPath' => $photoPath]);
            $photoPath = '/storage/' . $photoPath;
        } else {
            $photoPath = '/storage/covers/no-cover.jpg';
            logger('gene foto');
        }

        Photo::create([
            'info' => $this->info,
            'photo_path' => $photoPath,
            'album_id' => $albumId
        ]);

        $this->reset(['info', 'photo']);
    }
}
