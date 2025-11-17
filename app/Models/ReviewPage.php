<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ReviewPage extends Model
{
    protected $fillable = [
        'company_id',
        'public_token',
        'page_url',
        'views_count',
    ];

    protected $casts = [
        'views_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reviewPage) {
            if (empty($reviewPage->public_token)) {
                $reviewPage->public_token = (string) Str::uuid();
            }
            
            if (empty($reviewPage->page_url)) {
                $reviewPage->page_url = route('review.page', $reviewPage->public_token);
            }
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function getPublicUrlAttribute(): string
    {
        return route('review.page', $this->public_token);
    }
}





