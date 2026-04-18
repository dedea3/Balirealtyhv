<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Villa;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $query = Villa::published()
            ->with(['area', 'heroImage', 'rates', 'bedroomConfigs']);

        // Filter by area
        if ($request->filled('area')) {
            $query->whereHas('area', function ($q) use ($request) {
                $q->where('slug', $request->area);
            });
        }

        // Filter by bedrooms - check both main bedrooms and bedroom configs
        if ($request->filled('bedrooms')) {
            $bedroomCount = (int) $request->bedrooms;
            $query->where(function ($q) use ($bedroomCount) {
                $q->where('bedrooms', '>=', $bedroomCount)
                  ->orWhereHas('bedroomConfigs', function ($q2) use ($bedroomCount) {
                      $q2->where('bedroom_count', $bedroomCount)
                         ->where('is_active', true);
                  });
            });
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->whereHas('rates', function ($q) use ($request) {
                $q->where('price_per_night', '>=', $request->min_price);
            });
        }
        if ($request->filled('max_price')) {
            $query->whereHas('rates', function ($q) use ($request) {
                $q->where('price_per_night', '<=', $request->max_price);
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'featured');
        switch ($sortBy) {
            case 'price_low':
                $query->join('villa_rates', 'villas.id', '=', 'villa_rates.villa_id')
                      ->orderBy('villa_rates.price_per_night', 'asc');
                break;
            case 'price_high':
                $query->join('villa_rates', 'villas.id', '=', 'villa_rates.villa_id')
                      ->orderBy('villa_rates.price_per_night', 'desc');
                break;
            case 'bedrooms':
                $query->orderBy('bedrooms', 'desc');
                break;
            default:
                $query->orderBy('is_featured', 'desc')->orderBy('sort_order');
        }

        $villas = $query->paginate(12)->withQueryString();
        $areas = Area::where('is_active', true)->orderBy('name')->get();

        return view('frontend.areas.index', compact('villas', 'areas'));
    }

    public function show(Area $area, Request $request)
    {
        $villas = Villa::published()
            ->where('area_id', $area->id)
            ->with(['area', 'heroImage', 'rates'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('sort_order')
            ->paginate(12);

        return view('frontend.areas.show', compact('area', 'villas'));
    }
}
