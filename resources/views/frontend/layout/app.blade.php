<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bali Realty Holidays') - Luxury Villa Rentals in Bali</title>
    <meta name="description" content="@yield('meta_description', 'Discover exclusive luxury villas in Bali. Premium accommodations in Canggu, Seminyak, Uluwatu, and more.')">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="font-sans text-gray-800 bg-old-money-white">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-sm shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="font-serif text-2xl font-semibold text-old-money-charcoal">
                        Bali Realty<span class="text-gray-400"> Holidays</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-old-money-charcoal transition-colors">Home</a>
                    <a href="{{ route('areas.index') }}" class="text-gray-600 hover:text-old-money-charcoal transition-colors">Destinations</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-old-money-charcoal transition-colors">About Us</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-old-money-charcoal transition-colors">Contact</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-old-money-charcoal font-medium hover:text-old-money-black transition-colors text-sm">
                            <i class="fas fa-user-shield mr-1"></i> Admin Panel
                        </a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-btn" class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('home') }}" class="block text-gray-600 hover:text-old-money-charcoal">Home</a>
                <a href="{{ route('areas.index') }}" class="block text-gray-600 hover:text-old-money-charcoal">Destinations</a>
                <a href="{{ route('about') }}" class="block text-gray-600 hover:text-old-money-charcoal">About Us</a>
                <a href="{{ route('contact') }}" class="block text-gray-600 hover:text-old-money-charcoal">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-old-money-charcoal text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <!-- Brand -->
                <div class="col-span-1">
                    <h3 class="font-serif text-xl font-semibold mb-4">Bali Realty Holidays</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Discover exclusive luxury villas in Bali's most prestigious locations. Experience understated elegance and world-class service.
                    </p>
                </div>
                
                <!-- Destinations -->
                <div>
                    <h4 class="font-medium mb-4">Destinations</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        @foreach(\App\Models\Area::where('is_active', true)->take(5)->get() as $area)
                            <li>
                                <a href="{{ route('areas.show', $area->slug) }}" class="hover:text-white transition-colors">
                                    {{ $area->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-medium mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('areas.index') }}" class="hover:text-white transition-colors">All Villas</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-medium mb-4">Contact Us</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-2"></i>
                            <span>info@balirealtyhv.com</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone mt-1 mr-2"></i>
                            <span>+62 361 123 4567</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2"></i>
                            <span>Bali, Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} Bali Realty Holidays. All rights reserved.
                </p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-500 hover:text-white transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-white transition-colors">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-white transition-colors">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Scroll reveal animation
        function reveal() {
            var reveals = document.querySelectorAll('.reveal');
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 150;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add('active');
                }
            }
        }
        window.addEventListener('scroll', reveal);
        reveal(); // Trigger on load

        // Lazy loading for images
        document.addEventListener('DOMContentLoaded', function() {
            var lazyImages = [].slice.call(document.querySelectorAll('img.lazy'));
            if ('IntersectionObserver' in window) {
                let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            let lazyImage = entry.target;
                            lazyImage.src = lazyImage.dataset.src;
                            if (lazyImage.dataset.srcset) {
                                lazyImage.srcset = lazyImage.dataset.srcset;
                            }
                            lazyImage.classList.remove('lazy');
                            lazyImageObserver.unobserve(lazyImage);
                        }
                    });
                });
                lazyImages.forEach(function(lazyImage) {
                    lazyImageObserver.observe(lazyImage);
                });
            } else {
                // Fallback for browsers that don't support IntersectionObserver
                lazyImages.forEach(function(lazyImage) {
                    lazyImage.src = lazyImage.dataset.src;
                    if (lazyImage.dataset.srcset) {
                        lazyImage.srcset = lazyImage.dataset.srcset;
                    }
                    lazyImage.classList.remove('lazy');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
