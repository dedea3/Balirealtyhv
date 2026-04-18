<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use App\Models\Inquiry;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_villas' => Villa::count(),
            'published_villas' => Villa::where('status', 'published')->count(),
            'draft_villas' => Villa::where('status', 'draft')->count(),
            'new_inquiries' => Inquiry::where('status', 'new')->count(),
            'total_inquiries' => Inquiry::count(),
            'published_reviews' => Review::where('is_published', true)->count(),
        ];

        $recentInquiries = Inquiry::with('villa')
            ->latest()
            ->take(10)
            ->get();

        $villasNeedingAttention = Villa::where('status', 'draft')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recentInquiries', 'villasNeedingAttention'));
    }
}
