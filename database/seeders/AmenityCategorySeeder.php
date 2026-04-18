<?php

namespace Database\Seeders;

use App\Models\AmenityCategory;
use Illuminate\Database\Seeder;

class AmenityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Facilities',
                'slug' => 'facilities',
                'description' => 'Physical infrastructure and amenities available at the villa',
                'icon_class' => 'fas fa-building',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Services',
                'slug' => 'services',
                'description' => 'Staff and human-touch services provided during your stay',
                'icon_class' => 'fas fa-concierge-bell',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Inclusions',
                'slug' => 'inclusions',
                'description' => 'Complimentary items and services included in your stay',
                'icon_class' => 'fas fa-gift',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            AmenityCategory::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
