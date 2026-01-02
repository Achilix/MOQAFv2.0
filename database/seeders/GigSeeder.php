<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gig;
use App\Models\Handyman;
use App\Models\Category;

class GigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $handymen = Handyman::all();
        $categories = Category::whereNotNull('parent_id')->get(); // Get subcategories only

        if ($handymen->isEmpty()) {
            $this->command->error('Please run UserSeeder first to create handymen!');
            return;
        }

        if ($categories->isEmpty()) {
            $this->command->error('Please run CategorySeeder first!');
            return;
        }

        $gigs = [
            // Plumbing
            [
                'title' => 'Emergency Plumbing Repair',
                'type' => 'Emergency',
                'description' => 'Fast response for all plumbing emergencies including leaks, burst pipes, and clogged drains. Available 24/7.',
                'category_slug' => 'plumbing',
            ],
            [
                'title' => 'Bathroom & Kitchen Plumbing',
                'type' => 'Installation',
                'description' => 'Professional installation and repair of bathroom and kitchen fixtures, including sinks, faucets, and toilets.',
                'category_slug' => 'plumbing',
            ],
            [
                'title' => 'Water Heater Installation',
                'type' => 'Installation',
                'description' => 'Expert installation and maintenance of water heaters. All brands supported.',
                'category_slug' => 'plumbing',
            ],
            
            // Electrical
            [
                'title' => 'Electrical Wiring & Rewiring',
                'type' => 'Repair',
                'description' => 'Complete electrical wiring services for new constructions and rewiring for old buildings. Licensed electrician.',
                'category_slug' => 'electrical',
            ],
            [
                'title' => 'Light Fixture Installation',
                'type' => 'Installation',
                'description' => 'Install ceiling lights, chandeliers, outdoor lighting, and LED strips. Modern designs available.',
                'category_slug' => 'electrical',
            ],
            [
                'title' => 'Electrical Panel Upgrade',
                'type' => 'Upgrade',
                'description' => 'Upgrade your electrical panel to handle modern appliances safely. Code compliant.',
                'category_slug' => 'electrical',
            ],
            
            // Carpentry
            [
                'title' => 'Custom Cabinet Making',
                'type' => 'Custom Work',
                'description' => 'Design and build custom cabinets for kitchen, bathroom, or any room. High-quality materials.',
                'category_slug' => 'carpentry',
            ],
            [
                'title' => 'Door & Window Installation',
                'type' => 'Installation',
                'description' => 'Professional installation of doors and windows. Wood, aluminum, and PVC materials available.',
                'category_slug' => 'carpentry',
            ],
            [
                'title' => 'Furniture Repair & Restoration',
                'type' => 'Repair',
                'description' => 'Restore old furniture to its former glory. Repair broken chairs, tables, and cabinets.',
                'category_slug' => 'carpentry',
            ],
            
            // Painting
            [
                'title' => 'Interior Painting Service',
                'type' => 'Painting',
                'description' => 'Professional interior painting with premium paints. Clean, fast, and affordable. Free color consultation.',
                'category_slug' => 'painting',
            ],
            [
                'title' => 'Exterior House Painting',
                'type' => 'Painting',
                'description' => 'Weather-resistant exterior painting to protect and beautify your home. All surfaces covered.',
                'category_slug' => 'painting',
            ],
            [
                'title' => 'Decorative Wall Painting',
                'type' => 'Decoration',
                'description' => 'Artistic wall designs, murals, and decorative painting for unique home styling.',
                'category_slug' => 'painting',
            ],
            
            // House Cleaning
            [
                'title' => 'Regular House Cleaning',
                'type' => 'Regular',
                'description' => 'Weekly or bi-weekly house cleaning service. Includes all rooms, kitchen, and bathrooms.',
                'category_slug' => 'house-cleaning',
            ],
            [
                'title' => 'Move-in/Move-out Cleaning',
                'type' => 'Deep Clean',
                'description' => 'Thorough cleaning for moving. Every corner spotless. Perfect for landlords and tenants.',
                'category_slug' => 'house-cleaning',
            ],
            
            // Deep Cleaning
            [
                'title' => 'Deep Kitchen Cleaning',
                'type' => 'Deep Clean',
                'description' => 'Intensive kitchen cleaning including appliances, cabinets, and grease removal.',
                'category_slug' => 'deep-cleaning',
            ],
            [
                'title' => 'Post-Construction Cleaning',
                'type' => 'Specialty',
                'description' => 'Remove construction dust and debris. Make your new space move-in ready.',
                'category_slug' => 'deep-cleaning',
            ],
            
            // AC Maintenance
            [
                'title' => 'AC Repair & Maintenance',
                'type' => 'Maintenance',
                'description' => 'Fast AC repair and maintenance. Gas refill, cleaning, and part replacement available.',
                'category_slug' => 'ac-maintenance',
            ],
            [
                'title' => 'AC Installation Service',
                'type' => 'Installation',
                'description' => 'Professional AC installation for all types: split, window, and central systems.',
                'category_slug' => 'ac-maintenance',
            ],
            
            // Appliance Installation
            [
                'title' => 'TV Wall Mounting',
                'type' => 'Installation',
                'description' => 'Safe and secure TV wall mounting. All sizes supported. Cable management included.',
                'category_slug' => 'appliance-installation',
            ],
            [
                'title' => 'Home Appliance Setup',
                'type' => 'Installation',
                'description' => 'Install washing machines, dryers, dishwashers, and other home appliances.',
                'category_slug' => 'appliance-installation',
            ],
            
            // Furniture Assembly
            [
                'title' => 'IKEA Furniture Assembly',
                'type' => 'Assembly',
                'description' => 'Expert assembly of IKEA and other flat-pack furniture. Fast and professional.',
                'category_slug' => 'furniture-assembly',
            ],
            [
                'title' => 'Office Furniture Setup',
                'type' => 'Commercial',
                'description' => 'Complete office furniture assembly and installation. Desks, chairs, and storage solutions.',
                'category_slug' => 'furniture-assembly',
            ],
            
            // Gardening
            [
                'title' => 'Garden Design & Landscaping',
                'type' => 'Design',
                'description' => 'Transform your outdoor space with professional landscape design and installation.',
                'category_slug' => 'gardening',
            ],
            [
                'title' => 'Regular Garden Maintenance',
                'type' => 'Maintenance',
                'description' => 'Weekly garden care: mowing, trimming, watering, and plant care.',
                'category_slug' => 'gardening',
            ],
            
            // Moving
            [
                'title' => 'House Moving Service',
                'type' => 'Moving',
                'description' => 'Full-service home moving with professional movers. Packing materials available.',
                'category_slug' => 'home-moving',
            ],
            [
                'title' => 'Furniture Moving Only',
                'type' => 'Moving',
                'description' => 'Move heavy furniture safely. Specialized equipment for large items.',
                'category_slug' => 'furniture-moving',
            ],
        ];

        foreach ($gigs as $gigData) {
            // Find category by slug
            $category = $categories->firstWhere('slug', $gigData['category_slug']);
            
            if (!$category) {
                continue;
            }

            // Select random handyman
            $handyman = $handymen->random();

            $gig = Gig::create([
                'title' => $gigData['title'],
                'type' => $gigData['type'],
                'description' => $gigData['description'],
                'photos' => $this->generateFakePhotos(),
                'created_at' => now()->subDays(rand(1, 90)),
            ]);

            // Attach category
            $gig->categories()->attach($category->category_id);

            // Attach handyman
            $gig->handymen()->attach($handyman->handyman_id);
        }

        $this->command->info('Gigs seeded successfully!');
    }

    /**
     * Generate fake photo URLs
     */
    private function generateFakePhotos(): array
    {
        $photoCount = rand(1, 3);
        $photos = [];

        for ($i = 0; $i < $photoCount; $i++) {
            $photos[] = 'https://picsum.photos/800/600?random=' . rand(1, 1000);
        }

        return $photos;
    }
}
