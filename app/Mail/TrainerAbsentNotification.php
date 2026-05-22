<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrainerAbsentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $trainer;
    public $eventDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($trainer, $eventDetails)
    {
        $this->trainer = $trainer;
        $this->eventDetails = $eventDetails;
    }

    public function build()
    {
        return $this->subject('Trainer Absent Notification')
            ->view('emails.trainer_absent_notification')
            ->with([
                'trainerName' => $this->trainer->name,
                'eventDetails' => $this->eventDetails,
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Trainer afwezig',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.trainer_absent_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
