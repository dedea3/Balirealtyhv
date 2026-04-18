<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seasons = [
            [
                'name' => 'Low Season',
                'slug' => 'low',
                'start_date' => '2026-01-10',
                'end_date' => '2026-03-31',
                'description' => 'Best value period with lower rates',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Shoulder Season',
                'slug' => 'shoulder',
                'start_date' => '2026-04-01',
                'end_date' => '2026-06-30',
                'description' => 'Moderate rates with pleasant weather',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'High Season',
                'slug' => 'high',
                'start_date' => '2026-07-01',
                'end_date' => '2026-08-31',
                'description' => 'Peak summer period with premium rates',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Peak Season',
                'slug' => 'peak',
                'start_date' => '2026-12-20',
                'end_date' => '2027-01-05',
                'description' => 'Holiday period with highest rates',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($seasons as $season) {
            Season::firstOrCreate(['slug' => $season['slug']], $season);
        }
    }
}
