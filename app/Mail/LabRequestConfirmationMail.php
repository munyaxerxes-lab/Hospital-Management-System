<?php

namespace App\Mail;

use App\Models\LabRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LabRequestConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public LabRequest $labRequest;
    public string $recipientType; // 'patient' or 'admin'

    /**
     * Create a new message instance.
     */
    public function __construct(LabRequest $labRequest, string $recipientType = 'patient')
    {
        $this->labRequest    = $labRequest;
        $this->recipientType = $recipientType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $ref = $this->labRequest->request_number;
        $subject = $this->recipientType === 'admin'
            ? "🔬 New Lab Request Submitted [{$ref}]"
            : "✅ Your MediLink Lab Request Confirmation [{$ref}]";

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
            view: 'emails.lab-request-confirmation',
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
