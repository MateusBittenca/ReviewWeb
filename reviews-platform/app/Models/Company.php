<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'url',
        'slug',
        'token',
        'logo',
        'background_image',
        'negative_email',
        'contact_number',
        'business_website',
        'business_address',
        'google_business_url',
        'positive_score',
        'is_active',
        'status'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'positive_score' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($company) {
            if (empty($company->slug)) {
                $company->slug = Str::slug($company->name);
            }
            if (empty($company->token)) {
                $company->token = 'review_' . Str::random(20);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reviewPages()
    {
        return $this->hasMany(ReviewPage::class);
    }

    public function getPublicUrlAttribute()
    {
        return url('/r/' . $this->token);
    }

    public function getPositiveReviewsCountAttribute()
    {
        return $this->reviews()->where('is_positive', true)->count();
    }

    public function getNegativeReviewsCountAttribute()
    {
        return $this->reviews()->where('is_positive', false)->count();
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }
        
        // Retorna URL absoluta completa para funcionar em emails
        $url = url('storage/' . $this->logo);
        
        // Se não começar com http, garantir que seja absoluta
        if (!str_starts_with($url, 'http')) {
            $url = config('app.url') . '/storage/' . $this->logo;
        }
        
        return $url;
    }
    
    /**
     * Retorna URL completa da logo incluindo APP_URL
     */
    public function getFullLogoUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }
        
        $appUrl = rtrim(config('app.url'), '/');
        return $appUrl . '/storage/' . $this->logo;
    }

    public function getBackgroundImageUrlAttribute()
    {
        if (!$this->background_image) {
            return null;
        }
        
        // Retorna URL absoluta completa
        return url('storage/' . $this->background_image);
    }

    public function getGoogleMapsUrlAttribute()
    {
        if (!$this->business_address) {
            return null;
        }
        
        $address = urlencode($this->business_address);
        return "https://www.google.com/maps/search/?api=1&query={$address}";
    }
}
