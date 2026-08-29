<?php

namespace App\Mail;

use App\Models\appointments;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public appointments $appointment;
    public string $recipientType; // 'patient' or 'admin'

    /**
     * Create a new message instance.
     */
    public function __construct(appointments $appointment, string $recipientType = 'patient')
    {
        $this->appointment = $appointment;
        $this->recipientType = $recipientType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $ref = 'APT-' . str_pad($this->appointment->id, 6, '0', STR_PAD_LEFT);
        $subject = $this->recipientType === 'admin'
            ? "🔔 New Appointment Booking Receipt [{$ref}]"
            : "✅ Your MediLink Appointment Confirmation & Receipt [{$ref}]";

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-receipt',
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
