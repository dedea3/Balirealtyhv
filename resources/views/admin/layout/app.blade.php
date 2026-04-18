<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Bali Realty Holidays Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Backdrop for mobile -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black/50 transition-opacity lg:hidden"
             style="display: none;"></div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-old-money-charcoal text-white transform transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="p-6 flex items-center justify-between">
                <div>
                    <h1 class="font-serif text-xl font-semibold">Bali Realty</h1>
                    <p class="text-xs text-gray-400 mt-1">Admin Panel</p>
                </div>
                <!-- Close sidebar mobile button -->
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('home') }}" target="_blank"
                   class="flex items-center px-6 py-3 text-gray-400 hover:bg-old-money-black hover:text-white transition-colors border-b border-gray-700/50 mb-4">
                    <i class="fas fa-external-link-alt w-6 text-sm"></i>
                    <span class="text-sm">View Website</span>
                </a>

                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-old-money-black hover:text-white transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-old-money-black text-white border-l-4 border-white' : '' }}">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.villas.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-old-money-black hover:text-white transition-colors {{ request()->routeIs('admin.villas.*') ? 'bg-old-money-black text-white border-l-4 border-white' : '' }}">
                    <i class="fas fa-home w-6"></i>
                    <span>Villas</span>
                </a>
                
                <a href="{{ route('admin.amenities.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-old-money-black hover:text-white transition-colors {{ request()->routeIs('admin.amenities.*') ? 'bg-old-money-black text-white border-l-4 border-white' : '' }}">
                    <i class="fas fa-concierge-bell w-6"></i>
                    <span>Amenities</span>
                </a>
                
                <a href="{{ route('admin.inquiries.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-old-money-black hover:text-white transition-colors {{ request()->routeIs('admin.inquiries.*') ? 'bg-old-money-black text-white border-l-4 border-white' : '' }}">
                    <i class="fas fa-envelope w-6"></i>
                    <span>Inquiries</span>
                    @php
                        $newInquiriesCount = \App\Models\Inquiry::where('status', 'new')->count();
                    @endphp
                    @if($newInquiriesCount > 0)
                        <span class="ml-auto bg-white text-old-money-charcoal text-xs font-bold px-2 py-1 rounded-full">{{ $newInquiriesCount }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.reviews.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-old-money-black hover:text-white transition-colors {{ request()->routeIs('admin.reviews.*') ? 'bg-old-money-black text-white border-l-4 border-white' : '' }}">
                    <i class="fas fa-star w-6"></i>
                    <span>Reviews</span>
                </a>
            </nav>
            
            <div class="absolute bottom-12 w-64 p-6 border-t border-gray-700 bg-old-money-charcoal lg:bottom-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center">
                            <span class="text-sm font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3 hidden sm:block">
                            <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-4 py-3 sm:px-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <!-- Hamburger Toggle -->
                        <button @click="sidebarOpen = true" class="p-2 ml-[-8px] text-old-money-charcoal lg:hidden">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="ml-2 text-lg sm:text-2xl font-serif font-semibold text-old-money-charcoal truncate">@yield('page-title', 'Dashboard')</h2>
                    </div>
                </div>
            </header>
            
            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50/50">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
