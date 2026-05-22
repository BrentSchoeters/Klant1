<?php

namespace App\Livewire\Ouders;

use App\Livewire\Forms\CarpoolForm;
use App\Livewire\Forms\CarpoolRegistrationForm;
use App\Models\Carpool;
use App\Models\CarpoolPerson;
use App\Models\TrainingMatch;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class CarpoolBeheren extends Component
{
    public $loading = 'Please wait...';

    use WithPagination;
    public $perPage = 6;
    public $search;
    public $seats;

    // Forms
    public CarpoolForm $formCarpool;
    public CarpoolRegistrationForm $formCarpoolPerson;

    // Modals
    public $showModalCarpool = false;
    public $showModalRegistration = false;

    public function dateCarpool(Carpool $carpool){
        $training_match = TrainingMatch::all();

        $date = $training_match->firstWhere('id', $carpool->training_match_id)->date;
        return $date;
    }

    // Carpool
    public function newCarpool()
    {
        $this->formCarpool->reset();
        $this->resetErrorBag();
        $this->showModalCarpool = true;
    }

    public function createCarpool()
    {
        $this->formCarpool->create();
        $this->showModalCarpool = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "U heeft succesvol een nieuwe carpool aangemaakt",
            'icon' => 'success',
        ]);
    }

    public function editCarpool(Carpool $carpool)
    {
        $this->resetErrorBag();
        $this->formCarpool->fill($carpool);
        $this->showModalCarpool = true;
    }

    public function updateCarpool(Carpool $carpool)
    {
        $this->formCarpool->update($carpool);
        $this->showModalCarpool = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "U heeft de carpool succesvol bijgewerkt",
            'icon' => 'success',
        ]);
    }

    public function deleteCarpool(Carpool $carpool)
    {
        $this->formCarpool->delete($carpool);
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "U heeft de carpool succesvol verwijderd",
            'icon' => 'success',
        ]);
    }

    // Registration
    public function registrerenCarpool(Carpool $carpool)
    {
        $this->resetErrorBag();
        $this->formCarpool->fill($carpool);
        $this->showModalRegistration = true;
    }

    public function createCarpoolPerson()
    {
        $this->validate([
            'formCarpoolPerson.amount' => 'required',
        ]);

        $userId = auth()->id();
        $carpool = Carpool::find($this->formCarpool->id);

        CarpoolPerson::create([
            'user_id' => $userId,
            'carpool_id' => $carpool->id,
            'amount' => $this->formCarpoolPerson->amount,
        ]);

        $carpool->amount -= $this->formCarpoolPerson->amount;
        $carpool->save();

        $this->showModalRegistration = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "U bent succesvol ingeschreven voor de carpool",
            'icon' => 'success',
        ]);
    }

    public function checkAnnuleer(Carpool $carpool){
        $userId = auth()->user()->id;

        $carpoolIds = [];
        $carpoolPersons = CarpoolPerson::where('user_id', $userId)->get();

        foreach ($carpoolPersons as $carpoolPerson) {
            $carpoolIds[] = $carpoolPerson->carpool_id;
        }

        return $carpoolIds;
    }

    public function annuleerCarpool(Carpool $carpool){
        $userId = auth()->user()->id;
        $carpoolPerson = CarpoolPerson::where('user_id', $userId)
            ->where('carpool_id', $carpool->id)
            ->first();

        if ($carpoolPerson) {
            $carpool->amount += $carpoolPerson->amount;
            $carpool->save();

            $carpoolPerson->delete();

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "U heeft zich succesvol uitgeschreven voor de carpool",
                'icon' => 'success',
            ]);
        } else {
            $this->dispatch('swal:toast', [
                'background' => 'error',
                'html' => "U bent niet ingeschreven voor deze carpool",
                'icon' => 'error',
            ]);
        }
    }

    #[Layout('layouts.app', ['title' => 'Carpools beheren', 'description' => 'Beheer de carpools',])]
    public function render()
    {
        $training_match = TrainingMatch::all();;

        $carpools = Carpool::orderBy('training_match_id')
            ->searchCarpool($this->search)
            ->paginate($this->perPage);

        return view('livewire.ouders.carpool-beheren', compact('carpools','training_match'));
    }
}
