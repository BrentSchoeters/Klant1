<?php

namespace App\Livewire;

use App\Livewire\Forms\AanwezigheidSpelerForm;
use App\Mail\TrainerAbsentNotification;
use App\Models\ParentPerChild;
use App\Models\Presence;
use App\Models\TrainingMatch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Kalender extends Component
{
    public $selectedEventId;
    public $eventDetails;

    public $eventId = 0;
    public AanwezigheidSpelerForm $form;
    public $showModal = false;
    public $showModalSpeler = false; // modal voor kind afwezig te melden
    public $showModalTrainer = false; // modal voor trainer afwezig te melden
    public $children = [];
    public $selectedChildId;
    public $reason = '';
    public $userRole;

    #[On('process-event')]
    public function process_event($event_id)
    {
        $this->form->reset();
        $this->eventDetails = TrainingMatch::find($event_id);
    }


    public function editPresence(Presence $presences)
    {
        $this->resetErrorBag();
        $this->form->fill($presences); // Fill the form with the user data
        $this->showModal = true;
        $this->eventDetails->refresh();
    }

    public function setTrainerAbsent()
    {
        $this->showModalTrainer = true;

    }

    public function updatePresence($presenceId, $present = false, $announcedAbsent = false, $unannouncedAbsent = false)
    {
        $presence = Presence::findOrFail($presenceId);

        // Update de aanwezigheidsgegevens in de database
        $presence->update([
            'present' => $present,
            'announced_absent' => $announcedAbsent,
            'unannounced_absent' => $unannouncedAbsent,
        ]);

        // Refresh the form with updated data from the database
        $this->form->read($presence);

        // Roep de read() methode aan om de waarden van de radiobuttons opnieuw in te stellen
        $this->form->reset();
    }


    public function setPlayerAbsent()
    {
        $this->showModalSpeler = true;
    }

    public function reportAbsencePlayer()
    {

        $this->validate([
            'selectedChildId' => 'required',
            'reason' => 'required',
        ]);

        $presence = Presence::where('user_id', $this->selectedChildId)
            ->where('training_match_id', $this->eventDetails->id)
            ->first();

        if ($presence) {
            $presence->update([
                'present' => false,
                'announced_absent' => true,
                'unannounced_absent' => false,
                'reason' => $this->reason,
            ]);
        } else {
            session()->flash('error', 'Aanwezigheidsinformatie niet gevonden voor dit kind.');
        }

        $this->reset(['selectedChildId', 'reason']);
        $this->showModalSpeler = false;

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'Afwezigheid gemeld',
            'text' => 'De afwezigheid van het kind is succesvol gemeld.',
        ]);
    }

    public function reportAbsenceTrainer()
    {
        $presence = Presence::where('training_match_id', $this->eventDetails->id)->first();

        if ($presence) {
            $presence->update([
                'present' => false,
                'announced_absent' => true,
                'unannounced_absent' => false,
                'reason' => $this->reason,
            ]);

            // Find other trainers to notify
            $otherTrainers = User::where('role_id', 1)->where('id', '!=', Auth::id())->get();
            $parentEmails = [];

            if ($otherTrainers->isEmpty()) {
                // Get all users with role_id 4 (assuming 4 is the role ID for parents)
                $parentEmails = User::where('role_id', 4)->pluck('email')->unique()->toArray();
            } else {
                foreach ($otherTrainers as $trainer) {
                    Mail::to($trainer->email)->send(new TrainerAbsentNotification(Auth::user(), $this->eventDetails));
                }
            }

            if (!empty($parentEmails)) {
                Mail::to($parentEmails)->send(new TrainerAbsentNotification(Auth::user(), $this->eventDetails));
            }

            $this->reset('reason');
            $this->showModalTrainer = false;

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "U bent succesvol afwezig gemeld",
                'icon' => 'success',
            ]);
        } else {
            session()->flash('error', 'Aanwezigheidsinformatie niet gevonden voor u.');
        }
    }


    public function mount()
    {
        // Initialiseer het Presence model binnen de component
        $this->presence = new Presence();
    }


    #[Layout('layouts.app', ['title' => 'kalender', 'description' => 'Bekijk wanneer er wedstrijden of trainingen zijn',])]
    public function render()
    {
        $events = TrainingMatch::where('active', true)->get()->map(function ($match) {
            // Converteer de datumstring naar een DateTime-object
            $startDate = \DateTime::createFromFormat('Y-m-d H:i:s', $match->date . ' ' . $match->start);

            return [
                'id' => $match->id,
                'title' => $match->is_match ? 'Wedstrijd' : 'Training',
                // Gebruik 'H:i' om de tijd in 24-uursformaat weer te geven
                'start' => $startDate->format('Y-m-d\TH:i:s'), // Zorg ervoor dat het formaat voldoet aan ISO 8601
                'color' => $match->is_match ? 'darkred' : 'green',
                // Andere opties zoals end, url, etc. kunnen hier ook worden toegevoegd
            ];
        })->toArray();
        $user = User::find(Auth::id());
        if ($user) {
            $this->userRole = $user->role_id;
            if ($user->role_id === 4) {
                $parentChild = ParentPerChild::where('parent_id', $user->id)->orderBy('id')->get();
                $childIds = $parentChild->pluck('child_id');

                $children = User::whereIn('id', $childIds)->orderBy('id')->get();
                $this->children = $children;
                return view('livewire.kalender', ['children' => $children, 'events' => $events]);
            } else {
                return view('livewire.kalender', ['events' => $events]);
            }
        } else {
            return view('livewire.kalender', ['events' => $events]);
        }


    }
}
