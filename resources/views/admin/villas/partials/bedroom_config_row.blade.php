<div class="bedroom_config_row border border-gray-200 p-4 rounded relative">
    <button type="button" class="remove_config absolute top-2 right-2 text-red-500 hover:text-red-700">
        <i class="fas fa-trash"></i>
    </button>
    <div class="grid grid-cols-4 gap-4">
        <div>
            <label class="block text-xs text-gray-600 mb-1">Bedrooms</label>
            <input type="number" name="bedroom_configs[{{ $index }}][bedroom_count]"
                   value="{{ $config['bedroom_count'] ?? '' }}"
                   class="input-field text-sm py-2" min="1" max="20" required>
        </div>
        <div>
            <label class="block text-xs text-gray-600 mb-1">Price per Night (USD)</label>
            <input type="number" name="bedroom_configs[{{ $index }}][price_per_night]"
                   value="{{ $config['price_per_night'] ?? '' }}"
                   class="input-field text-sm py-2" step="0.01" required>
        </div>
        <div>
            <label class="block text-xs text-gray-600 mb-1">Min Nights</label>
            <input type="number" name="bedroom_configs[{{ $index }}][min_nights]"
                   value="{{ $config['min_nights'] ?? 1 }}"
                   class="input-field text-sm py-2" required>
        </div>
        <div class="flex items-end">
            <label class="flex items-center">
                <input type="checkbox" name="bedroom_configs[{{ $index }}][is_active]" value="1"
                       {{ isset($config['is_active']) && $config['is_active'] ? 'checked' : '' }}
                       class="rounded border-gray-300 text-old-money-charcoal">
                <span class="ml-2 text-xs text-gray-600">Active</span>
            </label>
        </div>
    </div>
</div>
