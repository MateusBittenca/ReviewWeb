<?php

namespace App\Services;

use App\Models\Review;
use App\Mail\NewReviewNotification;
use App\Mail\NegativeReviewAlert;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function notifyNewReview(Review $review): void
    {
        $company = $review->company;

        Mail::to($company->email)->send(
            new NewReviewNotification($review)
        );

        $review->markAsNotified();
    }

    public function notifyNegativeFeedback(Review $review): void
    {
        $company = $review->company;

        Mail::to($company->email)->send(
            new NegativeReviewAlert($review)
        );
    }
}





