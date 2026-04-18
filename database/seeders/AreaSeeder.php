<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            [
                'name' => 'Canggu',
                'slug' => 'canggu',
                'description' => 'A vibrant coastal area known for its black sand beaches, surf breaks, and trendy cafes.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Seminyak',
                'slug' => 'seminyak',
                'description' => 'An upscale beach resort area with luxury boutiques, fine dining, and sophisticated nightlife.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Uluwatu',
                'slug' => 'uluwatu',
                'description' => 'A clifftop paradise in southern Bali, famous for dramatic ocean views and world-class surf spots.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Ubud',
                'slug' => 'ubud',
                'description' => 'The cultural heart of Bali, surrounded by lush rainforests, rice terraces, and spiritual retreats.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Nusa Dua',
                'slug' => 'nusa-dua',
                'description' => 'A prestigious enclave known for its pristine beaches, golf courses, and luxury resorts.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Sanur',
                'slug' => 'sanur',
                'description' => 'A relaxed beachfront village with a charming promenade and calm waters.',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Jimbaran',
                'slug' => 'jimbaran',
                'description' => 'A fishing village famous for its seafood restaurants and beautiful bay.',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Kerobokan',
                'slug' => 'kerobokan',
                'description' => 'A residential area between Seminyak and Canggu, offering tranquility with easy beach access.',
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($areas as $area) {
            Area::firstOrCreate(['slug' => $area['slug']], $area);
        }
    }
}
