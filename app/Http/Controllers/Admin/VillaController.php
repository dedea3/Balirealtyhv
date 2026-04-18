<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Villa;
use App\Models\Amenity;
use App\Models\VillaRate;
use App\Models\VillaBedroomConfig;
use App\Models\Photo;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VillaController extends Controller
{
    public function index(Request $request)
    {
        $villas = Villa::with('area')
            ->when($request->search, function($query) use ($request) {
                return $query->where('name', 'LIKE', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();
        
        return view('admin.villas.index', compact('villas'));
    }

    public function create()
    {
        $areas = Area::where('is_active', true)->orderBy('name')->get();
        $amenities = Amenity::where('is_active', true)->with('category')->get();
        $seasons = Season::where('is_active', true)->orderBy('sort_order')->get();
        
        return view('admin.villas.create', compact('areas', 'amenities', 'seasons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_id' => 'required|exists:areas,id',
            'name' => 'required|string|max:255',
            'overview' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'max_guests' => 'required|integer|min:1',
            'property_size_sqm' => 'nullable|integer',
            'property_size_unit' => 'nullable|string|max:10',
            'ical_url' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'has_flexible_config' => 'boolean',
            'location' => 'nullable|array',
            'amenities' => 'nullable|array',
            'rates' => 'nullable|array',
            'bedroom_configs' => 'nullable|array',
            'bedroom_configs.*.bedroom_count' => 'required_with:bedroom_configs|integer|min:1|max:20',
            'bedroom_configs.*.price_per_night' => 'required_with:bedroom_configs|numeric|min:0',
            'bedroom_configs.*.min_nights' => 'integer|min:1',
            'bedroom_configs.*.is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['has_flexible_config'] = $request->has('has_flexible_config');
        $validated['location'] = $request->has('location') ? json_encode($request->location) : null;

        $villa = Villa::create($validated);

        // Sync amenities
        if ($request->has('amenities')) {
            $villa->amenities()->sync($request->amenities);
        }

        // Create rates for each season
        if ($request->has('rates')) {
            foreach ($request->rates as $seasonId => $rateData) {
                if (isset($rateData['price_per_night'])) {
                    VillaRate::create([
                        'villa_id' => $villa->id,
                        'season_id' => $seasonId,
                        'price_per_night' => $rateData['price_per_night'],
                        'currency' => $rateData['currency'] ?? 'USD',
                        'minimum_nights' => $rateData['minimum_nights'] ?? 1,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Create bedroom configurations
        if ($request->has('bedroom_configs') && $request->has('has_flexible_config')) {
            foreach ($request->bedroom_configs as $index => $config) {
                if (isset($config['bedroom_count']) && isset($config['price_per_night'])) {
                    VillaBedroomConfig::create([
                        'villa_id' => $villa->id,
                        'bedroom_count' => $config['bedroom_count'],
                        'price_per_night' => $config['price_per_night'],
                        'min_nights' => $config['min_nights'] ?? 1,
                        'currency' => 'USD',
                        'is_active' => isset($config['is_active']) && $config['is_active'],
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.villas.index')
            ->with('success', 'Villa created successfully.');
    }

    public function show(Villa $villa)
    {
        $villa->load(['area', 'amenities.category', 'rates.season', 'photos', 'bedroomConfigs']);
        return view('admin.villas.show', compact('villa'));
    }

    public function edit(Villa $villa)
    {
        $areas = Area::where('is_active', true)->orderBy('name')->get();
        $amenities = Amenity::where('is_active', true)->with('category')->get();
        $seasons = Season::where('is_active', true)->orderBy('sort_order')->get();

        $villa->load(['amenities', 'rates', 'bedroomConfigs']);

        return view('admin.villas.edit', compact('villa', 'areas', 'amenities', 'seasons'));
    }

    public function update(Request $request, Villa $villa)
    {
        $validated = $request->validate([
            'area_id' => 'required|exists:areas,id',
            'name' => 'required|string|max:255',
            'overview' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'max_guests' => 'required|integer|min:1',
            'property_size_sqm' => 'nullable|integer',
            'property_size_unit' => 'nullable|string|max:10',
            'ical_url' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'has_flexible_config' => 'boolean',
            'location' => 'nullable|array',
            'amenities' => 'nullable|array',
            'bedroom_configs' => 'nullable|array',
            'bedroom_configs.*.bedroom_count' => 'required_with:bedroom_configs|integer|min:1|max:20',
            'bedroom_configs.*.price_per_night' => 'required_with:bedroom_configs|numeric|min:0',
            'bedroom_configs.*.min_nights' => 'integer|min:1',
            'bedroom_configs.*.is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['has_flexible_config'] = $request->has('has_flexible_config');
        $validated['location'] = $request->has('location') ? json_encode($request->location) : null;

        $villa->update($validated);

        // Sync amenities
        if ($request->has('amenities')) {
            $villa->amenities()->sync($request->amenities);
        } else {
            $villa->amenities()->detach();
        }

        // Update bedroom configurations
        if ($request->has('bedroom_configs') && $request->has('has_flexible_config')) {
            // Delete existing configs
            $villa->bedroomConfigs()->delete();

            // Create new configs
            foreach ($request->bedroom_configs as $index => $config) {
                if (isset($config['bedroom_count']) && isset($config['price_per_night'])) {
                    VillaBedroomConfig::create([
                        'villa_id' => $villa->id,
                        'bedroom_count' => $config['bedroom_count'],
                        'price_per_night' => $config['price_per_night'],
                        'min_nights' => $config['min_nights'] ?? 1,
                        'currency' => 'USD',
                        'is_active' => isset($config['is_active']) && $config['is_active'],
                        'sort_order' => $index,
                    ]);
                }
            }
        } elseif (!$request->has('has_flexible_config')) {
            // Remove configs if flexible config is disabled
            $villa->bedroomConfigs()->delete();
        }

        return redirect()->route('admin.villas.index')
            ->with('success', 'Villa updated successfully.');
    }

    public function destroy(Villa $villa)
    {
        $villa->delete();
        
        return redirect()->route('admin.villas.index')
            ->with('success', 'Villa deleted successfully.');
    }

    public function updateRates(Request $request, Villa $villa)
    {
        $validated = $request->validate([
            'rates' => 'required|array',
            'rates.*.price_per_night' => 'required|numeric|min:0',
            'rates.*.currency' => 'string|max:3',
            'rates.*.minimum_nights' => 'integer|min:1',
        ]);

        foreach ($validated['rates'] as $seasonId => $rateData) {
            $villaRate = VillaRate::firstOrCreate([
                'villa_id' => $villa->id,
                'season_id' => $seasonId,
            ]);
            
            $villaRate->update([
                'price_per_night' => $rateData['price_per_night'],
                'currency' => $rateData['currency'] ?? 'USD',
                'minimum_nights' => $rateData['minimum_nights'] ?? 1,
                'is_active' => true,
            ]);
        }

        return back()->with('success', 'Rates updated successfully.');
    }

    public function uploadPhotos(Request $request, Villa $villa)
    {
        $validated = $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|max:5120', // 5MB max
            'category' => 'required|in:hero,gallery',
        ]);

        foreach ($validated['photos'] as $photo) {
            $path = $photo->store('villas/' . $villa->id, 'public');
            
            Photo::create([
                'villa_id' => $villa->id,
                'path' => $path,
                'filename' => basename($path),
                'original_filename' => $photo->getClientOriginalName(),
                'category' => $validated['category'],
                'sort_order' => Photo::where('villa_id', $villa->id)->max('sort_order') + 1,
                'file_size' => $photo->getSize(),
                'mime_type' => $photo->getMimeType(),
            ]);
        }

        return back()->with('success', 'Photos uploaded successfully.');
    }

    public function setPrimaryPhoto(Photo $photo)
    {
        // Unset any existing primary photo for this villa
        Photo::where('villa_id', $photo->villa_id)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);
            
        // Set this photo as primary
        $photo->update([
            'is_primary' => true,
            'category' => 'hero' // Ensure it's in the hero category if it wasn't
        ]);
        
        return back()->with('success', 'Hero photo updated successfully.');
    }

    public function deletePhoto(Photo $photo)
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();
        
        return back()->with('success', 'Photo deleted successfully.');
    }

    public function bulkDeletePhotos(Request $request)
    {
        $request->validate([
            'photo_ids' => 'required|array',
            'photo_ids.*' => 'exists:photos,id'
        ]);

        $photos = Photo::whereIn('id', $request->photo_ids)->get();

        foreach ($photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        return back()->with('success', count($photos) . ' photos deleted successfully.');
    }
}
