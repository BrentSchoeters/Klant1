<?php

namespace App\Livewire\Trainer;

use App\Livewire\Forms\AlbumForm;
use App\Models\Album;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class AlbumsBeheren extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public AlbumForm $form;

    public function newAlbum(){
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function createAlbum()
    {
        $this->form->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Album <b><i>{$this->form->name}</i> toegevoegd</b>",
            'icon' => 'success',
        ]);
    }

    public function editAlbum(Album $album)
    {
        $this->resetErrorBag();
        $this->form->fill($album);
        $this->showModal = true;
    }

    public function updateAlbum(Album $album)
    {
        $this->form->update($album);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Album <b><i>{$this->form->name}</i></b> is bijgewerkt",
            'icon' => 'success',
        ]);
    }

    public function deleteAlbum(Album $album)
    {
        $this->form->delete($album);
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Album <b><i>{$album->name}</i></b> is verwijderd",
            'icon' => 'success',
        ]);
    }

    #[Layout('layouts.app', ['title' => 'Albums', 'description' => 'Beheer de albums',])]
    public function render()
    {
        $albums = Album::orderBy('name')->get();
        return view('livewire.trainer.albums-beheren', compact('albums'));
    }
}
