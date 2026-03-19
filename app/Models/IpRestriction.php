<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IpRestriction extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope for active IPs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if IP is allowed
     */
    public static function isAllowed($ipAddress)
    {
        return self::active()->where('ip_address', $ipAddress)->exists();
    }
}
