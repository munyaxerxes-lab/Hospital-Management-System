<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $recipientType; // 'patient' or 'admin'

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, string $recipientType = 'patient')
    {
        $this->order = $order;
        $this->recipientType = $recipientType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $ref = $this->order->order_number;
        $subject = $this->recipientType === 'admin'
            ? "🛒 New Medicine Order Placed [{$ref}]"
            : "✅ Your MediLink Order Confirmation & Receipt [{$ref}]";

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
            view: 'emails.order-receipt',
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
