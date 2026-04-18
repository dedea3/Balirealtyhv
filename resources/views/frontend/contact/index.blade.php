@extends('frontend.layout.app')

@section('title', 'Contact Us - Bali Realty Holidays')

@section('content')
<!-- Page Header -->
<section class="pt-32 pb-16 bg-old-money-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center reveal">
            <h1 class="font-serif text-4xl md:text-5xl font-semibold text-old-money-charcoal mb-4">
                Contact Us
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Get in touch with our concierge team. We're here to help you plan your perfect Bali stay.
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="font-serif text-2xl font-semibold mb-6">Send Us a Message</h2>
                
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="name" required value="{{ old('name') }}" class="input-field">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email" required value="{{ old('email') }}" class="input-field">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="input-field">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                        <input type="text" name="subject" required value="{{ old('subject') }}" class="input-field">
                        @error('subject')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                        <textarea name="message" required rows="6" class="input-field">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-primary w-full">
                        <i class="fas fa-paper-plane mr-2"></i> Send Message
                    </button>
                </form>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h2 class="font-serif text-2xl font-semibold mb-6">Get in Touch</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-old-money-cream flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-old-money-charcoal text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800 mb-1">Email Us</h3>
                            <p class="text-gray-600">info@balirealtyhv.com</p>
                            <p class="text-sm text-gray-500 mt-1">We respond within 24 hours</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-old-money-cream flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-old-money-charcoal text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800 mb-1">Call Us</h3>
                            <p class="text-gray-600">+62 361 123 4567</p>
                            <p class="text-sm text-gray-500 mt-1">Mon-Sat, 9am-6pm WITA</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-old-money-cream flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-old-money-charcoal text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800 mb-1">Visit Us</h3>
                            <p class="text-gray-600">Bali, Indonesia</p>
                            <p class="text-sm text-gray-500 mt-1">By appointment only</p>
                        </div>
                    </div>
                </div>
                
                <!-- Office Hours -->
                <div class="mt-8 p-6 bg-old-money-cream">
                    <h3 class="font-medium text-gray-800 mb-4">Concierge Hours</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Monday - Friday</span>
                            <span class="text-gray-800">9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Saturday</span>
                            <span class="text-gray-800">9:00 AM - 4:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sunday</span>
                            <span class="text-gray-800">Closed</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">
                        <i class="fas fa-info-circle mr-1"></i>
                        24/7 support available for confirmed guests
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Placeholder -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="aspect-video bg-gray-200 rounded flex items-center justify-center">
            <div class="text-center text-gray-500">
                <i class="fas fa-map-marked-alt text-5xl mb-4"></i>
                <p>Map view coming soon</p>
            </div>
        </div>
    </div>
</section>
@endsection
