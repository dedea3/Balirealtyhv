@extends('admin.layout.app')

@section('page-title', 'Inquiry Details')

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.inquiries.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div>
                <h2 class="text-2xl font-serif font-semibold text-old-money-charcoal">Inquiry #{{ $inquiry->id }}</h2>
                <p class="text-sm text-gray-500">{{ $inquiry->created_at->format('F d, Y \a\t g:i A') }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <span class="inline-block px-4 py-2 text-sm font-medium rounded-full
                @if($inquiry->status === 'new') bg-blue-100 text-blue-800
                @elseif($inquiry->status === 'contacted') bg-yellow-100 text-yellow-800
                @elseif($inquiry->status === 'confirmed') bg-green-100 text-green-800
                @elseif($inquiry->status === 'cancelled') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($inquiry->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="col-span-2 space-y-6">
            <!-- Guest Information -->
            <div class="bg-white shadow-sm p-6">
                <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Guest Information</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-medium">{{ $inquiry->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium"><a href="mailto:{{ $inquiry->email }}" class="text-blue-600 hover:underline">{{ $inquiry->email }}</a></p>
                    </div>
                    @if($inquiry->phone)
                        <div>
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="font-medium">{{ $inquiry->phone }}</p>
                        </div>
                    @endif
                    @if($inquiry->whatsapp)
                        <div>
                            <p class="text-sm text-gray-500">WhatsApp</p>
                            <p class="font-medium">{{ $inquiry->whatsapp }}</p>
                        </div>
                    @endif
                    @if($inquiry->ip_address)
                        <div>
                            <p class="text-sm text-gray-500">IP Address</p>
                            <p class="font-mono text-xs">{{ $inquiry->ip_address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Inquiry Details -->
            <div class="bg-white shadow-sm p-6">
                <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Inquiry Details</h3>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    @if($inquiry->check_in)
                        <div>
                            <p class="text-sm text-gray-500">Check-in</p>
                            <p class="font-medium">{{ $inquiry->check_in->format('F d, Y') }}</p>
                        </div>
                    @endif
                    @if($inquiry->check_out)
                        <div>
                            <p class="text-sm text-gray-500">Check-out</p>
                            <p class="font-medium">{{ $inquiry->check_out->format('F d, Y') }}</p>
                        </div>
                    @endif
                    @if($inquiry->number_of_guests)
                        <div>
                            <p class="text-sm text-gray-500">Number of Guests</p>
                            <p class="font-medium">{{ $inquiry->number_of_guests }}</p>
                        </div>
                    @endif
                    @if($inquiry->number_of_rooms)
                        <div>
                            <p class="text-sm text-gray-500">Number of Rooms</p>
                            <p class="font-medium">{{ $inquiry->number_of_rooms }}</p>
                        </div>
                    @endif
                </div>
                
                @if($inquiry->message)
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-2">Message</p>
                        <p class="text-gray-700 whitespace-pre-line">{{ $inquiry->message }}</p>
                    </div>
                @endif
                
                @if($inquiry->special_requests)
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Special Requests</p>
                        <p class="text-gray-700 whitespace-pre-line">{{ $inquiry->special_requests }}</p>
                    </div>
                @endif
            </div>

            <!-- Admin Notes -->
            <div class="bg-white shadow-sm p-6">
                <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Admin Notes</h3>
                
                <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <textarea name="admin_notes" 
                              rows="4" 
                              class="input-field mb-4"
                              placeholder="Add internal notes about this inquiry...">{{ old('admin_notes', $inquiry->admin_notes) }}</textarea>
                    
                    <button type="submit" class="btn-secondary text-sm">
                        <i class="fas fa-save mr-2"></i> Save Notes
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Villa Information -->
            @if($inquiry->villa)
                <div class="bg-white shadow-sm p-6">
                    <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Villa</h3>
                    
                    @if(true /* Image fallback enabled */)
                        <img src="{{ $inquiry->villa->cover_image_url }}" 
                             alt="{{ $inquiry->villa->name }}" 
                             class="w-full h-32 object-cover mb-4">
                    @endif
                    
                    <p class="font-medium">{{ $inquiry->villa->name }}</p>
                    <p class="text-sm text-gray-500">{{ $inquiry->villa->area?->name ?? 'No area' }}</p>
                    
                    <a href="{{ route('admin.villas.show', $inquiry->villa) }}" 
                       class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                        View Villa Details
                    </a>
                </div>
            @else
                <div class="bg-white shadow-sm p-6">
                    <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Villa</h3>
                    <p class="text-gray-500">General Inquiry (no specific villa)</p>
                </div>
            @endif

            <!-- Status Update -->
            <div class="bg-white shadow-sm p-6">
                <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Update Status</h3>
                
                <form action="{{ route('admin.inquiries.status', $inquiry) }}" method="POST">
                    @csrf
                    
                    <select name="status" class="input-field mb-4" onchange="this.form.submit()">
                        <option value="new" {{ $inquiry->status === 'new' ? 'selected' : '' }}>New</option>
                        <option value="contacted" {{ $inquiry->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="confirmed" {{ $inquiry->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ $inquiry->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="archived" {{ $inquiry->status === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </form>
                
                @if($inquiry->contacted_at)
                    <p class="text-xs text-gray-500 mb-1">
                        <i class="fas fa-check"></i> Contacted: {{ $inquiry->contacted_at->diffForHumans() }}
                    </p>
                @endif
                @if($inquiry->confirmed_at)
                    <p class="text-xs text-gray-500">
                        <i class="fas fa-check"></i> Confirmed: {{ $inquiry->confirmed_at->diffForHumans() }}
                    </p>
                @endif
            </div>

            <!-- Assign To -->
            <div class="bg-white shadow-sm p-6">
                <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Assign To</h3>
                
                <form action="{{ route('admin.inquiries.assign', $inquiry) }}" method="POST">
                    @csrf
                    
                    <select name="assigned_to" class="input-field mb-4">
                        <option value="">Unassigned</option>
                        @foreach(\App\Models\User::where('is_active', true)->get() as $user)
                            <option value="{{ $user->id }}" {{ $inquiry->assigned_to === $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ ucfirst($user->role) }})
                            </option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="btn-secondary text-sm w-full">
                        <i class="fas fa-user-check mr-2"></i> Assign
                    </button>
                </form>
                
                @if($inquiry->assignedTo)
                    <div class="mt-4 flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-old-money-beige flex items-center justify-center">
                            <span class="text-sm font-semibold">{{ substr($inquiry->assignedTo->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ $inquiry->assignedTo->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($inquiry->assignedTo->role) }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Timeline -->
            <div class="bg-white shadow-sm p-6">
                <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Timeline</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-inbox text-gray-400 mt-1"></i>
                        <div>
                            <p class="font-medium">Inquiry Received</p>
                            <p class="text-gray-500">{{ $inquiry->created_at->format('M d, Y g:i A') }}</p>
                        </div>
                    </div>
                    
                    @if($inquiry->contacted_at)
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-phone text-green-500 mt-1"></i>
                            <div>
                                <p class="font-medium">Contacted</p>
                                <p class="text-gray-500">{{ $inquiry->contacted_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($inquiry->confirmed_at)
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-check-circle text-blue-500 mt-1"></i>
                            <div>
                                <p class="font-medium">Confirmed</p>
                                <p class="text-gray-500">{{ $inquiry->confirmed_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-clock text-gray-400 mt-1"></i>
                        <div>
                            <p class="font-medium">Last Updated</p>
                            <p class="text-gray-500">{{ $inquiry->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
