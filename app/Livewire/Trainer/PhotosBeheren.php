<?php

namespace App\Livewire\Trainer;

use App\Livewire\Forms\PhotoForm;
use App\Models\Album;
use App\Models\Photo;
use Livewire\Component;
use Livewire\WithFileUploads;

class PhotosBeheren extends Component
{
    use WithFileUploads;
    public $albumId;
    public $album;
    public $photos;
    public $showModal = false;
    public $showModal2 = false;
    public $selectedPhoto = null;
    public $selectedPhotos = [];
    public $selectedPhotoIndex = 0;

    public PhotoForm $form;

    public function mount($albumId) // Assume this gets the album ID
    {
        $this->albumId = $albumId;
        $this->album = Album::with('photos')->find($this->albumId);

        if (!$this->album) {
            abort(404, 'Album not found');
        }

        $this->photos = $this->album->photos ?? collect();
    }

    public function newPhoto() {
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal2 = true;
    }

    public function createPhoto()
    {
        $this->form->create($this->albumId);
        $this->showModal2 = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Foto is toegevoegd",
            'icon' => 'success',
        ]);
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
        $this->showModal2 = false;
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

    public function deleteSelected()
    {
        // Validate if there are any selected photos
        if (count($this->selectedPhotos) > 0) {
            Photo::whereIn('id', $this->selectedPhotos)->delete();
            $this->selectedPhotos = []; // Reset the selection array

            // Optionally, you can emit an event or flash a message
            $this->photos = Photo::where('album_id', $this->albumId)->get(); // Adjust based on your application logic
        }
    }



    public function render()
    {
        return view('livewire.trainer.photos-beheren', [
            'photos' => $this->photos, // Ensure this is always a collection
            'albumName' => $this->album->name,
            'selectedPhoto' => $this->selectedPhoto,
            'selectedPhotoIndex' => $this->selectedPhotoIndex
        ])->layout('layouts.kvv-rauw');
    }
}
