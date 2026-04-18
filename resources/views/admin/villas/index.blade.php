@extends('admin.layout.app')

@section('page-title', 'Villas Management')

@section('content')
<div class="space-y-6">
    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-1">
        <div class="flex-1">
            <p class="text-gray-500 text-sm">Manage your villa portfolio ({{ $villas->total() }} villas)</p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            <form action="{{ route('admin.villas.index') }}" method="GET" class="relative group w-full sm:w-64">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search villa name..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-200 focus:border-old-money-charcoal focus:ring-1 focus:ring-old-money-charcoal outline-none transition-all text-sm rounded-none shadow-sm">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-old-money-charcoal transition-colors">
                    <i class="fas fa-search text-xs"></i>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.villas.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500">
                        <i class="fas fa-times-circle text-xs"></i>
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.villas.create') }}" class="btn-primary w-full sm:w-auto inline-flex items-center justify-center whitespace-nowrap">
                <i class="fas fa-plus mr-2 text-xs"></i> Add New Villa
            </a>
        </div>
    </div>

    <!-- Villas Table -->
    <div class="bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] sm:min-w-0">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Villa</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Area</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Details</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 sm:px-6 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($villas as $villa)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $villa->cover_image_url }}" 
                                             alt="{{ $villa->name }}" 
                                             class="w-10 h-10 sm:w-12 sm:h-12 object-cover rounded shadow-sm">
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-medium text-old-money-charcoal text-sm sm:text-base">{{ $villa->name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5 md:hidden">{{ $villa->area?->name ?? 'No Area' }}</p>
                                        <p class="text-xs text-gray-400 mt-1 hidden sm:block">{{ Str::limit($villa->short_description, 40) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 sm:px-6 hidden md:table-cell">
                                <span class="text-sm text-gray-600">{{ $villa->area?->name ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-4 sm:px-6 hidden lg:table-cell">
                                <div class="text-xs text-gray-600 space-y-1">
                                    <p><i class="fas fa-bed w-4"></i> {{ $villa->bedrooms }} Beds</p>
                                    <p><i class="fas fa-bath w-4"></i> {{ $villa->bathrooms }} Baths</p>
                                </div>
                            </td>
                            <td class="px-4 py-4 sm:px-6">
                                <span class="inline-block px-2 py-0.5 text-[10px] sm:text-xs font-medium rounded-full
                                    @if($villa->status === 'published') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($villa->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-right">
                                <div class="flex items-center justify-end space-x-3 sm:space-x-4">
                                    <a href="{{ route('admin.villas.edit', $villa) }}" 
                                       class="text-old-money-charcoal hover:text-old-money-black"
                                       title="Edit Villa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.villas.show', $villa) }}" 
                                       class="text-gray-400 hover:text-gray-600 hidden sm:inline"
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.villas.destroy', $villa) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this villa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <i class="fas fa-home text-4xl text-gray-300 mb-4"></i>
                                @if(request('search'))
                                    <p class="text-gray-500">No villas found matching "{{ request('search') }}".</p>
                                    <a href="{{ route('admin.villas.index') }}" class="text-old-money-charcoal hover:underline mt-2 inline-block">
                                        Clear Search
                                    </a>
                                @else
                                    <p class="text-gray-500">No villas found.</p>
                                    <a href="{{ route('admin.villas.create') }}" class="text-old-money-charcoal hover:underline mt-2 inline-block">
                                        Add New Villa
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($villas->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $villas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
