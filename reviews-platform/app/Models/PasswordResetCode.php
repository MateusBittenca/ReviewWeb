<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'code',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    /**
     * Verificar se o código é válido
     */
    public function isValid()
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    /**
     * Marcar código como usado
     */
    public function markAsUsed()
    {
        $this->update(['used' => true]);
    }

    /**
     * Limpar códigos expirados
     */
    public static function cleanExpired()
    {
        static::where('expires_at', '<', now())->delete();
    }
}
