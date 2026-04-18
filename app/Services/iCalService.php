<?php

namespace App\Services;

use App\Models\Villa;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class iCalService
{
    /**
     * Import events from external iCal URL
     */
    public function importFromUrl(string $icalUrl): array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'BaliRealtyHV/1.0',
            ])->get($icalUrl);

            if (!$response->successful()) {
                return ['success' => false, 'message' => 'Failed to fetch iCal URL'];
            }

            $events = $this->parseICal($response->body());
            
            return [
                'success' => true,
                'events' => $events,
                'count' => count($events),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error importing iCal: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Parse iCal content and extract events
     */
    private function parseICal(string $content): array
    {
        $events = [];
        $lines = explode("\n", $content);
        $currentEvent = null;
        $inEvent = false;

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === 'BEGIN:VEVENT') {
                $inEvent = true;
                $currentEvent = [];
                continue;
            }

            if ($line === 'END:VEVENT') {
                if ($currentEvent && isset($currentEvent['DTSTART']) && isset($currentEvent['DTEND'])) {
                    $events[] = [
                        'start' => $this->parseICalDate($currentEvent['DTSTART']),
                        'end' => $this->parseICalDate($currentEvent['DTEND']),
                        'summary' => $currentEvent['SUMMARY'] ?? 'Unavailable',
                        'uid' => $currentEvent['UID'] ?? null,
                    ];
                }
                $inEvent = false;
                $currentEvent = null;
                continue;
            }

            if ($inEvent && $currentEvent !== null && strpos($line, ':') !== false) {
                [$key, $value] = explode(':', $line, 2);
                $currentEvent[$key] = $value;
            }
        }

        return $events;
    }

    /**
     * Parse iCal date format
     */
    private function parseICalDate(string $dateString): ?\Carbon\Carbon
    {
        try {
            // Remove 'T' and 'Z' if present
            $dateString = str_replace(['T', 'Z'], [' ', ''], $dateString);
            
            // Handle timezone
            if (strpos($dateString, 'TZID=') !== false) {
                preg_match('/TZID=([^:]+):(.+)/', $dateString, $matches);
                if (count($matches) === 3) {
                    $dateString = $matches[2];
                }
            }

            return \Carbon\Carbon::parse($dateString);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Generate iCal export content for a villa
     */
    public function generateICal(Villa $villa): string
    {
        $ical = "BEGIN:VCALENDAR\r\n";
        $ical .= "VERSION:2.0\r\n";
        $ical .= "PRODID:-//Bali Realty Holidays//Villa Calendar//EN\r\n";
        $ical .= "CALSCALE:GREGORIAN\r\n";
        $ical .= "METHOD:PUBLISH\r\n";
        $ical .= "X-WR-CALNAME:{$villa->name}\r\n";

        // Add unavailable dates from rates as example events
        // In production, you would add actual booking data
        $ical .= "END:VCALENDAR";

        return $ical;
    }

    /**
     * Export iCal file for a villa
     */
    public function exportICal(Villa $villa): string
    {
        $content = $this->generateICal($villa);
        
        $filename = 'ical/' . $villa->slug . '-calendar.ics';
        Storage::disk('public')->put($filename, $content);

        return Storage::disk('public')->url($filename);
    }

    /**
     * Sync external calendar with villa
     */
    public function syncVillaCalendar(Villa $villa): array
    {
        if (!$villa->ical_url) {
            return [
                'success' => false,
                'message' => 'No iCal URL configured for this villa',
            ];
        }

        $result = $this->importFromUrl($villa->ical_url);

        if ($result['success']) {
            // Store sync timestamp
            $villa->update([
                // You could add a last_synced_at column to track this
            ]);

            return [
                'success' => true,
                'message' => "Successfully imported {$result['count']} events",
                'events' => $result['events'],
            ];
        }

        return $result;
    }
}
