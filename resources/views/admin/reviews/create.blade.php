@extends('admin.layout.app')

@section('page-title', 'Add Review')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.reviews.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white shadow-sm p-6 space-y-6">
            <div>
                <label for="villa_id" class="block text-sm font-medium text-gray-700 mb-2">Villa *</label>
                <select id="villa_id" name="villa_id" class="input-field" required>
                    <option value="">Select Villa</option>
                    @foreach($villas as $villa)
                        <option value="{{ $villa->id }}" {{ old('villa_id') == $villa->id ? 'selected' : '' }}>
                            {{ $villa->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-2">Guest Name *</label>
                <input type="text" id="guest_name" name="guest_name" value="{{ old('guest_name') }}" class="input-field" required>
            </div>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <input type="text" id="country" name="country" value="{{ old('country') }}" class="input-field">
                </div>
                
                <div>
                    <label for="guest_type" class="block text-sm font-medium text-gray-700 mb-2">Guest Type</label>
                    <select id="guest_type" name="guest_type" class="input-field">
                        <option value="">Select Type</option>
                        <option value="Family" {{ old('guest_type') === 'Family' ? 'selected' : '' }}>Family</option>
                        <option value="Couple" {{ old('guest_type') === 'Couple' ? 'selected' : '' }}>Couple</option>
                        <option value="Group" {{ old('guest_type') === 'Group' ? 'selected' : '' }}>Group</option>
                        <option value="Solo" {{ old('guest_type') === 'Solo' ? 'selected' : '' }}>Solo</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                <select id="rating" name="rating" class="input-field">
                    <option value="">Select Rating</option>
                    <option value="5" {{ old('rating') === 5 ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ old('rating') === 4 ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ old('rating') === 3 ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ old('rating') === 2 ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ old('rating') === 1 ? 'selected' : '' }}>1 Star</option>
                </select>
            </div>
            
            <div>
                <label for="review_text" class="block text-sm font-medium text-gray-700 mb-2">Review *</label>
                <textarea id="review_text" name="review_text" rows="5" class="input-field" required>{{ old('review_text') }}</textarea>
            </div>
            
            <div class="flex space-x-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="rounded">
                    <span class="ml-2 text-sm text-gray-700">Published</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded">
                    <span class="ml-2 text-sm text-gray-700">Featured</span>
                </label>
            </div>
        </div>
        
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.reviews.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Save Review</button>
        </div>
    </form>
</div>
@endsection
