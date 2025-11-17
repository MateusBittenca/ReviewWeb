<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'token',
        'url',
        'views_count',
        'reviews_count',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'views_count' => 'integer',
        'reviews_count' => 'integer'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
