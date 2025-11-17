<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NegativeReviewAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $review;

    /**
     * Create a new message instance.
     */
    public function __construct(Company $company, Review $review)
    {
        $this->company = $company;
        $this->review = $review;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 ALERTA: Avaliação Negativa - ' . $this->company->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.negative-review-alert',
            with: [
                'company' => $this->company,
                'review' => $this->review,
                'isPositive' => false
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
