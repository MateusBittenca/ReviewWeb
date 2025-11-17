<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewReviewNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Review $review
    ) {}

    public function envelope(): Envelope
    {
        $emoji = $this->review->is_positive ? '⭐' : '⚠️';
        $type = $this->review->is_positive ? 'Positiva' : 'Negativa';
        
        return new Envelope(
            subject: "{$emoji} Nova Avaliação {$type} - {$this->review->company->name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.new-review',
            with: [
                'review' => $this->review,
                'company' => $this->review->company,
            ],
        );
    }
}





