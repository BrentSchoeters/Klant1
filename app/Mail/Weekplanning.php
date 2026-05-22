<?php

namespace App\Mail;

use App\Livewire\Ouders\Ouders;
use App\Models\PersonPerTask;
use App\Models\TrainingMatch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Weekplanning extends Mailable
{
    use Queueable, SerializesModels;
    public $receiver;
    public $taskPersons;
    public $matches;
    public $trainings;
    public $currentWeekNumber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $receiver)
    {
        $this->receiver = $receiver;

        $this->taskPersons = PersonPerTask::all();

        $this->matches = TrainingMatch::where('is_match', true)
            ->whereBetween('date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->get();

        $this->trainings = TrainingMatch::where('is_match',false)
            ->whereBetween('date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->get();

        $this->currentWeekNumber = Carbon::now()->weekOfYear;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.weekplanning')
            ->with([
                'receiver' => $this->receiver,
                'taskPersons' => $this->taskPersons,
                'matches' => $this->matches,
                'trainings' => $this->trainings,
                'currentWeekNumber' => $this->currentWeekNumber,
            ]);
    }
}
