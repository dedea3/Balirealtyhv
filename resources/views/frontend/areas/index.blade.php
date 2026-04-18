@extends('frontend.layout.app')

@section('title', 'Luxury Villas in Bali - All Destinations')

@section('content')
<!-- Page Header -->
<section class="pt-32 pb-16 bg-old-money-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center reveal">
            <h1 class="font-serif text-4xl md:text-5xl font-semibold text-old-money-charcoal mb-4">
                Our Villas in Bali
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Discover our curated collection of luxury villas across Bali's most prestigious locations
            </p>
        </div>
    </div>
</section>

<!-- Filter & Results -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-64 flex-shrink-0">
                <form action="{{ route('areas.index') }}" method="GET" class="sticky top-24 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Destination</label>
                        <select name="area" class="input-field text-sm" onchange="this.form.submit()">
                            <option value="">All Areas</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->slug }}" {{ request('area') == $area->slug ? 'selected' : '' }}>
                                    {{ $area->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                        <select name="bedrooms" class="input-field text-sm" onchange="this.form.submit()">
                            <option value="">Any</option>
                            <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+ Bedroom</option>
                            <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+ Bedrooms</option>
                            <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+ Bedrooms</option>
                            <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+ Bedrooms</option>
                            <option value="5" {{ request('bedrooms') == '5' ? 'selected' : '' }}>5+ Bedrooms</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select name="sort" class="input-field text-sm" onchange="this.form.submit()">
                            <option value="featured" {{ request('sort') === 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="bedrooms" {{ request('sort') === 'bedrooms' ? 'selected' : '' }}>Most Bedrooms</option>
                        </select>
                    </div>
                    
                    @if(request()->anyFilled(['area', 'bedrooms', 'sort']))
                        <a href="{{ route('areas.index') }}" class="block text-center text-sm text-gray-500 hover:text-gray-700 underline">
                            Clear Filters
                        </a>
                    @endif
                </form>
            </div>
            
            <!-- Villa Grid -->
            <div class="flex-1">
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-gray-600">
                        <span class="font-semibold">{{ $villas->total() }}</span> villas found
                    </p>
                </div>
                
                @if($villas->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($villas as $villa)
                            <div class="group reveal">
                                <a href="{{ route('villas.show', $villa->slug) }}" class="block">
                                    <!-- Image -->
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
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-white/90 backdrop-blur-sm px-3 py-1 text-xs font-medium uppercase tracking-wider">
                                                {{ $villa->area?->name ?? 'Bali' }}
                                            </span>
                                        </div>
                                        @if($villa->is_featured)
                                            <div class="absolute top-4 right-4">
                                                <span class="bg-old-money-charcoal text-white px-2 py-1 text-xs">
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Info -->
                                    <h3 class="font-serif text-xl font-semibold text-old-money-charcoal mb-2">{{ $villa->name }}</h3>

                                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-3">
                                        <span><i class="fas fa-bed mr-1"></i> {{ $villa->bedroom_range }}</span>
                                        <span><i class="fas fa-bath mr-1"></i> {{ $villa->bathrooms }}</span>
                                        <span><i class="fas fa-user mr-1"></i> {{ $villa->max_guests }}</span>
                                    </div>

                                    @php
                                        $startingPrice = $villa->starting_price ?? $villa->rates->first()?->price_per_night;
                                    @endphp
                                    @if($startingPrice)
                                        <p class="text-old-money-charcoal">
                                            <span class="font-semibold">From ${{ number_format($startingPrice, 0) }}</span>
                                            <span class="text-gray-500"> / night</span>
                                        </p>
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $villas->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <i class="fas fa-home text-6xl text-gray-300 mb-4"></i>
                        <h3 class="font-serif text-xl font-semibold text-gray-700 mb-2">No Villas Found</h3>
                        <p class="text-gray-500 mb-6">Try adjusting your filters to see more results</p>
                        <a href="{{ route('areas.index') }}" class="btn-primary inline-block">
                            Clear All Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
