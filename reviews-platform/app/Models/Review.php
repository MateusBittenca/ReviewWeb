<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'rating',
        'whatsapp',
        'comment',
        'private_feedback',
        'contact_preference',
        'contact_detail',
        'has_private_feedback',
        'is_positive',
        'is_processed',
        'processed_at'
    ];

    protected $casts = [
        'is_positive' => 'boolean',
        'is_processed' => 'boolean',
        'processed_at' => 'datetime',
        'rating' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($review) {
            $review->is_positive = $review->rating >= 4;
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopePositive($query)
    {
        return $query->where('is_positive', true);
    }

    public function scopeNegative($query)
    {
        return $query->where('is_positive', false);
    }

    public function scopeProcessed($query)
    {
        return $query->where('is_processed', true);
    }

    public function scopeUnprocessed($query)
    {
        return $query->where('is_processed', false);
    }

    public function getRatingTextAttribute()
    {
        $ratings = [
            1 => 'Péssimo',
            2 => 'Ruim', 
            3 => 'Regular',
            4 => 'Bom',
            5 => 'Excelente'
        ];
        
        return $ratings[$this->rating] ?? 'N/A';
    }
}
