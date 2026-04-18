@extends('admin.layout.app')

@section('page-title', $villa->name)

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.villas.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div>
                <h2 class="text-2xl font-serif font-semibold text-old-money-charcoal">{{ $villa->name }}</h2>
                <p class="text-sm text-gray-500">{{ $villa->area?->name ?? 'No area assigned' }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.villas.edit', $villa) }}" class="btn-primary">
                <i class="fas fa-edit mr-2"></i> Edit Villa
            </a>
        </div>
    </div>

    <!-- Status Badges -->
    <div class="flex items-center space-x-3">
        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full
            @if($villa->status === 'published') bg-green-100 text-green-800
            @else bg-gray-100 text-gray-800
            @endif">
            {{ ucfirst($villa->status) }}
        </span>
        @if($villa->is_featured)
            <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                <i class="fas fa-star mr-1"></i> Featured
            </span>
        @endif
    </div>

    <!-- Property Overview -->
    <div class="bg-white shadow-sm p-6">
        <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Property Overview</h3>
        
        @if(true /* Image fallback enabled */)
            <img src="{{ $villa->cover_image_url }}" 
                 alt="{{ $villa->name }}" 
                 class="w-full h-64 object-cover mb-6">
        @endif
        
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="text-center p-4 bg-gray-50">
                <i class="fas fa-bed text-2xl text-old-money-charcoal mb-2"></i>
                <p class="text-2xl font-semibold">{{ $villa->bedrooms }}</p>
                <p class="text-sm text-gray-500">Bedrooms</p>
            </div>
            <div class="text-center p-4 bg-gray-50">
                <i class="fas fa-bath text-2xl text-old-money-charcoal mb-2"></i>
                <p class="text-2xl font-semibold">{{ $villa->bathrooms }}</p>
                <p class="text-sm text-gray-500">Bathrooms</p>
            </div>
            <div class="text-center p-4 bg-gray-50">
                <i class="fas fa-user text-2xl text-old-money-charcoal mb-2"></i>
                <p class="text-2xl font-semibold">{{ $villa->max_guests }}</p>
                <p class="text-sm text-gray-500">Guests</p>
            </div>
            @if($villa->property_size_sqm)
                <div class="text-center p-4 bg-gray-50">
                    <i class="fas fa-ruler-combined text-2xl text-old-money-charcoal mb-2"></i>
                    <p class="text-2xl font-semibold">{{ $villa->property_size_sqm }}</p>
                    <p class="text-sm text-gray-500">{{ $villa->property_size_unit ?? 'sqm' }}</p>
                </div>
            @endif
        </div>
        
        @if($villa->short_description)
            <div class="mb-6">
                <h4 class="font-medium text-gray-700 mb-2">Summary</h4>
                <p class="text-gray-600">{{ $villa->short_description }}</p>
            </div>
        @endif
        
        @if($villa->overview)
            <div>
                <h4 class="font-medium text-gray-700 mb-2">Full Description</h4>
                <p class="text-gray-600 whitespace-pre-line">{{ $villa->overview }}</p>
            </div>
        @endif
    </div>

    <!-- Amenities -->
    @if($villa->amenities->count() > 0)
        <div class="bg-white shadow-sm p-6">
            <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Amenities</h3>
            
            @foreach($villa->amenities->groupBy('category.name') as $categoryName => $amenityGroup)
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-3">{{ $categoryName }}</h4>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach($amenityGroup as $amenity)
                            <div class="flex items-center space-x-2 text-gray-600">
                                @if($amenity->icon_class)
                                    <i class="{{ $amenity->icon_class }} w-5"></i>
                                @else
                                    <i class="fas fa-check-circle text-green-500 w-5"></i>
                                @endif
                                <span>{{ $amenity->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Seasonal Rates -->
    @if($villa->rates->count() > 0)
        <div class="bg-white shadow-sm p-6">
            <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Seasonal Rates</h3>
            
            <div class="grid grid-cols-2 gap-4">
                @foreach($villa->rates as $rate)
                    <div class="border border-gray-200 p-4 rounded">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-700">{{ $rate->season->name }}</h4>
                            <span class="text-xs text-gray-500">
                                {{ $rate->season->start_date->format('M d') }} - {{ $rate->season->end_date->format('M d') }}
                            </span>
                        </div>
                        <div class="flex items-baseline space-x-2">
                            <span class="text-2xl font-semibold text-old-money-charcoal">
                                ${{ number_format($rate->price_per_night, 0) }}
                            </span>
                            <span class="text-sm text-gray-500">/ night</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Min stay: {{ $rate->minimum_nights }} nights | {{ $rate->currency }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Photo Gallery -->
    @if($villa->galleryImages->count() > 0)
        <div class="bg-white shadow-sm p-6">
            <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Photo Gallery</h3>
            
            <div class="grid grid-cols-4 gap-4">
                @foreach($villa->galleryImages as $photo)
                    <img src="{{ $photo->url }}" 
                         alt="{{ $photo->alt_text ?? $villa->name }}" 
                         class="w-full h-40 object-cover rounded hover:opacity-75 transition-opacity cursor-pointer">
                @endforeach
            </div>
        </div>
    @endif

    <!-- iCal Information -->
    @if($villa->ical_url)
        <div class="bg-white shadow-sm p-6">
            <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Calendar Sync</h3>
            
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-600 mb-2">
                    <i class="fas fa-link mr-2"></i>
                    <strong>iCal Import URL:</strong>
                </p>
                <code class="block bg-white p-3 rounded text-xs text-gray-700 break-all">
                    {{ $villa->ical_url }}
                </code>
                <p class="text-xs text-gray-500 mt-2">
                    Use this URL to sync with external calendars (Airbnb, Booking.com, etc.)
                </p>
            </div>
        </div>
    @endif

    <!-- Villa Stats -->
    <div class="bg-white shadow-sm p-6">
        <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Villa Statistics</h3>
        
        <div class="grid grid-cols-3 gap-4">
            <div class="text-center p-4">
                <p class="text-3xl font-semibold text-old-money-charcoal">{{ $villa->inquiries->count() }}</p>
                <p class="text-sm text-gray-500">Total Inquiries</p>
            </div>
            <div class="text-center p-4">
                <p class="text-3xl font-semibold text-old-money-charcoal">{{ $villa->reviews->count() }}</p>
                <p class="text-sm text-gray-500">Total Reviews</p>
            </div>
            <div class="text-center p-4">
                <p class="text-3xl font-semibold text-old-money-charcoal">{{ $villa->publishedReviews->count() }}</p>
                <p class="text-sm text-gray-500">Published Reviews</p>
            </div>
        </div>
    </div>
</div>
@endsection
