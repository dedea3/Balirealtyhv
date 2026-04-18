@extends('admin.layout.app')

@section('page-title', 'Inquiries')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 shadow-sm border-l-4 border-blue-500">
            <p class="text-xs text-gray-500 uppercase tracking-wider">New</p>
            <p class="text-xl sm:text-2xl font-serif font-semibold text-blue-600">{{ $stats['new'] }}</p>
        </div>
        <div class="bg-white p-4 shadow-sm border-l-4 border-yellow-500">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Contacted</p>
            <p class="text-xl sm:text-2xl font-serif font-semibold text-yellow-600">{{ $stats['contacted'] }}</p>
        </div>
        <div class="bg-white p-4 shadow-sm border-l-4 border-green-500">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Confirmed</p>
            <p class="text-xl sm:text-2xl font-serif font-semibold text-green-600">{{ $stats['confirmed'] }}</p>
        </div>
        <div class="bg-white p-4 shadow-sm border-l-4 border-gray-400">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Archived</p>
            <p class="text-xl sm:text-2xl font-serif font-semibold text-gray-600">{{ $stats['archived'] }}</p>
        </div>
    </div>

    <!-- Inquiries Table -->
    <div class="bg-white shadow-sm overflow-hidden text-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] sm:min-w-0">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Villa</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Dates</th>
                        <th class="px-4 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 sm:px-6 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($inquiries as $inquiry)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 sm:px-6">
                                <div>
                                    <p class="font-medium text-old-money-charcoal">{{ $inquiry->name }}</p>
                                    <p class="text-xs text-gray-500 truncate max-w-[150px] sm:max-w-none">{{ $inquiry->email }}</p>
                                    <div class="md:hidden mt-1 text-[10px] text-gray-400">
                                        {{ $inquiry->villa?->name ?? 'General Inquiry' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 sm:px-6 hidden md:table-cell text-gray-600">
                                {{ $inquiry->villa?->name ?? 'General Inquiry' }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 hidden lg:table-cell">
                                @if($inquiry->check_in && $inquiry->check_out)
                                    <p class="text-xs text-gray-600">{{ $inquiry->check_in->format('M d, Y') }}</p>
                                    <p class="text-[10px] text-gray-400">to {{ $inquiry->check_out->format('M d, Y') }}</p>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 sm:px-6">
                                <span class="inline-block px-2 py-0.5 text-[10px] font-medium rounded-full
                                    @if($inquiry->status === 'new') bg-blue-100 text-blue-800
                                    @elseif($inquiry->status === 'contacted') bg-yellow-100 text-yellow-800
                                    @elseif($inquiry->status === 'confirmed') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-right">
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}" 
                                   class="text-xs font-medium text-old-money-charcoal hover:text-old-money-black inline-flex items-center">
                                    <span class="hidden sm:inline mr-1">View</span>
                                    <i class="fas fa-arrow-right sm:text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                <p>No inquiries yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inquiries->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
