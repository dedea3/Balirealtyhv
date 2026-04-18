@extends('admin.layout.app')

@section('page-title', 'Reviews')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p class="text-gray-500">Manage guest testimonials</p>
        <a href="{{ route('admin.reviews.create') }}" class="btn-primary inline-flex items-center justify-center">
            <i class="fas fa-plus mr-2"></i> Add Review
        </a>
    </div>

    <div class="bg-white shadow-sm overflow-hidden text-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] sm:min-w-0">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Villa</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Rating</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 sm:px-6 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 sm:px-6">
                                <div>
                                    <p class="font-medium text-old-money-charcoal">{{ $review->guest_name }}</p>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $review->country ?? 'Unknown' }}</p>
                                    <div class="md:hidden mt-1 text-[10px] text-gray-500">
                                        {{ $review->villa?->name ?? '-' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 sm:px-6 hidden md:table-cell text-gray-600">
                                {{ $review->villa?->name ?? '-' }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 hidden sm:table-cell">
                                @if($review->rating)
                                    <div class="flex text-yellow-400 text-xs">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 sm:px-6">
                                @if($review->is_published)
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-medium rounded-full bg-green-100 text-green-800">Published</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-medium rounded-full bg-gray-100 text-gray-800">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.reviews.edit', $review) }}" 
                                       class="text-old-money-charcoal hover:text-old-money-black"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Delete this review?');">
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
                                <i class="fas fa-star text-4xl text-gray-300 mb-4"></i>
                                <p>No reviews yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
