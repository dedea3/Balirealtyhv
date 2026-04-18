<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillaBedroomConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'villa_id',
        'bedroom_count',
        'price_per_night',
        'min_nights',
        'currency',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_per_night' => 'decimal:2',
    ];

    public function villa(): BelongsTo
    {
        return $this->belongsTo(Villa::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price_per_night, 0);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByBedroomCount($query, $count)
    {
        return $query->where('bedroom_count', $count);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('bedroom_count');
    }
}
