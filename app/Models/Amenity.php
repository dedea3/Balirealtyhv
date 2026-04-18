<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'amenity_category_id',
        'name',
        'slug',
        'description',
        'icon_class',
        'icon_svg',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($amenity) {
            if (empty($amenity->slug)) {
                $amenity->slug = Str::slug($amenity->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AmenityCategory::class, 'amenity_category_id');
    }

    public function villas(): BelongsToMany
    {
        return $this->belongsToMany(Villa::class, 'villa_amenity')
            ->withTimestamps();
    }
}
