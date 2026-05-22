<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\MailsBeherenForm;
use App\Mail\TrainerAbsentNotification;
use App\Mail\TrainerAfwezig;
use App\Mail\Weekplanning;
use App\Models\MailTemplate;
use App\Models\TrainingMatch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class MailsBeheren extends Component
{
    public $search;
    public MailsBeherenForm $formMailsBeheren;
    public $eventDetails;

    public function sendMail($id)
    {
        $mail = MailTemplate::findOrFail($id);
        if ($id === 1) {
            $receivers = User::whereIn('role_id', [1, 2, 4])->get();

            foreach ($receivers as $receiver) {
                Mail::to($receiver->email)->send(new Weekplanning($receiver));
            }
            session()->flash('message', 'Mail sent successfully.');

        } elseif ($id === 2) {
            // Fetch the event details and trainer information
            $trainer = User::where('role_id', 3)->first(); // Example: role_id 3 for trainers
            $eventDetails = TrainingMatch::where('is_match', true) // or false based on your criteria
            ->whereBetween('date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->first(); // Fetch the first event of the week for example

            // Fetch receivers (e.g., parents) to notify
            $receivers = User::whereIn('role_id', [1, 2, 4])->get();

            foreach ($receivers as $receiver) {
                Mail::to($receiver->email)->send(new TrainerAbsentNotification($trainer, $eventDetails));
            }
            session()->flash('message', 'Trainer absent notification sent successfully.');
        }
    }

    #[Layout('layouts.app', ['title' => 'Mail template', 'description' => 'Beheer de mail template',])]
    public function render()
    {
        $mails = MailTemplate::orderBy('id')
            ->searchMailTemplate($this->search)
            ->get();

        return view('livewire.admin.mails-beheren', compact('mails'));
    }
}
