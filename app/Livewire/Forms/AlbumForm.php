<?php

namespace App\Livewire\Forms;

use App\Models\Album;
use App\Models\Size;
use Image;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use Storage;

class AlbumForm extends Form
{
    use WithFileUploads;

    public $id = null;
    #[Validate('required', as: 'albumnaam')]
    public $name = null;

    public $cover;

    public function read($album)
    {
        $this->id = $album->id;
        $this->name = $album->name;
        $this->cover = $album->cover_photo_path;
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'cover' => 'image|max:2048'
        ]);

        logger($this->cover);
        if ($this->cover) {
            $coverPath = $this->cover->store('covers', 'public');
            logger('coverpath =', ['coverPath' => $coverPath]);
            $coverPath = '/storage/' . $coverPath;
        } else {
            $coverPath = '/storage/covers/no-cover.jpg';
            logger('gene foto');
        }

        Album::create([
            'name' => $this->name,
            'cover_photo_path' => $coverPath
        ]);

        $this->reset(['name', 'cover']);
    }

    public function update(Album $album)
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'cover' => 'image|max:2048'
        ]);

        if ($this->cover) {
            // Delete the old image
            if ($album->cover_photo_path ) {
                $path = str_replace('/storage/', '', $album->cover_photo_path);
                Storage::disk('public')->delete($path);
            }

            $coverPath = $this->cover->store('covers', 'public');
            $coverPath = '/storage/' . $coverPath;
        } else {
            $coverPath = $album->cover_photo_path; // Retain the old cover path if no new image is uploaded
        }

        $album->update([
            'name' => $this->name,
            'cover_photo_path' => $coverPath
        ]);
    }

    public function delete(Album $album)
    {
        if ($album->cover_photo_path) {
            $path = str_replace('/storage/', '', $album->cover_photo_path);
            Storage::disk('public')->delete($path);
        }
        $album->delete();
    }
}
