@extends('frontend.layout.app')

@section('title', 'About Us - Bali Realty Holidays')

@section('content')
<!-- Page Header -->
<section class="pt-32 pb-16 bg-old-money-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center reveal">
            <h1 class="font-serif text-4xl md:text-5xl font-semibold text-old-money-charcoal mb-4">
                About Bali Realty Holidays
            </h1>
            <p class="text-gray-600 max-w-3xl mx-auto">
                Curating exceptional villa experiences in Bali since 2010
            </p>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="reveal">
                <img src="https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=800&q=80" 
                     alt="Luxury Villa Bali" 
                     class="w-full h-[400px] object-cover">
            </div>
            <div class="reveal">
                <h2 class="font-serif text-3xl font-semibold text-old-money-charcoal mb-6">
                    Our Story
                </h2>
                <div class="prose prose-lg text-gray-700">
                    <p class="mb-4">
                        Bali Realty Holidays was founded with a simple vision: to offer discerning travelers access to Bali's most exceptional luxury villas, paired with service that exceeds expectations.
                    </p>
                    <p class="mb-4">
                        We believe in understated elegance – the kind of luxury that doesn't need to shout. Our portfolio features properties that embody the essence of Balinese hospitality: serene, sophisticated, and deeply personal.
                    </p>
                    <p>
                        Every villa in our collection has been personally inspected by our team. We select properties that meet our exacting standards for design, comfort, and location – ensuring your stay is nothing short of extraordinary.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-16 bg-old-money-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <h2 class="font-serif text-3xl font-semibold text-old-money-charcoal mb-4">
                Our Values
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 reveal">
                <div class="w-16 h-16 bg-old-money-cream flex items-center justify-center mb-6">
                    <i class="fas fa-gem text-2xl text-old-money-charcoal"></i>
                </div>
                <h3 class="font-serif text-xl font-semibold mb-4">Quality Over Quantity</h3>
                <p class="text-gray-600">
                    We carefully curate our portfolio, selecting only properties that meet our exacting standards for design, comfort, and location.
                </p>
            </div>
            
            <div class="bg-white p-8 reveal">
                <div class="w-16 h-16 bg-old-money-cream flex items-center justify-center mb-6">
                    <i class="fas fa-heart text-2xl text-old-money-charcoal"></i>
                </div>
                <h3 class="font-serif text-xl font-semibold mb-4">Personal Service</h3>
                <p class="text-gray-600">
                    Our concierge team provides personalized attention, ensuring every detail of your stay is perfectly arranged.
                </p>
            </div>
            
            <div class="bg-white p-8 reveal">
                <div class="w-16 h-16 bg-old-money-cream flex items-center justify-center mb-6">
                    <i class="fas fa-handshake text-2xl text-old-money-charcoal"></i>
                </div>
                <h3 class="font-serif text-xl font-semibold mb-4">Trust & Transparency</h3>
                <p class="text-gray-600">
                    We believe in honest communication and transparent pricing, with no hidden fees or surprises.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="reveal">
                <p class="font-serif text-4xl font-semibold text-old-money-charcoal">70+</p>
                <p class="text-gray-600 mt-2">Luxury Villas</p>
            </div>
            <div class="reveal">
                <p class="font-serif text-4xl font-semibold text-old-money-charcoal">8</p>
                <p class="text-gray-600 mt-2">Prime Locations</p>
            </div>
            <div class="reveal">
                <p class="font-serif text-4xl font-semibold text-old-money-charcoal">15+</p>
                <p class="text-gray-600 mt-2">Years Experience</p>
            </div>
            <div class="reveal">
                <p class="font-serif text-4xl font-semibold text-old-money-charcoal">4.9/5</p>
                <p class="text-gray-600 mt-2">Guest Rating</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 bg-old-money-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <h2 class="font-serif text-3xl font-semibold text-old-money-charcoal mb-4">
                Why Choose Us
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex items-start space-x-4 reveal">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800 mb-2">Handpicked Properties</h3>
                    <p class="text-gray-600">Every villa is personally inspected and verified by our team</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-4 reveal">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800 mb-2">Best Price Guarantee</h3>
                    <p class="text-gray-600">We match any legitimate lower price you find online</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-4 reveal">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800 mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Our team is available around the clock during your stay</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-4 reveal">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800 mb-2">Local Expertise</h3>
                    <p class="text-gray-600">Deep knowledge of Bali's best locations and experiences</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-old-money-charcoal text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal">
        <h2 class="font-serif text-3xl font-semibold mb-6">
            Ready to Experience Bali?
        </h2>
        <p class="text-gray-300 mb-8 text-lg">
            Let our concierge team help you find the perfect villa for your stay
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('areas.index') }}" class="bg-white text-old-money-charcoal px-8 py-4 hover:bg-gray-100 transition-colors">
                Browse Our Villas
            </a>
            <a href="{{ route('contact') }}" class="border border-white text-white px-8 py-4 hover:bg-white hover:text-old-money-charcoal transition-colors">
                Contact Us
            </a>
        </div>
    </div>
</section>
@endsection
