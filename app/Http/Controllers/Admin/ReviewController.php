<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Villa;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('villa')
            ->latest()
            ->paginate(20);
        
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $villas = Villa::published()->orderBy('name')->get();
        return view('admin.reviews.create', compact('villas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'villa_id' => 'required|exists:villas,id',
            'guest_name' => 'required|string|max:255',
            'country' => 'nullable|string|max:100',
            'guest_type' => 'nullable|string|in:Family,Couple,Group,Solo',
            'stay_date' => 'nullable|date',
            'review_text' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');

        Review::create($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
    }

    public function edit(Review $review)
    {
        $villas = Villa::published()->orderBy('name')->get();
        return view('admin.reviews.edit', compact('review', 'villas'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'villa_id' => 'required|exists:villas,id',
            'guest_name' => 'required|string|max:255',
            'country' => 'nullable|string|max:100',
            'guest_type' => 'nullable|string|in:Family,Couple,Group,Solo',
            'stay_date' => 'nullable|date',
            'review_text' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    public function togglePublish(Review $review)
    {
        $review->update(['is_published' => !$review->is_published]);
        
        return back()->with('success', 'Review publish status updated.');
    }

    public function respond(Request $request, Review $review)
    {
        $validated = $request->validate([
            'response_text' => 'required|string',
        ]);

        $review->respond($validated['response_text']);

        return back()->with('success', 'Response added successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
