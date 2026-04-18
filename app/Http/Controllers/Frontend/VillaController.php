<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use App\Models\Inquiry;
use App\Mail\InquiryNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VillaController extends Controller
{
    public function show(Villa $villa, Request $request)
    {
        // Only show published villas
        if ($villa->status !== 'published') {
            abort(404);
        }

        $villa->load([
            'area',
            'amenities.category',
            'rates.season',
            'photos',
            'publishedReviews'
        ]);

        $bookedDates = [];
        if ($villa->ical_url) {
            $bookedDates = $this->getBookedDates($villa->ical_url);
        }

        $relatedVillas = Villa::published()
            ->where('area_id', $villa->area_id)
            ->where('id', '!=', $villa->id)
            ->with(['area', 'heroImage'])
            ->take(4)
            ->get();

        return view('frontend.villas.show', compact('villa', 'relatedVillas', 'bookedDates'));
    }

    private function getBookedDates($url)
    {
        return \Cache::remember("villa_availability_{$url}", 3600, function () use ($url) {
            try {
                $content = file_get_contents($url);
                if (!$content) return [];

                $bookedDates = [];
                // Robust iCal parsing for DTSTART and DTEND
                preg_match_all('/BEGIN:VEVENT.*?DTSTART(?:;[^:]*)?:(\d{8}(?:T\d{6}Z?)?).*?DTEND(?:;[^:]*)?:(\d{8}(?:T\d{6}Z?)?).*?END:VEVENT/s', $content, $matches);

                foreach ($matches[1] as $i => $start) {
                    $startStr = substr($start, 0, 8);
                    $endStr = substr($matches[2][$i], 0, 8);

                    $startDate = \Carbon\Carbon::createFromFormat('Ymd', $startStr);
                    $endDate = \Carbon\Carbon::createFromFormat('Ymd', $endStr);

                    // Add each day of the booking to the list
                    // iCal DTEND is usually the checkout day (exclusive)
                    while ($startDate->lt($endDate)) {
                        $bookedDates[] = $startDate->format('Y-m-d');
                        $startDate->addDay();
                    }
                }
                return array_unique($bookedDates);
            } catch (\Exception $e) {
                \Log::error("iCal parsing failed for {$url}: " . $e->getMessage());
                return [];
            }
        });
    }

    public function inquire(Request $request, Villa $villa)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date|after:check_in',
            'number_of_guests' => 'nullable|integer|min:1',
            'message' => 'nullable|string',
        ]);

        $validated['villa_id'] = $villa->id;
        $validated['ip_address'] = $request->ip();
        $validated['source'] = 'website';

        $inquiry = Inquiry::create($validated);

        // Send email notification to admin
        try {
            Mail::to(config('mail.from.address', 'info@balirealtyhv.com'))
                ->send(new InquiryNotification($inquiry));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send inquiry notification: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you for your inquiry. Our team will contact you shortly.');
    }
}
