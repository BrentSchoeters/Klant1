<?php

namespace App\Livewire\Trainer;

use App\Livewire\Forms\BetalingRegistrerenForm;
use App\Models\Registration;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BetalingRegistreren extends Component
{
    public BetalingRegistrerenForm $form;
    public $search;
    public $showModal = false;


    #[Layout('layouts.app', ['title' => 'Betalingen', 'description' => 'Registreer de betalingen',])]
    public function render()
    {
        $user = User::where('firstname', $this->search)->first();

        $registraties = Registration::Orderby('id')
            ->searchRegistration($user)
            ->get();


        return view('livewire.trainer.betaling-registreren', compact('registraties'));
    }

    public function newSeason()
    {
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function createSeason()
    {
        $seasonExists = Registration::where('season', $this->form->seizoen)->exists();
        if ($seasonExists){
            $this->dispatch('swal:toast', [
                'background' => 'danger',
                'html' => "Dit seizoen bestaat al",
                'icon' => 'error',
            ]);
        } else {
            $this->form->create();
            $this->showModal = false;
            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "Het nieuwe seizoen is aangemaakt",
                'icon' => 'success',
            ]);
        }


    }
    public function edit(Registration $item)
    {
//        $this->creating = false;
        $this->resetErrorBag();
        $this->form->read($item); // Fill the form with the user data
        $this->showModal = true;
    }

    public function updateBetaling(Registration $item)
    {
        $this->form->update($item);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De betaling status van <b><i>{$item->user->firstname} {$item->user->surname}</i></b> is aangepast",
            'icon' => 'success',
        ]);
    }

    public function deleteSeason()
    {
        $registrations = Registration::where('season', $this->form->seizoen)
            ->get();

        foreach ($registrations as $registration)
        {
            $registration->delete();
        }
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Het nieuwe seizoen is verwijderd",
            'icon' => 'success',
        ]);
    }
}
