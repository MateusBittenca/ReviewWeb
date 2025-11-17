<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'company_id',
        'review_page_id',
        'rating',
        'whatsapp',
        'comment',
        'feedback',
        'is_positive',
        'redirected_to_google',
        'notified_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_positive' => 'boolean',
        'redirected_to_google' => 'boolean',
        'notified_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function reviewPage(): BelongsTo
    {
        return $this->belongsTo(ReviewPage::class);
    }

    public function markAsNotified(): void
    {
        $this->update(['notified_at' => now()]);
    }

    public function scopePositive($query)
    {
        return $query->where('is_positive', true);
    }

    public function scopeNegative($query)
    {
        return $query->where('is_positive', false);
    }

    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getFormattedWhatsappAttribute(): string
    {
        return preg_replace('/[^0-9]/', '', $this->whatsapp);
    }

    public function getRatingStarsAttribute(): string
    {
        return str_repeat('⭐', $this->rating);
    }
}





