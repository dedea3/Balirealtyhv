@extends('frontend.layout.app')

@section('title', $villa->name . ' - ' . ($villa->area?->name ?? 'Bali'))

@section('content')
<!-- Villa Header -->
<section class="relative w-full overflow-hidden">
    <!-- Hero Image Area -->
    <div class="relative w-full h-[55vh] md:h-[80vh] overflow-hidden">
        <img src="{{ $villa->cover_image_url }}"
             alt="{{ $villa->name }}"
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/15"></div>
        
        <!-- Subtle Gradient at bottom for luxury feel -->
        <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/40 to-transparent"></div>
    </div>

    <!-- Villa Info Bar: Floating half-on, half-off the photo -->
    <div class="max-w-6xl mx-auto px-4 relative z-30 -mt-24 md:-mt-32">
        <div class="bg-white shadow-[0_25px_60px_-15px_rgba(0,0,0,0.2)] p-8 md:p-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1">
                    <p class="text-xs md:text-sm font-medium text-gray-400 uppercase tracking-widest mb-2">{{ $villa->area?->name ?? 'Bali' }}</p>
                    <h1 class="font-serif text-3xl md:text-4xl lg:text-5xl font-semibold text-old-money-charcoal mb-4 leading-tight">
                        {{ $villa->name }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-500">
                        <span class="flex items-center"><i class="fas fa-bed mr-2 text-old-money-charcoal/40"></i> {{ $villa->bedroom_range }} Bedrooms</span>
                        <span class="flex items-center"><i class="fas fa-bath mr-2 text-old-money-charcoal/40"></i> {{ $villa->bathrooms }} Bathrooms</span>
                        <span class="flex items-center"><i class="fas fa-user mr-2 text-old-money-charcoal/40"></i> {{ $villa->max_guests }} Guests</span>
                    </div>
                </div>
                
                @php
                    $displayPrice = $villa->starting_price ?? $villa->rates->first()?->price_per_night;
                @endphp
                @if($displayPrice)
                    <div class="mt-4 md:mt-0 md:text-right flex flex-col md:items-end">
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl md:text-4xl font-semibold text-old-money-charcoal">${{ number_format($displayPrice, 0) }}</span>
                            <span class="text-gray-400 text-sm">/ night</span>
                        </div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Starting from</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-8 items-start" x-data="{ 
            activeTab: 'overview',
            lightboxOpen: false,
            galleryImages: [
                @foreach($villa->photos as $photo)
                    { url: '{{ $photo->url }}', alt: '{{ $photo->alt_text ?? $villa->name }}' },
                @endforeach
            ],
            currentIndex: 0,
            
            // Calendar Logic
            bookedDates: @json($bookedDates ?? []),
            currentMonth: new Date().getMonth(),
            currentYear: new Date().getFullYear(),
            selectedCheckIn: '',
            selectedCheckOut: '',
            
            get daysInMonth() {
                return new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
            },
            get startDay() {
                return new Date(this.currentYear, this.currentMonth, 1).getDay();
            },
            get monthName() {
                return new Intl.DateTimeFormat('en-US', { month: 'long' }).format(new Date(this.currentYear, this.currentMonth));
            },
            nextMonth() {
                if (this.currentMonth === 11) {
                    this.currentMonth = 0;
                    this.currentYear++;
                } else {
                    this.currentMonth++;
                }
            },
            prevMonth() {
                if (this.currentMonth === 0) {
                    this.currentMonth = 11;
                    this.currentYear--;
                } else {
                    this.currentMonth--;
                }
            },
            isBooked(day) {
                const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                return this.bookedDates.includes(dateStr);
            },
            isToday(day) {
                const today = new Date();
                return day === today.getDate() && this.currentMonth === today.getMonth() && this.currentYear === today.getFullYear();
            },
            isSelected(day) {
                const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                return dateStr === this.selectedCheckIn || dateStr === this.selectedCheckOut;
            },
            isInRange(day) {
                if (!this.selectedCheckIn || !this.selectedCheckOut) return false;
                const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                return dateStr > this.selectedCheckIn && dateStr < this.selectedCheckOut;
            },
            selectDate(day) {
                const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                
                // Prevent selecting past dates
                const selectedDate = new Date(this.currentYear, this.currentMonth, day);
                const today = new Date();
                today.setHours(0,0,0,0);
                if (selectedDate < today) return;

                if (this.isBooked(day)) return;

                if (!this.selectedCheckIn || (this.selectedCheckIn && this.selectedCheckOut)) {
                    this.selectedCheckIn = dateStr;
                    this.selectedCheckOut = '';
                } else {
                    if (dateStr < this.selectedCheckIn) {
                        this.selectedCheckIn = dateStr;
                    } else if (dateStr === this.selectedCheckIn) {
                        this.selectedCheckIn = '';
                    } else {
                        // Check if any booked dates in between
                        let hasBooking = false;
                        let check = new Date(this.selectedCheckIn);
                        while (check < selectedDate) {
                            const checkStr = check.toISOString().split('T')[0];
                            if (this.bookedDates.includes(checkStr)) {
                                hasBooking = true;
                                break;
                            }
                            check.setDate(check.getDate() + 1);
                        }
                        
                        if (!hasBooking) {
                            this.selectedCheckOut = dateStr;
                        } else {
                            this.selectedCheckIn = dateStr;
                            this.selectedCheckOut = '';
                        }
                    }
                }
            },
            
            openLightbox(index) {
                this.currentIndex = index;
                this.lightboxOpen = true;
                document.body.classList.add('overflow-hidden');
            },
            closeLightbox() {
                this.lightboxOpen = false;
                document.body.classList.remove('overflow-hidden');
            },
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.galleryImages.length;
            },
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.galleryImages.length) % this.galleryImages.length;
            }
        }" @keydown.escape.window="closeLightbox()" @keydown.right.window="next()" @keydown.left.window="prev()">
            <!-- Main Content Area -->
            <div class="flex-1 w-full md:w-0">
                <!-- Tabs Navigation -->
                <div class="bg-white shadow-sm mb-8">
                    <div class="flex border-b flex-wrap">
                        <button @click="activeTab = 'overview'" 
                                :class="activeTab === 'overview' ? 'border-old-money-charcoal text-old-money-charcoal' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="flex-1 px-4 py-4 text-center border-b-2 font-medium transition-colors">
                            <i class="fas fa-info-circle mr-2"></i> Overview
                        </button>
                        <button @click="activeTab = 'gallery'" 
                                :class="activeTab === 'gallery' ? 'border-old-money-charcoal text-old-money-charcoal' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="flex-1 px-4 py-4 text-center border-b-2 font-medium transition-colors">
                            <i class="fas fa-images mr-2"></i> Gallery
                        </button>
                        <button @click="activeTab = 'facilities'" 
                                :class="activeTab === 'facilities' ? 'border-old-money-charcoal text-old-money-charcoal' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="flex-1 px-4 py-4 text-center border-b-2 font-medium transition-colors">
                            <i class="fas fa-building mr-2"></i> Facilities
                        </button>
                        <button @click="activeTab = 'services'" 
                                :class="activeTab === 'services' ? 'border-old-money-charcoal text-old-money-charcoal' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="flex-1 px-4 py-4 text-center border-b-2 font-medium transition-colors">
                            <i class="fas fa-concierge-bell mr-2"></i> Services
                        </button>
                        <button @click="activeTab = 'rates'" 
                                :class="activeTab === 'rates' ? 'border-old-money-charcoal text-old-money-charcoal' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="flex-1 px-4 py-4 text-center border-b-2 font-medium transition-colors">
                            <i class="fas fa-dollar-sign mr-2"></i> Rates
                        </button>
                        <button @click="activeTab = 'location'" 
                                :class="activeTab === 'location' ? 'border-old-money-charcoal text-old-money-charcoal' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="flex-1 px-4 py-4 text-center border-b-2 font-medium transition-colors">
                            <i class="fas fa-map-marker-alt mr-2"></i> Location
                        </button>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- Overview Tab -->
                        <div x-show="activeTab === 'overview'" class="space-y-6">
                            @if($villa->overview)
                                <div class="prose max-w-none">
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $villa->overview }}</p>
                                </div>
                            @endif
                            
                            <!-- Gallery Preview -->
                            @if($villa->galleryImages->count() > 0)
                                <div class="mt-8">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="font-serif text-xl font-semibold">Gallery Preview</h3>
                                        <button @click="activeTab = 'gallery'" class="text-old-money-charcoal text-sm font-medium hover:underline">
                                            View All Photos &rarr;
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($villa->galleryImages->take(9) as $index => $photo)
                                            <div class="relative group aspect-[4/3] rounded overflow-hidden shadow-sm cursor-pointer" @click="openLightbox({{ $index }})">
                                                <img src="{{ $photo->url }}" 
                                                     alt="{{ $photo->alt_text ?? $villa->name }}" 
                                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Gallery Tab (All Images) -->
                        <div x-show="activeTab === 'gallery'" class="space-y-6">
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                @foreach($villa->photos as $index => $photo)
                                    <div class="relative group aspect-square rounded overflow-hidden shadow-sm cursor-pointer" @click="openLightbox({{ $index }})">
                                        <img src="{{ $photo->url }}" 
                                             alt="{{ $photo->alt_text ?? $villa->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
                                        @if($photo->category === 'hero')
                                            <span class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 text-[10px] px-1.5 py-0.5 font-bold rounded shadow-sm uppercase tracking-wider">Cover</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Facilities Tab -->
                        <div x-show="activeTab === 'facilities'" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($villa->amenities->where('category.slug', 'facilities') as $amenity)
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                                    @if($amenity->icon_class)
                                        <i class="{{ $amenity->icon_class }} text-old-money-charcoal"></i>
                                    @else
                                        <i class="fas fa-check-circle text-green-500"></i>
                                    @endif
                                    <span class="text-gray-700">{{ $amenity->name }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Services Tab -->
                        <div x-show="activeTab === 'services'" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($villa->amenities->where('category.slug', 'services') as $amenity)
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                                    @if($amenity->icon_class)
                                        <i class="{{ $amenity->icon_class }} text-old-money-charcoal"></i>
                                    @else
                                        <i class="fas fa-check-circle text-green-500"></i>
                                    @endif
                                    <span class="text-gray-700">{{ $amenity->name }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Rates Tab -->
                        <div x-show="activeTab === 'rates'">
                            @if($villa->has_flexible_config && $villa->bedroomConfigs->count() > 0)
                                <div class="mb-8">
                                    <h4 class="font-serif text-lg font-semibold mb-4">Bedroom Configurations</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($villa->bedroomConfigs as $config)
                                            <div class="border border-green-200 bg-green-50 p-4 rounded">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h5 class="font-medium text-gray-800">
                                                        <i class="fas fa-bed text-green-600 mr-2"></i>
                                                        {{ $config->bedroom_count }} Bedroom{{ $config->bedroom_count > 1 ? 's' : '' }}
                                                    </h5>
                                                    @if($config->is_active)
                                                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Available</span>
                                                    @endif
                                                </div>
                                                <div class="flex items-baseline space-x-2">
                                                    <span class="text-2xl font-semibold text-old-money-charcoal">
                                                        ${{ number_format($config->price_per_night, 0) }}
                                                    </span>
                                                    <span class="text-gray-500">/ night</span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Minimum stay: {{ $config->min_nights }} nights
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-8">
                                <h4 class="font-serif text-lg font-semibold mb-4">Seasonal Rates</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($villa->rates as $rate)
                                        <div class="border border-gray-200 p-4 rounded">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-medium text-gray-800">{{ $rate->season->name }}</h4>
                                                <span class="text-xs text-gray-500">
                                                    {{ $rate->season->start_date->format('M d') }} - {{ $rate->season->end_date->format('M d') }}
                                                </span>
                                            </div>
                                            <div class="flex items-baseline space-x-2">
                                                <span class="text-2xl font-semibold text-old-money-charcoal">
                                                    ${{ number_format($rate->price_per_night, 0) }}
                                                </span>
                                                <span class="text-gray-500">/ night</span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Minimum stay: {{ $rate->minimum_nights }} nights
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Inclusions Section -->
                            @if($villa->amenities->where('category.slug', 'inclusions')->count() > 0)
                                <div class="mt-8 pt-8 border-t border-gray-100">
                                    <h4 class="font-serif text-lg font-semibold mb-4 text-old-money-charcoal">What's Included</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-3 gap-x-6">
                                        @foreach($villa->amenities->where('category.slug', 'inclusions') as $amenity)
                                            <div class="flex items-center space-x-2 text-sm text-gray-700">
                                                <i class="fas fa-check text-green-500 text-[10px]"></i>
                                                <span>{{ $amenity->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Location Tab -->
                        <div x-show="activeTab === 'location'" class="space-y-8">
                             @php $location = json_decode($villa->location, true) ?? []; @endphp
                            
                            @if(!empty($location['map_link']))
                                <div class="aspect-video w-full rounded-lg overflow-hidden shadow-md">
                                    <iframe 
                                        src="{{ $location['map_link'] }}" 
                                        width="100%" 
                                        height="100%" 
                                        style="border:0;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            @elseif(!empty($location['latitude']) && !empty($location['longitude']))
                                <div class="aspect-video w-full rounded-lg overflow-hidden shadow-md bg-gray-100 flex items-center justify-center">
                                    <iframe 
                                        width="100%" 
                                        height="100%" 
                                        frameborder="0" 
                                        scrolling="no" 
                                        marginheight="0" 
                                        marginwidth="0" 
                                        src="https://maps.google.com/maps?q={{ $location['latitude'] }},{{ $location['longitude'] }}&hl=en&z=14&amp;output=embed">
                                    </iframe>
                                </div>
                            @endif

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex-1">
                                    <h4 class="font-serif text-lg font-semibold text-old-money-charcoal mb-2 flex items-center">
                                        <i class="fas fa-map-pin mr-2 text-sm"></i> Villa Address
                                    </h4>
                                    <p class="text-gray-700 leading-relaxed italic">
                                        {{ !empty($location['address']) ? $location['address'] : 'Address details provided upon booking confirmation.' }}
                                    </p>
                                </div>
                                
                                @if(!empty($location['latitude']) && !empty($location['longitude']))
                                    <div class="mt-2 sm:mt-0">
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $location['latitude'] }},{{ $location['longitude'] }}" 
                                           target="_blank" 
                                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class="fab fa-google text-red-500 mr-2"></i>
                                            View on Google Maps
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Lightbox Modal -->
                    <div x-show="lightboxOpen" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 z-[100] bg-black/95 flex flex-col items-center justify-center p-4">
                        
                        <button @click="closeLightbox()" class="absolute top-6 right-6 text-white text-3xl hover:text-gray-300 transition-colors z-[110]">
                            <i class="fas fa-times"></i>
                        </button>

                        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 text-white text-3xl hover:text-gray-300 transition-colors z-[110] p-4">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 text-white text-3xl hover:text-gray-300 transition-colors z-[110] p-4">
                            <i class="fas fa-chevron-right"></i>
                        </button>

                        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/70 text-sm font-medium">
                            <span x-text="currentIndex + 1"></span> / <span x-text="galleryImages.length"></span>
                        </div>

                        <div class="w-full max-w-5xl h-full flex items-center justify-center">
                            <template x-for="(img, index) in galleryImages" :key="index">
                                <div x-show="currentIndex === index" 
                                     x-transition:enter="transition ease-out duration-500"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="max-h-[85vh] flex items-center justify-center">
                                    <img :src="img.url" :alt="img.alt" class="max-w-full max-h-full object-contain shadow-2xl">
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                
                <!-- Reviews Section -->
                @if($villa->publishedReviews->count() > 0)
                    <div class="bg-white shadow-sm p-6 mb-8">
                        <h3 class="font-serif text-xl font-semibold mb-6">Guest Reviews</h3>
                        <div class="space-y-6">
                            @foreach($villa->publishedReviews->take(3) as $review)
                                <div class="border-b border-gray-100 pb-6 last:border-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-old-money-beige rounded-full flex items-center justify-center">
                                                <span class="font-serif font-semibold">{{ substr($review->guest_name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-medium">{{ $review->guest_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $review->country ?? 'Guest' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex text-yellow-500">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= ($review->rating ?? 5) ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mt-3">{{ Str::limit($review->review_text, 200) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Inquiry Sidebar -->
            <div class="md:w-80 lg:w-96 w-full md:sticky md:top-28 self-start z-10">
                <div class="bg-white shadow-2xl p-6 rounded-lg border border-gray-100">
                    <h3 class="font-serif text-xl font-semibold mb-4 text-old-money-charcoal">Enquire Now</h3>
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded text-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('villas.inquire', $villa) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" name="name" required class="input-field border-gray-200 focus:border-old-money-charcoal focus:ring-old-money-charcoal">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" required class="input-field border-gray-200 focus:border-old-money-charcoal focus:ring-old-money-charcoal">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" name="phone" class="input-field border-gray-200 focus:border-old-money-charcoal focus:ring-old-money-charcoal">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                                <input type="text" name="whatsapp" class="input-field border-gray-200 focus:border-old-money-charcoal focus:ring-old-money-charcoal">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 text-xs">Check-in</label>
                                <input type="date" name="check_in" id="check_in_input" x-model="selectedCheckIn" class="input-field border-gray-200 focus:border-old-money-charcoal focus:ring-old-money-charcoal py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 text-xs">Check-out</label>
                                <input type="date" name="check_out" id="check_out_input" x-model="selectedCheckOut" class="input-field border-gray-200 focus:border-old-money-charcoal focus:ring-old-money-charcoal py-2 text-sm">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Guests Count</label>
                            <input type="number" name="number_of_guests" min="1" class="input-field border-gray-200 focus:border-old-money-charcoal focus:ring-old-money-charcoal">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea name="message" rows="3" class="input-field border-gray-200 focus:border-old-money-charcoal focus:ring-old-money-charcoal" placeholder="How can we help you?"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-old-money-charcoal hover:bg-black text-white py-3 px-4 rounded font-medium transition-all shadow-md transform active:scale-95">
                            Send Inquiry
                        </button>
                    </form>
                </div>

                <!-- Availability Calendar in Sidebar -->
                <div class="mt-6 bg-white shadow-2xl p-6 rounded-lg border border-gray-100">
                    <h3 class="font-serif text-lg font-semibold mb-4 text-old-money-charcoal flex items-center">
                        <i class="fas fa-calendar-alt mr-2 text-sm"></i> Availability
                    </h3>
                    
                    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                        <div class="bg-old-money-charcoal p-3 flex items-center justify-between text-white">
                            <button @click.prevent="prevMonth()" class="p-1.5 hover:bg-white/10 rounded-full transition-colors">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </button>
                            <div class="text-center">
                                <span x-text="monthName" class="font-serif text-sm font-medium block leading-none"></span>
                                <span x-text="currentYear" class="text-[10px] opacity-70"></span>
                            </div>
                            <button @click.prevent="nextMonth()" class="p-1.5 hover:bg-white/10 rounded-full transition-colors">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                        <div class="p-2">
                            <div class="grid grid-cols-7 mb-1">
                                <template x-for="day in ['S', 'M', 'T', 'W', 'T', 'F', 'S']">
                                    <div class="text-center text-[9px] font-bold text-gray-400 uppercase py-1" x-text="day"></div>
                                </template>
                            </div>
                            <div class="grid grid-cols-7 gap-1">
                                <template x-for="blank in Array.from({ length: startDay })">
                                    <div class="aspect-square"></div>
                                </template>
                                <template x-for="day in Array.from({ length: daysInMonth }, (_, i) => i + 1)">
                                    <div @click="selectDate(day)" 
                                         class="relative aspect-square flex items-center justify-center text-[11px] rounded-md cursor-pointer transition-all"
                                         :class="{
                                             'bg-red-50 text-red-300 cursor-not-allowed': isBooked(day),
                                             'hover:bg-old-money-beige': !isBooked(day),
                                             'bg-old-money-charcoal text-white shadow-sm z-10': isSelected(day),
                                             'bg-old-money-beige/50 text-old-money-charcoal': isInRange(day),
                                             'font-bold border border-old-money-charcoal': isToday(day) && !isSelected(day)
                                         }">
                                        <span x-text="day"></span>
                                        <template x-if="isBooked(day)">
                                            <div class="absolute inset-0 flex items-center justify-center opacity-10">
                                                <div class="w-full h-[1px] bg-red-400 rotate-45"></div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-2 border-t border-gray-100 flex justify-center space-x-4 text-[9px]">
                            <div class="flex items-center space-x-1">
                                <div class="w-2 h-2 rounded-sm bg-white border border-gray-200"></div>
                                <span class="text-gray-500">Available</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="w-2 h-2 rounded-sm bg-red-50 border border-red-100 relative overflow-hidden">
                                    <div class="absolute inset-0 w-full h-[1px] bg-red-300 rotate-45 top-1/2 -translate-y-1/2"></div>
                                </div>
                                <span class="text-gray-500">Booked</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="w-2 h-2 rounded-sm bg-old-money-charcoal"></div>
                                <span class="text-gray-500">Selected</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Villas -->
@if($relatedVillas->count() > 0)
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-serif text-2xl font-semibold mb-8">Related Villas in {{ $villa->area?->name }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedVillas as $relatedVilla)
                    <div class="group">
                        <a href="{{ route('villas.show', $relatedVilla->slug) }}" class="block">
                            @if(true /* Image fallback enabled */)
                                <img src="{{ $relatedVilla->cover_image_url }}" 
                                     alt="{{ $relatedVilla->name }}" 
                                     class="w-full h-48 object-cover rounded group-hover:opacity-75 transition-opacity">
                            @endif
                            <h3 class="font-medium mt-3">{{ $relatedVilla->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $relatedVilla->bedrooms }} Beds • {{ $relatedVilla->bathrooms }} Baths</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
@endsection
