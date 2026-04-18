@extends('admin.layout.app')

@section('page-title', 'Add Amenity')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.amenities.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white shadow-sm p-6 space-y-6">
            <div>
                <label for="amenity_category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select id="amenity_category_id" name="amenity_category_id" class="input-field" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('amenity_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('amenity_category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Amenity Name *</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="input-field"
                       placeholder="e.g., Private Pool, WiFi, Daily Housekeeping"
                       required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" 
                          name="description" 
                          rows="3" 
                          class="input-field">{{ old('description') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Optional description of the amenity</p>
            </div>
            
            <div>
                <label for="icon_class" class="block text-sm font-medium text-gray-700 mb-2">Icon Class (Font Awesome)</label>
                <input type="text" 
                       id="icon_class" 
                       name="icon_class" 
                       value="{{ old('icon_class') }}"
                       class="input-field"
                       placeholder="fas fa-swimming-pool">
                <p class="text-xs text-gray-500 mt-1">
                    Use Font Awesome 6 classes. Example: <code>fas fa-wifi</code>, <code>fas fa-concierge-bell</code>
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    Browse icons at <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-600 hover:underline">fontawesome.com/icons</a>
                </p>
            </div>
            
            <div>
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-old-money-charcoal focus:ring-old-money-charcoal">
                    <span class="ml-2 text-sm text-gray-700">Active (show in villa forms)</span>
                </label>
            </div>
        </div>
        
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.amenities.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save mr-2"></i> Save Amenity
            </button>
        </div>
    </form>
</div>
@endsection
