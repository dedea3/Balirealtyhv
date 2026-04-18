@extends('admin.layout.app')

@section('page-title', 'Amenities Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-gray-500">Manage villa amenities (Facilities, Services, Inclusions)</p>
        </div>
        <a href="{{ route('admin.amenities.create') }}" class="btn-primary inline-flex items-center justify-center">
            <i class="fas fa-plus mr-2"></i> Add Amenity
        </a>
    </div>

    <!-- Categories Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($categories as $category)
            <div class="bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-old-money-charcoal">{{ $category->name }}</p>
                        <p class="text-sm text-gray-500">{{ $category->amenities->count() }} amenities</p>
                    </div>
                    @if($category->icon_class)
                        <i class="{{ $category->icon_class }} text-2xl text-gray-400"></i>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Amenities Table -->
    <div class="bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] sm:min-w-0">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amenity</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Category</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Icon</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 sm:px-6 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($amenities as $amenity)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 sm:px-6">
                                <div class="flex items-center">
                                    @if($amenity->icon_class)
                                        <div class="w-8 h-8 flex items-center justify-center text-old-money-charcoal md:hidden mr-3">
                                            <i class="{{ $amenity->icon_class }} text-lg"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-old-money-charcoal">{{ $amenity->name }}</p>
                                        <div class="sm:hidden mt-0.5">
                                            <span class="text-[10px] text-gray-500 uppercase tracking-wider">{{ $amenity->category->name }}</span>
                                        </div>
                                        @if($amenity->description)
                                            <p class="text-xs text-gray-400 mt-1 hidden sm:block">{{ Str::limit($amenity->description, 50) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 sm:px-6 hidden sm:table-cell">
                                <span class="inline-block px-2 py-0.5 text-[10px] font-medium rounded-full
                                    @if($amenity->category->slug === 'facilities') bg-blue-100 text-blue-800
                                    @elseif($amenity->category->slug === 'services') bg-green-100 text-green-800
                                    @elseif($amenity->category->slug === 'inclusions') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $amenity->category->name }}
                                </span>
                            </td>
                            <td class="px-4 py-4 sm:px-6 hidden md:table-cell">
                                @if($amenity->icon_class)
                                    <div class="flex items-center space-x-2">
                                        <i class="{{ $amenity->icon_class }} text-lg text-old-money-charcoal"></i>
                                        <code class="text-[10px] text-gray-400 font-mono">{{ $amenity->icon_class }}</code>
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 sm:px-6">
                                @if($amenity->is_active)
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-medium rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-medium rounded-full bg-gray-100 text-gray-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.amenities.edit', $amenity) }}" 
                                       class="text-old-money-charcoal hover:text-old-money-black"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.amenities.destroy', $amenity) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Delete this amenity?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-concierge-bell text-4xl text-gray-300 mb-4"></i>
                                <p>No amenities found.</p>
                                <a href="{{ route('admin.amenities.create') }}" class="text-old-money-charcoal hover:underline mt-2 inline-block">
                                    Add Amenity
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($amenities->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $amenities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
