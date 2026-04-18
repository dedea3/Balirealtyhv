@extends('admin.layout.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Villas -->
        <div class="bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Villas</p>
                    <p class="text-3xl font-serif font-semibold text-old-money-charcoal mt-1">{{ $stats['total_villas'] }}</p>
                </div>
                <div class="w-12 h-12 bg-old-money-beige rounded-full flex items-center justify-center">
                    <i class="fas fa-home text-old-money-charcoal"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 font-medium">{{ $stats['published_villas'] }} published</span>
                <span class="text-gray-400 mx-2">•</span>
                <span class="text-gray-500">{{ $stats['draft_villas'] }} draft</span>
            </div>
        </div>

        <!-- New Inquiries -->
        <div class="bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">New Inquiries</p>
                    <p class="text-3xl font-serif font-semibold text-old-money-charcoal mt-1">{{ $stats['new_inquiries'] }}</p>
                </div>
                <div class="w-12 h-12 bg-old-money-beige rounded-full flex items-center justify-center">
                    <i class="fas fa-envelope text-old-money-charcoal"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">{{ $stats['total_inquiries'] }} total inquiries</span>
            </div>
        </div>

        <!-- Reviews -->
        <div class="bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Published Reviews</p>
                    <p class="text-3xl font-serif font-semibold text-old-money-charcoal mt-1">{{ $stats['published_reviews'] }}</p>
                </div>
                <div class="w-12 h-12 bg-old-money-beige rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-old-money-charcoal"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Guest testimonials</span>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500 mb-4">Quick Actions</p>
            <div class="space-y-2">
                <a href="{{ route('admin.villas.create') }}" class="block text-sm text-old-money-charcoal hover:text-old-money-black">
                    <i class="fas fa-plus w-5"></i> Add New Villa
                </a>
                <a href="{{ route('admin.inquiries.index') }}" class="block text-sm text-old-money-charcoal hover:text-old-money-black">
                    <i class="fas fa-envelope w-5"></i> View Inquiries
                </a>
                <a href="{{ route('admin.reviews.create') }}" class="block text-sm text-old-money-charcoal hover:text-old-money-black">
                    <i class="fas fa-star w-5"></i> Add Review
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Inquiries -->
        <div class="bg-white shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-serif font-semibold text-old-money-charcoal">Recent Inquiries</h3>
                <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-gray-500 hover:text-old-money-charcoal">View All</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentInquiries as $inquiry)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="font-medium text-old-money-charcoal">{{ $inquiry->name }}</p>
                                <p class="text-sm text-gray-500">{{ $inquiry->email }}</p>
                                @if($inquiry->villa)
                                    <p class="text-xs text-gray-400 mt-1">
                                        <i class="fas fa-home"></i> {{ $inquiry->villa->name }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 text-xs font-medium rounded-full
                                    @if($inquiry->status === 'new') bg-blue-100 text-blue-800
                                    @elseif($inquiry->status === 'contacted') bg-yellow-100 text-yellow-800
                                    @elseif($inquiry->status === 'confirmed') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                                <p class="text-xs text-gray-400 mt-1">{{ $inquiry->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                        <p>No inquiries yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Villas Needing Attention -->
        <div class="bg-white shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-serif font-semibold text-old-money-charcoal">Draft Villas</h3>
                <a href="{{ route('admin.villas.index') }}" class="text-sm text-gray-500 hover:text-old-money-charcoal">Manage All</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($villasNeedingAttention as $villa)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="font-medium text-old-money-charcoal">{{ $villa->name }}</p>
                                <p class="text-sm text-gray-500">{{ $villa->area?->name ?? 'No area assigned' }}</p>
                            </div>
                            <a href="{{ route('admin.villas.edit', $villa) }}" class="text-sm text-old-money-charcoal hover:text-old-money-black">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-check-circle text-3xl text-green-500 mb-2"></i>
                        <p>All villas are published!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
