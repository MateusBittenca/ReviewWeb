<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrialRequestCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $contactName;
    public $companyName;

    /**
     * Create a new message instance.
     */
    public function __construct(string $contactName, string $companyName)
    {
        $this->contactName = $contactName;
        $this->companyName = $companyName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Your Free Trial Request Has Been Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.trial-request-customer',
            with: [
                'contactName' => $this->contactName,
                'companyName' => $this->companyName,
            ]
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
