<?php

namespace App\Console\Commands;

use App\Models\Villa;
use App\Services\iCalService;
use Illuminate\Console\Command;

class SyncICalCalendars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ical:sync-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all villa calendars with external iCal URLs (Airbnb, Booking.com, etc.)';

    protected $iCalService;

    /**
     * Create a new command instance.
     */
    public function __construct(iCalService $iCalService)
    {
        parent::__construct();
        $this->iCalService = $iCalService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting iCal calendar sync...');

        $villas = Villa::whereNotNull('ical_url')
            ->where('status', 'published')
            ->get();

        $this->info("Found {$villas->count()} villas with iCal URLs");

        $successCount = 0;
        $failCount = 0;

        foreach ($villas as $villa) {
            $this->line("Syncing: {$villa->name}");

            $result = $this->iCalService->syncVillaCalendar($villa);

            if ($result['success']) {
                $this->info("  ✓ Success: {$result['message']}");
                $successCount++;
            } else {
                $this->error("  ✗ Failed: {$result['message']}");
                $failCount++;
            }
        }

        $this->newLine();
        $this->info("Sync completed!");
        $this->info("Successful: {$successCount} | Failed: {$failCount}");

        return 0;
    }
}
