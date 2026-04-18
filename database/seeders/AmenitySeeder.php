<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\AmenityCategory;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = AmenityCategory::where('slug', 'facilities')->first();
        $services = AmenityCategory::where('slug', 'services')->first();
        $inclusions = AmenityCategory::where('slug', 'inclusions')->first();

        $amenities = [
            // Facilities
            ['amenity_category_id' => $facilities->id, 'name' => 'Private Pool', 'slug' => 'private-pool', 'icon_class' => 'fas fa-swimming-pool'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Infinity Pool', 'slug' => 'infinity-pool', 'icon_class' => 'fas fa-water'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Air Conditioning', 'slug' => 'air-conditioning', 'icon_class' => 'fas fa-snowflake'],
            ['amenity_category_id' => $facilities->id, 'name' => 'WiFi', 'slug' => 'wifi', 'icon_class' => 'fas fa-wifi'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Smart TV', 'slug' => 'smart-tv', 'icon_class' => 'fas fa-tv'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Home Theater', 'slug' => 'home-theater', 'icon_class' => 'fas fa-film'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Gym', 'slug' => 'gym', 'icon_class' => 'fas fa-dumbbell'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Spa Room', 'slug' => 'spa-room', 'icon_class' => 'fas fa-spa'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Game Room', 'slug' => 'game-room', 'icon_class' => 'fas fa-gamepad'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Fully Equipped Kitchen', 'slug' => 'fully-equipped-kitchen', 'icon_class' => 'fas fa-utensils'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Outdoor Dining Area', 'slug' => 'outdoor-dining-area', 'icon_class' => 'fas fa-umbrella-beach'],
            ['amenity_category_id' => $facilities->id, 'name' => 'BBQ Facilities', 'slug' => 'bbq-facilities', 'icon_class' => 'fas fa-fire'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Garden', 'slug' => 'garden', 'icon_class' => 'fas fa-tree'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Terrace/Balcony', 'slug' => 'terrace-balcony', 'icon_class' => 'fas fa-home'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Safe Deposit Box', 'slug' => 'safe-deposit-box', 'icon_class' => 'fas fa-lock'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Parking', 'slug' => 'parking', 'icon_class' => 'fas fa-car'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Beach Access', 'slug' => 'beach-access', 'icon_class' => 'fas fa-umbrella-beach'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Ocean View', 'slug' => 'ocean-view', 'icon_class' => 'fas fa-water'],
            ['amenity_category_id' => $facilities->id, 'name' => 'Rice Field View', 'slug' => 'rice-field-view', 'icon_class' => 'fas fa-seedling'],

            // Services
            ['amenity_category_id' => $services->id, 'name' => '24/7 Butler', 'slug' => '24-7-butler', 'icon_class' => 'fas fa-user-tie'],
            ['amenity_category_id' => $services->id, 'name' => 'Private Chef', 'slug' => 'private-chef', 'icon_class' => 'fas fa-hat-chef'],
            ['amenity_category_id' => $services->id, 'name' => 'Daily Housekeeping', 'slug' => 'daily-housekeeping', 'icon_class' => 'fas fa-broom'],
            ['amenity_category_id' => $services->id, 'name' => 'Concierge Service', 'slug' => 'concierge-service', 'icon_class' => 'fas fa-concierge-bell'],
            ['amenity_category_id' => $services->id, 'name' => 'Airport Transfer', 'slug' => 'airport-transfer', 'icon_class' => 'fas fa-shuttle-van'],
            ['amenity_category_id' => $services->id, 'name' => 'Laundry Service', 'slug' => 'laundry-service', 'icon_class' => 'fas fa-tshirt'],
            ['amenity_category_id' => $services->id, 'name' => 'In-Villa Massage', 'slug' => 'in-villa-massage', 'icon_class' => 'fas fa-hands'],
            ['amenity_category_id' => $services->id, 'name' => 'Babysitting', 'slug' => 'babysitting', 'icon_class' => 'fas fa-baby'],
            ['amenity_category_id' => $services->id, 'name' => 'Tour Arrangements', 'slug' => 'tour-arrangements', 'icon_class' => 'fas fa-map-marked-alt'],
            ['amenity_category_id' => $services->id, 'name' => 'Driver Service', 'slug' => 'driver-service', 'icon_class' => 'fas fa-car'],
            ['amenity_category_id' => $services->id, 'name' => 'Security', 'slug' => 'security', 'icon_class' => 'fas fa-user-shield'],
            ['amenity_category_id' => $services->id, 'name' => 'Gardener', 'slug' => 'gardener', 'icon_class' => 'fas fa-seedling'],

            // Inclusions
            ['amenity_category_id' => $inclusions->id, 'name' => 'Welcome Drink', 'slug' => 'welcome-drink', 'icon_class' => 'fas fa-cocktail'],
            ['amenity_category_id' => $inclusions->id, 'name' => 'Complimentary Breakfast', 'slug' => 'complimentary-breakfast', 'icon_class' => 'fas fa-coffee'],
            ['amenity_category_id' => $inclusions->id, 'name' => 'Minibar', 'slug' => 'minibar', 'icon_class' => 'fas fa-wine-bottle'],
            ['amenity_category_id' => $inclusions->id, 'name' => 'Toiletries', 'slug' => 'toiletries', 'icon_class' => 'fas fa-soap'],
            ['amenity_category_id' => $inclusions->id, 'name' => 'Bathrobes & Slippers', 'slug' => 'bathrobes-slippers', 'icon_class' => 'fas fa-tshirt'],
            ['amenity_category_id' => $inclusions->id, 'name' => 'Beach Towels', 'slug' => 'beach-towels', 'icon_class' => 'fas fa-towel'],
            ['amenity_category_id' => $inclusions->id, 'name' => 'Sunset Cocktails', 'slug' => 'sunset-cocktails', 'icon_class' => 'fas fa-glass-martini-alt'],
            ['amenity_category_id' => $inclusions->id, 'name' => 'Afternoon Tea', 'slug' => 'afternoon-tea', 'icon_class' => 'fas fa-mug-hot'],
            ['amenity_category_id' => $inclusions->id, 'name' => 'Yoga Sessions', 'slug' => 'yoga-sessions', 'icon_class' => 'fas fa-spa'],
            ['amenity_category_id' => $inclusions->id, 'name' => 'Bicycle Rental', 'slug' => 'bicycle-rental', 'icon_class' => 'fas fa-bicycle'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::firstOrCreate(['slug' => $amenity['slug']], $amenity);
        }
    }
}
