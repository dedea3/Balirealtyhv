@extends('admin.layout.app')

@section('page-title', 'Edit Amenity')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.amenities.update', $amenity) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white shadow-sm p-6 space-y-6">
            <div>
                <label for="amenity_category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select id="amenity_category_id" name="amenity_category_id" class="input-field" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('amenity_category_id', $amenity->amenity_category_id) == $category->id ? 'selected' : '' }}>
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
                       value="{{ old('name', $amenity->name) }}"
                       class="input-field"
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
                          class="input-field">{{ old('description', $amenity->description) }}</textarea>
            </div>
            
            <div>
                <label for="icon_class" class="block text-sm font-medium text-gray-700 mb-2">Icon Class (Font Awesome)</label>
                <input type="text" 
                       id="icon_class" 
                       name="icon_class" 
                       value="{{ old('icon_class', $amenity->icon_class) }}"
                       class="input-field"
                       placeholder="fas fa-swimming-pool">
                @if($amenity->icon_class)
                    <div class="mt-2 flex items-center space-x-2">
                        <i class="{{ $amenity->icon_class }} text-2xl"></i>
                        <span class="text-sm text-gray-500">Current icon</span>
                    </div>
                @endif
            </div>
            
            <div>
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', $amenity->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-old-money-charcoal focus:ring-old-money-charcoal">
                    <span class="ml-2 text-sm text-gray-700">Active (show in villa forms)</span>
                </label>
            </div>
        </div>
        
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.amenities.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save mr-2"></i> Update Amenity
            </button>
        </div>
    </form>
</div>
@endsection
