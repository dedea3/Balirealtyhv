<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillaRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'villa_id',
        'season_id',
        'price_per_night',
        'currency',
        'minimum_nights',
        'is_active',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function villa(): BelongsTo
    {
        return $this->belongsTo(Villa::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price_per_night, 2);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByVilla($query, $villaId)
    {
        return $query->where('villa_id', $villaId);
    }
}
