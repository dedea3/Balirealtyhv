<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Villa extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'name',
        'slug',
        'overview',
        'short_description',
        'bedrooms',
        'has_flexible_config',
        'bathrooms',
        'max_guests',
        'property_size_sqm',
        'property_size_unit',
        'ical_url',
        'status',
        'is_featured',
        'sort_order',
        'location',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'has_flexible_config' => 'boolean',
        'location' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($villa) {
            if (empty($villa->slug)) {
                $villa->slug = Str::slug($villa->name);
            }
        });
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'villa_amenity')
            ->withTimestamps();
    }

    public function facilities(): BelongsToMany
    {
        return $this->amenities()->whereHas('category', function ($query) {
            $query->where('slug', 'facilities');
        });
    }

    public function services(): BelongsToMany
    {
        return $this->amenities()->whereHas('category', function ($query) {
            $query->where('slug', 'services');
        });
    }

    public function inclusions(): BelongsToMany
    {
        return $this->amenities()->whereHas('category', function ($query) {
            $query->where('slug', 'inclusions');
        });
    }

    public function rates(): HasMany
    {
        return $this->hasMany(VillaRate::class);
    }

    public function bedroomConfigs(): HasMany
    {
        return $this->hasMany(VillaBedroomConfig::class)->ordered();
    }

    public function activeBedroomConfigs(): HasMany
    {
        return $this->bedroomConfigs()->active();
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)->orderBy('sort_order');
    }

    public function heroImage(): HasOne
    {
        return $this->hasOne(Photo::class)->where('category', 'hero')->where('is_primary', true);
    }

    public function galleryImages(): HasMany
    {
        return $this->hasMany(Photo::class)->where('category', 'gallery')->orderBy('sort_order');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function publishedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_published', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByArea($query, $areaSlug)
    {
        return $query->whereHas('area', function ($q) use ($areaSlug) {
            $q->where('slug', $areaSlug);
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('overview', 'like', "%{$search}%");
        });
    }

    public function scopeWithBedroomCount($query, $bedroomCount)
    {
        return $query->where(function ($q) use ($bedroomCount) {
            // Match villas with exact bedroom count OR
            // villas with flexible configs that include this bedroom count
            $q->where('bedrooms', '>=', $bedroomCount)
              ->orWhereHas('bedroomConfigs', function ($q2) use ($bedroomCount) {
                  $q2->where('bedroom_count', $bedroomCount)
                     ->where('is_active', true);
              });
        });
    }

    public function getBedroomRangeAttribute(): string
    {
        if (!$this->has_flexible_config || !$this->bedroomConfigs->count()) {
            return $this->bedrooms . ' Bedroom' . ($this->bedrooms > 1 ? 's' : '');
        }

        $min = $this->bedroomConfigs->min('bedroom_count');
        $max = $this->bedroomConfigs->max('bedroom_count');

        if ($min === $max) {
            return $min . ' Bedroom' . ($min > 1 ? 's' : '');
        }

        return $min . '-' . $max . ' Bedrooms';
    }

    public function getStartingPriceAttribute()
    {
        if ($this->bedroomConfigs->count() > 0) {
            return $this->bedroomConfigs->min('price_per_night');
        }
        return $this->rates->first()?->price_per_night ?? null;
    }
    
    public function getCoverImageUrlAttribute()
    {
        // 1. Try to get photo marked as Hero AND Primary
        if ($this->heroImage) {
            return $this->heroImage->url;
        }
        
        // 2. Fallback to any photo categorized as 'hero' (take the latest one)
        $anyHero = $this->photos()->where('category', 'hero')->latest()->first();
        if ($anyHero) {
            return $anyHero->url;
        }
        
        // 3. Fallback to the first photo in general
        $firstPhoto = $this->photos()->first();
        if ($firstPhoto) {
            return $firstPhoto->url;
        }

        // 4. Final Fallback: High-resolution Unsplash placeholder
        return 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=2560&q=90';
    }
}
