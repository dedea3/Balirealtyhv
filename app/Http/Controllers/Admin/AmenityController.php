<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\AmenityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::with('category')
            ->latest()
            ->paginate(20);
        
        $categories = AmenityCategory::all();
        
        return view('admin.amenities.index', compact('amenities', 'categories'));
    }

    public function create()
    {
        $categories = AmenityCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.amenities.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amenity_category_id' => 'required|exists:amenity_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_class' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        Amenity::create($validated);

        return redirect()->route('admin.amenities.index')
            ->with('success', 'Amenity created successfully.');
    }

    public function edit(Amenity $amenity)
    {
        $categories = AmenityCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.amenities.edit', compact('amenity', 'categories'));
    }

    public function update(Request $request, Amenity $amenity)
    {
        $validated = $request->validate([
            'amenity_category_id' => 'required|exists:amenity_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_class' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $amenity->update($validated);

        return redirect()->route('admin.amenities.index')
            ->with('success', 'Amenity updated successfully.');
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();
        
        return redirect()->route('admin.amenities.index')
            ->with('success', 'Amenity deleted successfully.');
    }
}
