<?php

namespace App\Livewire\Forms;

use App\Models\Presence;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AanwezigheidSpelerForm extends Form
{
    public $id = null;
    public $present = null;
    public $announced_absent = null;
    public $unannounced_absent = null;

    public function read(Presence $presence)
    {
        $this->id = $presence->id;
        $this->present = $presence->present;
        $this->announced_absent = $presence->announced_absent;
        $this->unannounced_absent = $presence->unannounced_absent;
    }

    public function update()
    {
        // Haal alle gegevens op uit het formulier
        $presence = Presence::findOrFail($this->id);

        // Update de aanwezigheidsgegevens zonder validatie
        $presence->update([
            'present' => $this->present,
            'announced_absent' => $this->announced_absent,
            'unannounced_absent' => $this->unannounced_absent,
        ]);
        $this->reset('present', 'announced_absent', 'unannounced_absent');
    }
}
