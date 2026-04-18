<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use App\Models\Area;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredVillas = Villa::published()
            ->featured()
            ->with(['area', 'heroImage'])
            ->take(6)
            ->get();

        $areas = Area::where('is_active', true)
            ->withCount('publishedVillas')
            ->having('published_villas_count', '>', 0)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $testimonials = Review::published()
            ->featured()
            ->with('villa')
            ->take(4)
            ->get();

        $totalVillas = Villa::published()->count();
        $totalAreas = Area::where('is_active', true)->count();

        return view('frontend.home.index', compact(
            'featuredVillas',
            'areas',
            'testimonials',
            'totalVillas',
            'totalAreas'
        ));
    }
}
