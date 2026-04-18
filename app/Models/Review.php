<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'villa_id',
        'guest_name',
        'country',
        'guest_type',
        'stay_date',
        'review_text',
        'rating',
        'is_published',
        'is_featured',
        'response_text',
        'response_at',
        'sort_order',
    ];

    protected $casts = [
        'stay_date' => 'date',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'response_at' => 'datetime',
    ];

    public function villa(): BelongsTo
    {
        return $this->belongsTo(Villa::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeForVilla($query, $villaId)
    {
        return $query->where('villa_id', $villaId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function respond(string $responseText): void
    {
        $this->update([
            'response_text' => $responseText,
            'response_at' => now(),
        ]);
    }
}
