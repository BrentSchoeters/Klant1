<?php

namespace App\Livewire;

use App\Models\TrainingMatch;
use Livewire\Attributes\Layout;
use Livewire\Component;

class EventDetails extends Component
{
    #[Layout('layouts.app', ['title' => 'Extra info', 'description' => 'extra info van training of wedstrijd',])]
    public $eventId;
    public $eventDetails;

    public function mount($eventId)
    {
        logger('Mount methode aangeroepen met eventId: ' . $eventId);
        $this->eventId = $eventId;

        // Haal de details van het evenement op uit de database op basis van het event ID
        $this->eventDetails = TrainingMatch::find($eventId);

        // Controleer of het evenement is gevonden
        if (!$this->eventDetails) {
            // Als het evenement niet is gevonden, stel eventDetails in op null
            $this->eventDetails = null;
            // Optioneel: Toon een foutmelding aan de gebruiker of neem andere acties
        }
    }
    public function selectEvent($eventId)
    {
        logger('deze id' . $eventId);
        $this->selectedEventId = $eventId;

        // Haal de details van het evenement op uit de database op basis van het event ID
        $this->eventDetails = TrainingMatch::find($eventId);

        // Controleer of het evenement is gevonden
        if (!$this->eventDetails) {
            // Als het evenement niet is gevonden, stel eventDetails in op null
            $this->eventDetails = null;
            // Optioneel: Toon een foutmelding aan de gebruiker of neem andere acties
        }
    }


    public function render()
    {
        return view('livewire.event-details');
    }

}
