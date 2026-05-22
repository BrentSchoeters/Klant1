<?php

namespace App\Livewire;

use App\Models\Album;
use App\Models\Photo;
use Livewire\Component;

class Photos extends Component
{
    public $albumId;
    public $album;
    public $photos;
    public $showModal = false;
    public $selectedPhoto = null;
    public $selectedPhotoIndex = 0;

    public function mount($albumId) // Assume this gets the album ID
    {
        $this->albumId = $albumId;
        $this->album = Album::with('photos')->find($this->albumId);

        if (!$this->album) {
            abort(404, 'Album not found');
        }

        $this->photos = $this->album->photos ?? collect();
    }

    public function openModal($photoId)
    {
        $this->selectedPhoto = Photo::find($photoId);
        $this->selectedPhotoIndex = $this->photos->search($this->selectedPhoto);
        if ($this->selectedPhoto) {
            $this->showModal = true;
        } else {
            // Optionally add error handling if the photo is not found
            $this->addError('selectedPhoto', 'Selected photo could not be found.');
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function nextPhoto()
    {
        if ($this->selectedPhotoIndex < $this->photos->count() - 1) {
            $this->selectedPhotoIndex++;
            $this->selectedPhoto = $this->photos[$this->selectedPhotoIndex];
        }
    }

    public function previousPhoto()
    {
        if ($this->selectedPhotoIndex > 0) {
            $this->selectedPhotoIndex--;
            $this->selectedPhoto = $this->photos[$this->selectedPhotoIndex];
        }
    }



    public function render()
    {
        return view('livewire.photos', [
            'photos' => $this->photos, // Ensure this is always a collection
            'albumName' => $this->album->name,
            'selectedPhoto' => $this->selectedPhoto,
            'selectedPhotoIndex' => $this->selectedPhotoIndex
        ])->layout('layouts.app');
    }
}
