<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use App\Services\iCalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class iCalController extends Controller
{
    protected $iCalService;

    public function __construct(iCalService $iCalService)
    {
        $this->iCalService = $iCalService;
    }

    /**
     * Export iCal for a villa
     */
    public function export(Villa $villa)
    {
        $content = $this->iCalService->generateICal($villa);
        
        $filename = $villa->slug . '-calendar.ics';
        
        return Response::make($content, 200, [
            'Content-Type' => 'text/calendar',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Import iCal from URL
     */
    public function import(Request $request)
    {
        $validated = $request->validate([
            'villa_id' => 'required|exists:villas,id',
            'ical_url' => 'required|url',
        ]);

        $villa = Villa::findOrFail($validated['villa_id']);
        
        // Update villa's ical_url
        $villa->update(['ical_url' => $validated['ical_url']]);

        // Import events
        $result = $this->iCalService->importFromUrl($validated['ical_url']);

        if ($result['success']) {
            return back()->with('success', $result['message'] . ' from external calendar.');
        }

        return back()->with('error', $result['message']);
    }

    /**
     * Sync villa calendar
     */
    public function sync(Villa $villa)
    {
        $result = $this->iCalService->syncVillaCalendar($villa);

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
