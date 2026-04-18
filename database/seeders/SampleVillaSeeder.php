<?php

namespace Database\Seeders;

use App\Models\Villa;
use App\Models\Area;
use App\Models\Amenity;
use App\Models\VillaRate;
use App\Models\VillaBedroomConfig;
use App\Models\Photo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleVillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = Area::all()->keyBy('id');
        $amenities = Amenity::all();

        $villas = [
            [
                'name' => 'Villa Serenity Canggu',
                'area_id' => $areas->firstWhere('slug', 'canggu')->id,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'max_guests' => 6,
                'property_size_sqm' => 450,
                'overview' => 'A tranquil 3-bedroom villa nestled in the heart of Canggu. Villa Serenity offers a perfect escape with its tropical garden, private pool, and modern Balinese architecture. Just minutes from the beach and trendy cafes.',
                'short_description' => 'Peaceful 3BR villa with tropical garden near Canggu beach.',
                'has_flexible_config' => false,
                'bedroom_configs' => [],
                'amenities' => ['private-pool', 'wifi', 'air-conditioning', 'smart-tv', 'fully-equipped-kitchen', 'outdoor-dining-area', 'garden', 'parking', 'daily-housekeeping', 'concierge-service', 'airport-transfer', 'welcome-drink'],
                'hero_image' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1580587771525-78b9dba3b91d?w=800&q=80',
                    'https://images.unsplash.com/photo-1584622050111-993a426fbf0a?w=800&q=80',
                    'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?w=800&q=80',
                ],
            ],
            [
                'name' => 'Villa Royale Seminyak',
                'area_id' => $areas->firstWhere('slug', 'seminyak')->id,
                'bedrooms' => 5,
                'bathrooms' => 6,
                'max_guests' => 12,
                'property_size_sqm' => 850,
                'overview' => 'An opulent 5-bedroom estate in prestigious Seminyak. Villa Royale features soaring ceilings, marble floors, a 20-meter infinity pool, and impeccable service. Perfect for luxury seekers and large families.',
                'short_description' => 'Luxury 5BR estate with infinity pool in central Seminyak.',
                'has_flexible_config' => true,
                'bedroom_configs' => [
                    ['bedroom_count' => 3, 'price' => 550, 'min_nights' => 2],
                    ['bedroom_count' => 4, 'price' => 750, 'min_nights' => 2],
                    ['bedroom_count' => 5, 'price' => 950, 'min_nights' => 3],
                ],
                'amenities' => ['private-pool', 'infinity-pool', 'wifi', 'air-conditioning', 'smart-tv', 'home-theater', 'gym', 'fully-equipped-kitchen', 'outdoor-dining-area', 'bbq-facilities', 'garden', 'parking', '24-7-butler', 'daily-housekeeping', 'private-chef', 'concierge-service', 'airport-transfer', 'security'],
                'hero_image' => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&q=80',
                    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&q=80',
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80',
                ],
            ],
            [
                'name' => 'Jungle Haven Ubud',
                'area_id' => $areas->firstWhere('slug', 'ubud')->id,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'max_guests' => 4,
                'property_size_sqm' => 320,
                'overview' => 'A romantic 2-bedroom jungle retreat overlooking Ayung River. Jungle Haven offers complete privacy, stunning rainforest views, and an infinity pool that seems to merge with the jungle canopy.',
                'short_description' => 'Romantic 2BR jungle villa with rainforest views in Ubud.',
                'has_flexible_config' => false,
                'bedroom_configs' => [],
                'amenities' => ['private-pool', 'infinity-pool', 'wifi', 'air-conditioning', 'outdoor-dining-area', 'rice-field-view', 'daily-housekeeping', 'concierge-service', 'in-villa-massage', 'tour-arrangements', 'welcome-drink', 'complimentary-breakfast', 'bicycle-rental'],
                'hero_image' => 'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?w=800&q=80',
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80',
                    'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=800&q=80',
                ],
            ],
            [
                'name' => 'Cliff Paradise Uluwatu',
                'area_id' => $areas->firstWhere('slug', 'uluwatu')->id,
                'bedrooms' => 4,
                'bathrooms' => 5,
                'max_guests' => 10,
                'property_size_sqm' => 720,
                'overview' => 'Perched on Uluwatu\'s dramatic cliffs, this 4-bedroom masterpiece offers breathtaking ocean views, direct beach access, and world-class amenities. Watch surfers below while enjoying your morning coffee.',
                'short_description' => 'Clifftop 4BR villa with ocean views and beach access.',
                'has_flexible_config' => true,
                'bedroom_configs' => [
                    ['bedroom_count' => 3, 'price' => 800, 'min_nights' => 3],
                    ['bedroom_count' => 4, 'price' => 1100, 'min_nights' => 3],
                ],
                'amenities' => ['private-pool', 'infinity-pool', 'wifi', 'air-conditioning', 'smart-tv', 'home-theater', 'gym', 'spa-room', 'fully-equipped-kitchen', 'outdoor-dining-area', 'terrace-balcony', 'ocean-view', 'beach-access', '24-7-butler', 'daily-housekeeping', 'private-chef', 'concierge-service', 'airport-transfer', 'driver-service', 'security'],
                'hero_image' => 'https://images.unsplash.com/photo-1602343168117-bb8ffe3e2e9f?w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1601918774757-6e5aa134f9d3?w=800&q=80',
                    'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800&q=80',
                    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=800&q=80',
                    'https://images.unsplash.com/photo-1600585154363-67eb9e2e2099?w=800&q=80',
                ],
            ],
            [
                'name' => 'Beach House Sanur',
                'area_id' => $areas->firstWhere('slug', 'sanur')->id,
                'bedrooms' => 4,
                'bathrooms' => 4,
                'max_guests' => 8,
                'property_size_sqm' => 550,
                'overview' => 'A charming 4-bedroom beachfront villa on Sanur\'s calm shores. Perfect for families, this villa offers direct beach access, a kids\' pool, and spacious living areas with traditional Balinese touches.',
                'short_description' => 'Family-friendly 4BR beachfront villa on Sanur beach.',
                'has_flexible_config' => false,
                'bedroom_configs' => [],
                'amenities' => ['private-pool', 'wifi', 'air-conditioning', 'smart-tv', 'fully-equipped-kitchen', 'outdoor-dining-area', 'bbq-facilities', 'garden', 'terrace-balcony', 'parking', 'beach-access', 'daily-housekeeping', 'concierge-service', 'airport-transfer', 'babysitting', 'bicycle-rental', 'welcome-drink'],
                'hero_image' => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1600585152220-90363fe7e115?w=800&q=80',
                    'https://images.unsplash.com/photo-1600585153490-76fb20a32601?w=800&q=80',
                    'https://images.unsplash.com/photo-1600585154084-2bb0e4a5a2e5?w=800&q=80',
                ],
            ],
            [
                'name' => 'Rice Terrace Villa Ubud',
                'area_id' => $areas->firstWhere('slug', 'ubud')->id,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'max_guests' => 6,
                'property_size_sqm' => 480,
                'overview' => 'Overlooking Tegalalang\'s famous rice terraces, this 3-bedroom villa blends traditional Balinese architecture with modern comfort. Wake up to farmers tending their fields and enjoy sunset views from your private bale.',
                'short_description' => 'Traditional 3BR villa overlooking Tegalalang rice terraces.',
                'has_flexible_config' => true,
                'bedroom_configs' => [
                    ['bedroom_count' => 2, 'price' => 280, 'min_nights' => 2],
                    ['bedroom_count' => 3, 'price' => 380, 'min_nights' => 2],
                ],
                'amenities' => ['private-pool', 'wifi', 'air-conditioning', 'outdoor-dining-area', 'rice-field-view', 'garden', 'terrace-balcony', 'daily-housekeeping', 'concierge-service', 'in-villa-massage', 'tour-arrangements', 'yoga-sessions', 'welcome-drink', 'complimentary-breakfast', 'bicycle-rental'],
                'hero_image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80',
                    'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=800&q=80',
                    'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80',
                ],
            ],
            [
                'name' => 'Ocean Dream Nusa Dua',
                'area_id' => $areas->firstWhere('slug', 'nusa-dua')->id,
                'bedrooms' => 6,
                'bathrooms' => 7,
                'max_guests' => 14,
                'property_size_sqm' => 1200,
                'overview' => 'A palatial 6-bedroom oceanfront estate in Nusa Dua\'s exclusive enclave. Features include formal living/dining, home theater, gym, spa, staff quarters, and 30 meters of private beach frontage.',
                'short_description' => 'Palatial 6BR oceanfront estate in exclusive Nusa Dua.',
                'has_flexible_config' => true,
                'bedroom_configs' => [
                    ['bedroom_count' => 4, 'price' => 1500, 'min_nights' => 3],
                    ['bedroom_count' => 5, 'price' => 2000, 'min_nights' => 3],
                    ['bedroom_count' => 6, 'price' => 2500, 'min_nights' => 5],
                ],
                'amenities' => ['private-pool', 'infinity-pool', 'wifi', 'air-conditioning', 'smart-tv', 'home-theater', 'gym', 'spa-room', 'game-room', 'fully-equipped-kitchen', 'outdoor-dining-area', 'bbq-facilities', 'garden', 'terrace-balcony', 'safe-deposit-box', 'parking', 'ocean-view', 'beach-access', '24-7-butler', 'daily-housekeeping', 'private-chef', 'concierge-service', 'airport-transfer', 'driver-service', 'laundry-service', 'babysitting', 'security', 'gardener'],
                'hero_image' => 'https://images.unsplash.com/photo-1613545325278-f24b0cae1224?w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&q=80',
                    'https://images.unsplash.com/photo-1613977257363-707ba9348227?w=800&q=80',
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&q=80',
                    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&q=80',
                ],
            ],
            [
                'name' => 'Surf Lodge Canggu',
                'area_id' => $areas->firstWhere('slug', 'canggu')->id,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'max_guests' => 4,
                'property_size_sqm' => 280,
                'overview' => 'A trendy 2-bedroom lodge steps from Echo Beach. Surf Lodge features industrial-chic design, a rooftop deck, and is surrounded by Canggu\'s best surf breaks, cafes, and nightlife.',
                'short_description' => 'Trendy 2BR lodge near Echo Beach, perfect for surfers.',
                'has_flexible_config' => false,
                'bedroom_configs' => [],
                'amenities' => ['private-pool', 'wifi', 'air-conditioning', 'smart-tv', 'outdoor-dining-area', 'terrace-balcony', 'parking', 'beach-access', 'daily-housekeeping', 'bicycle-rental', 'welcome-drink'],
                'hero_image' => 'https://images.unsplash.com/photo-1523217582562-09d0def993a6?w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800&q=80',
                    'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80',
                    'https://images.unsplash.com/photo-1484154218962-a1c002085d2f?w=800&q=80',
                ],
            ],
            [
                'name' => 'Tropical Retreat Kerobokan',
                'area_id' => $areas->firstWhere('slug', 'kerobokan')->id,
                'bedrooms' => 5,
                'bathrooms' => 5,
                'max_guests' => 10,
                'property_size_sqm' => 780,
                'overview' => 'A lush 5-bedroom villa hidden in Kerobokan\'s tropical gardens. This peaceful retreat features traditional joglo pavilions, a large pool, and is just 10 minutes from Seminyak\'s beaches and restaurants.',
                'short_description' => 'Peaceful 5BR villa in tropical gardens near Seminyak.',
                'has_flexible_config' => true,
                'bedroom_configs' => [
                    ['bedroom_count' => 3, 'price' => 420, 'min_nights' => 2],
                    ['bedroom_count' => 4, 'price' => 550, 'min_nights' => 2],
                    ['bedroom_count' => 5, 'price' => 680, 'min_nights' => 3],
                ],
                'amenities' => ['private-pool', 'wifi', 'air-conditioning', 'smart-tv', 'fully-equipped-kitchen', 'outdoor-dining-area', 'bbq-facilities', 'garden', 'parking', '24-7-butler', 'daily-housekeeping', 'concierge-service', 'airport-transfer', 'laundry-service', 'security', 'gardener', 'welcome-drink'],
                'hero_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=800&q=80',
                    'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=800&q=80',
                    'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?w=800&q=80',
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80',
                ],
            ],
            [
                'name' => 'Penthouse Suite Seminyak',
                'area_id' => $areas->firstWhere('slug', 'seminyak')->id,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'max_guests' => 2,
                'property_size_sqm' => 120,
                'overview' => 'A sophisticated 1-bedroom penthouse in the heart of Seminyak. Perfect for couples, this rooftop retreat features a private plunge pool, outdoor shower, and panoramic views of the Indian Ocean.',
                'short_description' => 'Romantic 1BR penthouse with private pool and ocean views.',
                'has_flexible_config' => false,
                'bedroom_configs' => [],
                'amenities' => ['private-pool', 'wifi', 'air-conditioning', 'smart-tv', 'terrace-balcony', 'ocean-view', 'daily-housekeeping', 'concierge-service', 'in-villa-massage', 'welcome-drink', 'complimentary-breakfast', 'minibar'],
                'hero_image' => 'https://images.unsplash.com/photo-1570213489059-0aac6626cade?w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?w=800&q=80',
                    'https://images.unsplash.com/photo-1584622050111-993a426fbf0a?w=800&q=80',
                    'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?w=800&q=80',
                ],
            ],
        ];

        foreach ($villas as $villaData) {
            $bedroomConfigs = $villaData['bedroom_configs'] ?? [];
            $amenitySlugs = $villaData['amenities'] ?? [];
            $heroImage = $villaData['hero_image'] ?? null;
            $galleryImages = $villaData['gallery_images'] ?? [];

            unset($villaData['bedroom_configs'], $villaData['amenities'], $villaData['hero_image'], $villaData['gallery_images']);

            $villaData['slug'] = Str::slug($villaData['name']);
            $villaData['status'] = 'published';
            $villaData['is_featured'] = in_array($villaData['name'], [
                'Villa Royale Seminyak',
                'Cliff Paradise Uluwatu',
                'Ocean Dream Nusa Dua',
            ]);

            $villa = Villa::create($villaData);

            // Sync amenities
            $amenityIds = $amenities->whereIn('slug', $amenitySlugs)->pluck('id')->toArray();
            $villa->amenities()->sync($amenityIds);

            // Create bedroom configs
            foreach ($bedroomConfigs as $config) {
                VillaBedroomConfig::create([
                    'villa_id' => $villa->id,
                    'bedroom_count' => $config['bedroom_count'],
                    'price_per_night' => $config['price'],
                    'min_nights' => $config['min_nights'],
                    'currency' => 'USD',
                    'is_active' => true,
                    'sort_order' => $config['bedroom_count'],
                ]);
            }

            // Create seasonal rates
            $seasons = \App\Models\Season::all();
            $basePrice = $bedroomConfigs[0]['price'] ?? 350;

            foreach ($seasons as $season) {
                $multiplier = match($season->slug) {
                    'low' => 1,
                    'shoulder' => 1.2,
                    'high' => 1.5,
                    'peak' => 2,
                    default => 1,
                };

                VillaRate::create([
                    'villa_id' => $villa->id,
                    'season_id' => $season->id,
                    'price_per_night' => $basePrice * $multiplier,
                    'currency' => 'USD',
                    'minimum_nights' => 2,
                    'is_active' => true,
                ]);
            }

            // Create photos (hero + gallery)
            if ($heroImage) {
                Photo::create([
                    'villa_id' => $villa->id,
                    'path' => $heroImage,
                    'filename' => basename($heroImage),
                    'category' => 'hero',
                    'is_primary' => true,
                    'sort_order' => 0,
                    'alt_text' => $villa->name . ' - Hero Image',
                ]);
            }

            foreach ($galleryImages as $index => $imageUrl) {
                Photo::create([
                    'villa_id' => $villa->id,
                    'path' => $imageUrl,
                    'filename' => basename($imageUrl),
                    'category' => 'gallery',
                    'is_primary' => false,
                    'sort_order' => $index + 1,
                    'alt_text' => $villa->name . ' - Gallery Image ' . ($index + 1),
                ]);
            }

            $this->command->info("✓ Created villa: {$villa->name}");
        }

        $this->command->info('');
        $this->command->info('Sample villa seeding completed!');
        $this->command->info('Total villas created: ' . count($villas));
    }
}
