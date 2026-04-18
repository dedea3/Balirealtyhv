@extends('admin.layout.app')

@section('page-title', 'Edit Villa')

@section('content')
<div class="max-w-5xl">
    <form action="{{ route('admin.villas.update', $villa) }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="villa-edit-form">
        @csrf
        @method('PUT')
        
        <!-- Basic Information -->
        <div class="bg-white shadow-sm p-6">
            <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Basic Information</h3>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Villa Name *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $villa->name) }}"
                           class="input-field"
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="area_id" class="block text-sm font-medium text-gray-700 mb-2">Area *</label>
                    <select id="area_id" name="area_id" class="input-field" required>
                        <option value="">Select Area</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ old('area_id', $villa->area_id) == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('area_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6">
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                <textarea id="short_description" 
                          name="short_description" 
                          rows="2" 
                          class="input-field"
                          maxlength="500">{{ old('short_description', $villa->short_description) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Brief summary for listing pages (max 500 characters)</p>
            </div>
            
            <div class="mt-6">
                <label for="overview" class="block text-sm font-medium text-gray-700 mb-2">Overview (Full Description)</label>
                <textarea id="overview" 
                          name="overview" 
                          rows="6" 
                          class="input-field">{{ old('overview', $villa->overview) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Detailed description of the villa</p>
            </div>
        </div>
        
        <!-- Property Details -->
        <div class="bg-white shadow-sm p-6">
            <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Property Details</h3>
            
            <div class="grid grid-cols-4 gap-6">
                <div>
                    <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-2">Bedrooms *</label>
                    <input type="number" 
                           id="bedrooms" 
                           name="bedrooms" 
                           value="{{ old('bedrooms', $villa->bedrooms) }}"
                           min="1"
                           class="input-field"
                           required>
                </div>
                
                <div>
                    <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-2">Bathrooms *</label>
                    <input type="number" 
                           id="bathrooms" 
                           name="bathrooms" 
                           value="{{ old('bathrooms', $villa->bathrooms) }}"
                           min="1"
                           class="input-field"
                           required>
                </div>
                
                <div>
                    <label for="max_guests" class="block text-sm font-medium text-gray-700 mb-2">Max Guests *</label>
                    <input type="number" 
                           id="max_guests" 
                           name="max_guests" 
                           value="{{ old('max_guests', $villa->max_guests) }}"
                           min="1"
                           class="input-field"
                           required>
                </div>
                
                <div>
                    <label for="property_size_sqm" class="block text-sm font-medium text-gray-700 mb-2">Property Size</label>
                    <input type="number" 
                           id="property_size_sqm" 
                           name="property_size_sqm" 
                           value="{{ old('property_size_sqm', $villa->property_size_sqm) }}"
                           class="input-field">
                </div>
            </div>

            <div class="mt-6">
                <label class="flex items-center">
                    <input type="checkbox"
                           name="has_flexible_config"
                           value="1"
                           {{ old('has_flexible_config', $villa->has_flexible_config) ? 'checked' : '' }}
                           id="has_flexible_config"
                           class="rounded border-gray-300 text-old-money-charcoal focus:ring-old-money-charcoal">
                    <span class="ml-2 text-sm font-medium text-gray-700">This villa has flexible bedroom configurations</span>
                </label>
                <p class="text-xs text-gray-500 mt-1 ml-6">
                    Enable this if the villa can be rented with different bedroom counts (e.g., 3, 4, or 5 bedrooms)
                </p>
            </div>
        </div>

        <!-- Bedroom Configurations -->
        <div class="bg-white shadow-sm p-6" id="bedroom_configs_section" style="{{ old('has_flexible_config', $villa->has_flexible_config) ? '' : 'display: none;' }}">
            <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Bedroom Configurations</h3>
            <p class="text-sm text-gray-500 mb-4">
                Add different bedroom configurations for this villa. For example, if the villa can be rented as 3, 4, or 5 bedrooms.
            </p>

            <div id="bedroom_configs_container" class="space-y-4">
                @if(old('bedroom_configs'))
                    @foreach(old('bedroom_configs') as $index => $config)
                        @include('admin.villas.partials.bedroom_config_edit_row', ['index' => $index, 'config' => $config])
                    @endforeach
                @elseif($villa->bedroomConfigs->count() > 0)
                    @foreach($villa->bedroomConfigs as $index => $config)
                        @include('admin.villas.partials.bedroom_config_edit_row', ['index' => $index, 'config' => $config, 'existing' => true])
                    @endforeach
                @endif
            </div>

            <button type="button" id="add_bedroom_config" class="btn-secondary mt-4">
                <i class="fas fa-plus mr-2"></i> Add Bedroom Configuration
            </button>
        </div>

        <template id="bedroom_config_template">
            <div class="bedroom_config_row border border-gray-200 p-4 rounded relative">
                <button type="button" class="remove_config absolute top-2 right-2 text-red-500 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Bedrooms</label>
                        <input type="number" name="bedroom_configs[__INDEX__][bedroom_count]"
                               class="input-field text-sm py-2" min="1" max="20" required>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Price per Night (USD)</label>
                        <input type="number" name="bedroom_configs[__INDEX__][price_per_night]"
                               class="input-field text-sm py-2" step="0.01" required>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Min Nights</label>
                        <input type="number" name="bedroom_configs[__INDEX__][min_nights]"
                               class="input-field text-sm py-2" value="1" required>
                    </div>
                    <div class="flex items-end">
                        <label class="flex items-center">
                            <input type="checkbox" name="bedroom_configs[__INDEX__][is_active]" value="1" checked
                                   class="rounded border-gray-300 text-old-money-charcoal">
                            <span class="ml-2 text-xs text-gray-600">Active</span>
                        </label>
                    </div>
                </div>
            </div>
        </template>

        <!-- Location -->
        <div class="bg-white shadow-sm p-6">
            <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Location & Map</h3>
            @php $location = json_decode($villa->location, true) ?? []; @endphp
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Physical Address</label>
                    <textarea id="address" name="location[address]" rows="2" class="input-field" placeholder="Full address of the villa">{{ old('location.address', $location['address'] ?? '') }}</textarea>
                </div>
                
                <div>
                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                    <input type="text" id="latitude" name="location[latitude]" value="{{ old('location.latitude', $location['latitude'] ?? '') }}" class="input-field" placeholder="-8.123456">
                </div>
                
                <div>
                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                    <input type="text" id="longitude" name="location[longitude]" value="{{ old('location.longitude', $location['longitude'] ?? '') }}" class="input-field" placeholder="115.123456">
                </div>

                <div class="md:col-span-2">
                    <label for="map_link" class="block text-sm font-medium text-gray-700 mb-2">Google Maps Embed URL</label>
                    <input type="text" id="map_link" name="location[map_link]" value="{{ old('location.map_link', $location['map_link'] ?? '') }}" class="input-field" placeholder="https://www.google.com/maps/embed?pb=...">
                    <p class="text-xs text-gray-500 mt-1">Copy the 'src' value from Google Maps 'Embed a map' iframe code.</p>
                </div>
            </div>
        </div>

        <!-- Amenities -->
        <div class="bg-white shadow-sm p-6">
            <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Amenities</h3>
            
            <div class="space-y-6">
                @foreach($amenities->groupBy('category.slug') as $categorySlug => $amenityGroup)
                    @php
                        $category = $amenityGroup->first()->category;
                    @endphp
                    <div>
                        <h4 class="font-medium text-gray-700 mb-3">{{ $category->name }}</h4>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach($amenityGroup as $amenity)
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" 
                                           name="amenities[]" 
                                           value="{{ $amenity->id }}"
                                           {{ $villa->amenities->contains($amenity->id) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-old-money-charcoal focus:ring-old-money-charcoal">
                                    <span class="text-sm text-gray-700">{{ $amenity->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Seasonal Rates -->
        <div class="bg-white shadow-sm p-6">
            <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Seasonal Rates</h3>
            
            <div class="space-y-4">
                @foreach($seasons as $season)
                    @php
                        $rate = $villa->rates->firstWhere('season_id', $season->id);
                    @endphp
                    <div class="border border-gray-200 p-4 rounded">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-700">{{ $season->name }}</h4>
                            <span class="text-xs text-gray-500">{{ $season->start_date->format('M d') }} - {{ $season->end_date->format('M d') }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Price per Night (USD)</label>
                                <input type="number" 
                                       name="rates[{{ $season->id }}][price_per_night]" 
                                       step="0.01"
                                       value="{{ old('rates.' . $season->id . '.price_per_night', $rate?->price_per_night) }}"
                                       class="input-field text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Currency</label>
                                <input type="text" 
                                       name="rates[{{ $season->id }}][currency]" 
                                       value="{{ old('rates.' . $season->id . '.currency', $rate?->currency ?? 'USD') }}"
                                       class="input-field text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Min Nights</label>
                                <input type="number" 
                                       name="rates[{{ $season->id }}][minimum_nights]" 
                                       value="{{ old('rates.' . $season->id . '.minimum_nights', $rate?->minimum_nights ?? 1) }}"
                                       class="input-field text-sm py-2">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Settings -->
        <div class="bg-white shadow-sm p-6">
            <h3 class="font-serif text-lg font-semibold text-old-money-charcoal mb-4">Settings</h3>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select id="status" name="status" class="input-field" required>
                        <option value="draft" {{ old('status', $villa->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $villa->status) === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Options</label>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_featured" 
                               value="1"
                               {{ old('is_featured', $villa->is_featured) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-old-money-charcoal focus:ring-old-money-charcoal">
                        <span class="ml-2 text-sm text-gray-700">Featured Villa</span>
                    </label>
                </div>
            </div>
            
            <div class="mt-6">
                <label for="ical_url" class="block text-sm font-medium text-gray-700 mb-2">iCal Export URL</label>
                <input type="url"
                       id="ical_url"
                       name="ical_url"
                       value="{{ old('ical_url', $villa->ical_url) }}"
                       class="input-field"
                       placeholder="https://...">
                <p class="text-xs text-gray-500 mt-1">External calendar sync URL (Airbnb, Booking.com, etc.)</p>
            </div>

            @if($villa->ical_url)
                <div class="mt-6 bg-blue-50 border border-blue-200 p-4 rounded">
                    <h4 class="font-medium text-blue-800 mb-2">
                        <i class="fas fa-sync mr-2"></i> Calendar Sync
                    </h4>
                    <div class="flex items-center space-x-4">
                        <button type="button" 
                                onclick="document.getElementById('ical-sync-form').submit();"
                                class="btn-secondary text-sm">
                            <i class="fas fa-sync-alt mr-2"></i> Sync Now
                        </button>
                        <a href="{{ route('admin.ical.export', $villa) }}" class="text-blue-600 hover:underline text-sm">
                            <i class="fas fa-download mr-1"></i> Download iCal
                        </a>
                    </div>
                    <p class="text-xs text-blue-600 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Last synced: {{ $villa->updated_at->diffForHumans() }}
                    </p>
                </div>
            @endif
        </div>
    </form>
    
    <!-- Separate Forms for Actions -->
    <form id="ical-sync-form" action="{{ route('admin.ical.sync', $villa) }}" method="POST" class="hidden">
        @csrf
    </form>
        
            <!-- Photo Management -->
            <div class="bg-white shadow-sm p-6" x-data="{ selectedPhotos: [], showBulkActions: false }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-serif text-lg font-semibold text-old-money-charcoal">Photos</h3>
                    
                    @if($villa->photos->count() > 0)
                        <div class="flex items-center space-x-4" x-show="selectedPhotos.length > 0">
                            <span class="text-sm text-gray-500"><span x-text="selectedPhotos.length"></span> photos selected</span>
                            <form action="{{ route('admin.villas.photos.bulk-delete') }}" method="POST" onsubmit="return confirm('Delete selected photos?');">
                                @csrf
                                @method('DELETE')
                                <template x-for="id in selectedPhotos" :key="id">
                                    <input type="hidden" name="photo_ids[]" :value="id">
                                </template>
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center">
                                    <i class="fas fa-trash-alt mr-2 text-xs"></i> Delete Selected
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                
                @if($villa->photos->count() > 0)
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4 bg-gray-50 p-3">
                            <h4 class="text-sm font-medium text-gray-700">Existing Photos</h4>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" 
                                       @change="if($el.checked) { selectedPhotos = [@foreach($villa->photos as $p)'{{ $p->id }}',@endforeach] } else { selectedPhotos = [] }"
                                       :checked="selectedPhotos.length === {{ $villa->photos->count() }}"
                                       class="rounded border-gray-300 text-old-money-charcoal focus:ring-old-money-charcoal">
                                <span class="ml-2 text-xs text-gray-500 group-hover:text-old-money-charcoal transition-colors">Select All</span>
                            </label>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @foreach($villa->photos as $photo)
                                <div class="relative group aspect-square border-2 transition-all cursor-pointer"
                                     :class="selectedPhotos.includes('{{ $photo->id }}') ? 'border-old-money-charcoal' : 'border-transparent'">
                                    
                                    <!-- Photo Click Trigger -->
                                    <div class="absolute inset-0 z-10" @click="if(selectedPhotos.includes('{{ $photo->id }}')) { selectedPhotos = selectedPhotos.filter(id => id !== '{{ $photo->id }}') } else { selectedPhotos.push('{{ $photo->id }}') }"></div>

                                    <img src="{{ $photo->url }}" 
                                         alt="{{ $photo->alt_text ?? $villa->name }}" 
                                         class="w-full h-full object-cover">
                                    
                                    <!-- Checkbox Visual -->
                                    <div class="absolute top-2 left-2 z-20">
                                        <input type="checkbox" 
                                               :checked="selectedPhotos.includes('{{ $photo->id }}')"
                                               @click.stop="if(selectedPhotos.includes('{{ $photo->id }}')) { selectedPhotos = selectedPhotos.filter(id => id !== '{{ $photo->id }}') } else { selectedPhotos.push('{{ $photo->id }}') }"
                                               class="rounded border-gray-300 text-old-money-charcoal focus:ring-old-money-charcoal w-4 h-4 shadow-sm">
                                    </div>

                                    <!-- Tags -->
                                    <div class="absolute top-2 right-2 flex flex-col items-end space-y-1">
                                        <span class="inline-block px-1.5 py-0.5 text-[10px] rounded shadow-sm
                                            @if($photo->category === 'hero') bg-yellow-400 text-yellow-900
                                            @else bg-white/90 text-gray-700
                                            @endif">
                                            {{ ucfirst($photo->category) }}
                                        </span>
                                        @if($photo->is_primary)
                                            <span class="bg-old-money-charcoal text-white text-[10px] px-1.5 py-0.5 shadow-sm">
                                                <i class="fas fa-star text-[8px] mr-1 text-yellow-300"></i>Hero
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Photo Actions -->
                                    <div class="absolute bottom-2 right-2 z-20 opacity-0 group-hover:opacity-100 transition-opacity flex space-x-2">
                                        @if(!$photo->is_primary)
                                            <button type="button" 
                                                    onclick="document.getElementById('set-primary-{{ $photo->id }}').submit();"
                                                    class="bg-white/90 text-old-money-charcoal w-7 h-7 flex items-center justify-center rounded-full hover:bg-yellow-400 hover:text-yellow-900 shadow-md"
                                                    title="Set as Hero">
                                                <i class="fas fa-star text-xs"></i>
                                            </button>
                                        @endif
                                        <button type="button" 
                                                onclick="if(confirm('Delete this photo?')) { document.getElementById('delete-photo-{{ $photo->id }}').submit(); }"
                                                class="bg-red-600 text-white w-7 h-7 flex items-center justify-center rounded-full hover:bg-red-700 shadow-md"
                                                title="Delete Photo">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>

                                    <form id="set-primary-{{ $photo->id }}" action="{{ route('admin.villas.photos.primary', $photo) }}" 
                                          method="POST" class="hidden">
                                        @csrf
                                    </form>

                                    <form id="delete-photo-{{ $photo->id }}" action="{{ route('admin.villas.photos.delete', $photo) }}" 
                                          method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            
            <div>
                <h4 class="text-sm font-medium text-gray-700 mb-3">Upload New Photos</h4>
                <form action="{{ route('admin.villas.photos.upload', $villa) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Photo Category</label>
                        <select name="category" class="input-field" required>
                            <option value="gallery">Gallery</option>
                            <option value="hero">Hero (Main Image)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Photos</label>
                        <input type="file" 
                               name="photos[]" 
                               multiple 
                               accept="image/*"
                               class="input-field"
                               required>
                        <p class="text-xs text-gray-500 mt-1">You can select multiple files. Max 5MB per image.</p>
                    </div>
                    <button type="submit" class="btn-secondary text-sm">
                        <i class="fas fa-upload mr-2"></i> Upload Photos
                    </button>
                </form>
            </div>
        <!-- Submit Buttons at Bottom -->
        <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-100 mt-12 mb-12">
            <a href="{{ route('admin.villas.index') }}" class="btn-secondary">
                Cancel
            </a>
            <button type="submit" form="villa-edit-form" class="btn-primary">
                <i class="fas fa-save mr-2"></i> Update Villa
            </button>
        </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const flexibleConfigCheckbox = document.getElementById('has_flexible_config');
    const bedroomConfigsSection = document.getElementById('bedroom_configs_section');
    const bedroomConfigsContainer = document.getElementById('bedroom_configs_container');
    const addBedroomConfigBtn = document.getElementById('add_bedroom_config');
    const template = document.getElementById('bedroom_config_template');
    let configIndex = {{ old('bedroom_configs') ? count(old('bedroom_configs')) : ($villa->bedroomConfigs->count() > 0 ? $villa->bedroomConfigs->count() : 0) }};

    // Toggle bedroom configs section
    flexibleConfigCheckbox.addEventListener('change', function() {
        bedroomConfigsSection.style.display = this.checked ? 'block' : 'none';
    });

    // Add new bedroom config
    addBedroomConfigBtn.addEventListener('click', function() {
        const newConfig = template.innerHTML.replace(/__INDEX__/g, configIndex);
        bedroomConfigsContainer.insertAdjacentHTML('beforeend', newConfig);
        configIndex++;
        attachRemoveListeners();
    });

    // Attach remove listeners
    function attachRemoveListeners() {
        document.querySelectorAll('.remove_config').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.bedroom_config_row').remove();
            });
        });
    }

    // Initialize
    attachRemoveListeners();
});
</script>
@endpush
@endsection
