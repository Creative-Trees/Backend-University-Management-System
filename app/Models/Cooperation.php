<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Cooperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'url',
        'partner_name',
        'cooperation_type',
        'status',
        'start_date',
        'end_date',
        'description',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('cooperation_type', $type);
    }

    public function scopeExpiring($query, $days = 30)
    {
        return $query->where('end_date', '<=', now()->addDays($days))
                    ->where('end_date', '>=', now());
    }

    protected function isExpiringSoon(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->end_date && now()->diffInDays($this->end_date) <= 30
        );
    }

    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === 'active'
        );
    }
}
