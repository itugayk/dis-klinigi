<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Appointment $appointment) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Randevu Talebiniz Alındı — '.$this->appointment->appointment_no,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-received',
            with: ['appointment' => $this->appointment->loadMissing(['doctor', 'treatment'])],
        );
    }
}
