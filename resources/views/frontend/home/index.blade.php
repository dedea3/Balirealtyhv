@extends('frontend.layout.app')

@section('title', 'Luxury Villa Rentals in Bali')
@section('meta_description', 'Discover exclusive luxury villas in Bali\'s most prestigious locations. Premium accommodations with world-class service.')

@section('content')
<!-- Hero Section -->
<section class="relative h-screen min-h-[600px] flex items-center justify-center overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=1920&q=80" 
             alt="Luxury Villa Bali" 
             class="w-full h-full object-cover"
             loading="eager">
        <div class="absolute inset-0 bg-black/40"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 text-center text-white px-4 max-w-5xl mx-auto">
        <p class="text-sm md:text-base uppercase tracking-widest mb-4 reveal">Experience Bali's Finest</p>
        <h1 class="font-serif text-4xl md:text-6xl lg:text-7xl font-semibold mb-6 leading-tight reveal">
            Luxury Villas in Paradise
        </h1>
        <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto reveal">
            Discover exclusive accommodations in Bali's most prestigious locations
        </p>
        
        <!-- Search Bar -->
        <div class="bg-white p-4 rounded-none shadow-2xl max-w-4xl mx-auto reveal">
            <form action="{{ route('areas.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-left text-xs text-gray-500 mb-1">Destination</label>
                    <select name="area" class="w-full border border-gray-200 px-4 py-2 text-gray-800 focus:outline-none focus:border-old-money-charcoal">
                        <option value="">All Areas</option>
                        @foreach(\App\Models\Area::where('is_active', true)->get() as $area)
                            <option value="{{ $area->slug }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-40">
                    <label class="block text-left text-xs text-gray-500 mb-1">Bedrooms</label>
                    <select name="bedrooms" class="w-full border border-gray-200 px-4 py-2 text-gray-800 focus:outline-none focus:border-old-money-charcoal">
                        <option value="">Any</option>
                        <option value="1">1+ Bedroom</option>
                        <option value="2">2+ Bedrooms</option>
                        <option value="3">3+ Bedrooms</option>
                        <option value="4">4+ Bedrooms</option>
                        <option value="5">5+ Bedrooms</option>
                    </select>
                </div>
                <div class="w-full md:w-40">
                    <label class="block text-left text-xs text-gray-500 mb-1">Check-in</label>
                    <input type="date" name="check_in" class="w-full border border-gray-200 px-4 py-2 text-gray-800 focus:outline-none focus:border-old-money-charcoal">
                </div>
                <button type="submit" class="bg-old-money-charcoal text-white px-8 py-4 hover:bg-old-money-black transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
        <i class="fas fa-chevron-down text-white text-2xl"></i>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-old-money-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="reveal">
                <p class="font-serif text-4xl font-semibold text-old-money-charcoal">{{ $totalVillas }}+</p>
                <p class="text-gray-600 mt-2">Luxury Villas</p>
            </div>
            <div class="reveal">
                <p class="font-serif text-4xl font-semibold text-old-money-charcoal">{{ $totalAreas }}</p>
                <p class="text-gray-600 mt-2">Prime Locations</p>
            </div>
            <div class="reveal">
                <p class="font-serif text-4xl font-semibold text-old-money-charcoal">24/7</p>
                <p class="text-gray-600 mt-2">Concierge Service</p>
            </div>
            <div class="reveal">
                <p class="font-serif text-4xl font-semibold text-old-money-charcoal">4.9/5</p>
                <p class="text-gray-600 mt-2">Guest Rating</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Villas -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <p class="text-sm uppercase tracking-widest text-gray-500 mb-2">Our Portfolio</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-old-money-charcoal">Featured Villas</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredVillas as $villa)
                <div class="group reveal">
                    <a href="{{ route('villas.show', $villa->slug) }}" class="block">
                        <!-- Image -->
                        <div class="relative overflow-hidden aspect-[4/3] mb-4">
                            @if(true /* Image fallback enabled */)
                                <img src="{{ $villa->cover_image_url }}" 
                                     alt="{{ $villa->name }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy">
                            @else
                                <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&q=80" 
                                     alt="{{ $villa->name }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy">
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm px-3 py-1 text-xs font-medium uppercase tracking-wider">
                                    {{ $villa->area?->name ?? 'Bali' }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Info -->
                        <h3 class="font-serif text-xl font-semibold text-old-money-charcoal mb-2">{{ $villa->name }}</h3>
                        
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span><i class="fas fa-bed mr-1"></i> {{ $villa->bedrooms }} Beds</span>
                            <span><i class="fas fa-bath mr-1"></i> {{ $villa->bathrooms }} Baths</span>
                            <span><i class="fas fa-user mr-1"></i> {{ $villa->max_guests }} Guests</span>
                        </div>
                        
                        @if($villa->rates->first())
                            <p class="mt-3 text-old-money-charcoal">
                                <span class="font-semibold">From ${{ number_format($villa->rates->first()->price_per_night, 0) }}</span>
                                <span class="text-gray-500"> / night</span>
                            </p>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12 reveal">
            <a href="{{ route('areas.index') }}" class="btn-secondary inline-block">
                View All Villas
            </a>
        </div>
    </div>
</section>

<!-- Destinations -->
<section class="py-20 bg-old-money-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <p class="text-sm uppercase tracking-widest text-gray-500 mb-2">Explore Bali</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-old-money-charcoal">Popular Destinations</h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($areas as $area)
                <a href="{{ route('areas.show', $area->slug) }}" 
                   class="group block text-center reveal">
                    <div class="aspect-square bg-gray-200 mb-3 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400&q=80" 
                             alt="{{ $area->name }}" 
                             class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                             loading="lazy">
                    </div>
                    <h3 class="font-medium text-old-money-charcoal group-hover:text-gray-600 transition-colors">
                        {{ $area->name }}
                    </h3>
                    <p class="text-sm text-gray-500">{{ $area->published_villas_count }} villas</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <p class="text-sm uppercase tracking-widest text-gray-500 mb-2">Guest Stories</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-old-money-charcoal">What Our Guests Say</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($testimonials as $testimonial)
                <div class="bg-old-money-cream p-8 reveal">
                    <div class="flex text-yellow-500 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= ($testimonial->rating ?? 5) ? '' : '-o' }}"></i>
                        @endfor
                    </div>
                    <blockquote class="text-gray-700 mb-6 italic">
                        "{{ Str::limit($testimonial->review_text, 150) }}"
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-old-money-beige rounded-full flex items-center justify-center">
                            <span class="font-serif text-lg font-semibold text-old-money-charcoal">
                                {{ substr($testimonial->guest_name, 0, 1) }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-old-money-charcoal">{{ $testimonial->guest_name }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $testimonial->country ?? 'Guest' }}
                                @if($testimonial->villa)
                                    <span class="mx-2">•</span>
                                    <span>{{ $testimonial->villa->name }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-old-money-charcoal text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal">
        <h2 class="font-serif text-3xl md:text-4xl font-semibold mb-6">
            Find Your Perfect Bali Retreat
        </h2>
        <p class="text-gray-300 mb-8 text-lg">
            Let our concierge team help you discover the ideal villa for your stay
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('areas.index') }}" class="bg-white text-old-money-charcoal px-8 py-4 hover:bg-gray-100 transition-colors">
                Browse Villas
            </a>
            <a href="{{ route('contact') }}" class="border border-white text-white px-8 py-4 hover:bg-white hover:text-old-money-charcoal transition-colors">
                Contact Us
            </a>
        </div>
    </div>
</section>
@endsection
