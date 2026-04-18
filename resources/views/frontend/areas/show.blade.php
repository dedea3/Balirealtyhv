@extends('frontend.layout.app')

@section('title', $area->name . ' - Luxury Villas')

@section('content')
<!-- Page Header -->
<section class="pt-32 pb-16 bg-old-money-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center reveal">
            <p class="text-sm uppercase tracking-widest text-gray-500 mb-2">{{ $area->name }}</p>
            <h1 class="font-serif text-4xl md:text-5xl font-semibold text-old-money-charcoal mb-4">
                Villas in {{ $area->name }}
            </h1>
            @if($area->description)
                <p class="text-gray-600 max-w-3xl mx-auto">
                    {{ $area->description }}
                </p>
            @endif
        </div>
    </div>
</section>

<!-- Villa Grid -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-gray-600 mb-8">
            <span class="font-semibold">{{ $villas->total() }}</span> villas in {{ $area->name }}
        </p>
        
        @if($villas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($villas as $villa)
                    <div class="group reveal">
                        <a href="{{ route('villas.show', $villa->slug) }}" class="block">
                            <div class="relative overflow-hidden aspect-[4/3] mb-4">
                                @if(true /* Image fallback enabled */)
                                    <img src="{{ $villa->cover_image_url }}" 
                                         alt="{{ $villa->name }}" 
                                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&q=80" 
                                         alt="{{ $villa->name }}" 
                                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                                @endif
                            </div>
                            
                            <h3 class="font-serif text-xl font-semibold text-old-money-charcoal mb-2">{{ $villa->name }}</h3>
                            
                            <div class="flex items-center space-x-4 text-sm text-gray-500 mb-3">
                                <span><i class="fas fa-bed mr-1"></i> {{ $villa->bedrooms }}</span>
                                <span><i class="fas fa-bath mr-1"></i> {{ $villa->bathrooms }}</span>
                                <span><i class="fas fa-user mr-1"></i> {{ $villa->max_guests }}</span>
                            </div>
                            
                            @if($villa->rates->first())
                                <p class="text-old-money-charcoal">
                                    <span class="font-semibold">From ${{ number_format($villa->rates->first()->price_per_night, 0) }}</span>
                                    <span class="text-gray-500"> / night</span>
                                </p>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-12">
                {{ $villas->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <i class="fas fa-home text-6xl text-gray-300 mb-4"></i>
                <h3 class="font-serif text-xl font-semibold text-gray-700 mb-2">No Villas Available</h3>
                <p class="text-gray-500">Check back soon for new properties in {{ $area->name }}</p>
            </div>
        @endif
    </div>
</section>
@endsection
