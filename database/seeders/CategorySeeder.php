<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Home Repair',
                'slug' => 'home-repair',
                'description' => 'All types of home repair services',
                'icon' => '🏠',
                'order' => 1,
                'children' => [
                    ['name' => 'Plumbing', 'slug' => 'plumbing', 'icon' => '🔧', 'description' => 'Pipes, faucets, and water systems'],
                    ['name' => 'Electrical', 'slug' => 'electrical', 'icon' => '⚡', 'description' => 'Wiring, outlets, and electrical fixtures'],
                    ['name' => 'Carpentry', 'slug' => 'carpentry', 'icon' => '🪚', 'description' => 'Wood work and furniture repair'],
                    ['name' => 'Painting', 'slug' => 'painting', 'icon' => '🎨', 'description' => 'Interior and exterior painting'],
                ],
            ],
            [
                'name' => 'Cleaning Services',
                'slug' => 'cleaning-services',
                'description' => 'Professional cleaning services',
                'icon' => '🧹',
                'order' => 2,
                'children' => [
                    ['name' => 'House Cleaning', 'slug' => 'house-cleaning', 'icon' => '🏡', 'description' => 'Residential cleaning services'],
                    ['name' => 'Deep Cleaning', 'slug' => 'deep-cleaning', 'icon' => '✨', 'description' => 'Thorough deep cleaning'],
                    ['name' => 'Office Cleaning', 'slug' => 'office-cleaning', 'icon' => '🏢', 'description' => 'Commercial space cleaning'],
                ],
            ],
            [
                'name' => 'Installation',
                'slug' => 'installation',
                'description' => 'Installation services for appliances and fixtures',
                'icon' => '🔨',
                'order' => 3,
                'children' => [
                    ['name' => 'Appliance Installation', 'slug' => 'appliance-installation', 'icon' => '📺', 'description' => 'TV, AC, appliances'],
                    ['name' => 'Furniture Assembly', 'slug' => 'furniture-assembly', 'icon' => '🪑', 'description' => 'Furniture setup and assembly'],
                    ['name' => 'Fixture Installation', 'slug' => 'fixture-installation', 'icon' => '💡', 'description' => 'Lights, fans, and fixtures'],
                ],
            ],
            [
                'name' => 'Maintenance',
                'slug' => 'maintenance',
                'description' => 'Regular maintenance services',
                'icon' => '🔧',
                'order' => 4,
                'children' => [
                    ['name' => 'AC Maintenance', 'slug' => 'ac-maintenance', 'icon' => '❄️', 'description' => 'Air conditioning service'],
                    ['name' => 'Heating Systems', 'slug' => 'heating-systems', 'icon' => '🔥', 'description' => 'Heating and HVAC'],
                    ['name' => 'General Maintenance', 'slug' => 'general-maintenance', 'icon' => '⚙️', 'description' => 'General home maintenance'],
                ],
            ],
            [
                'name' => 'Outdoor Services',
                'slug' => 'outdoor-services',
                'description' => 'Outdoor and garden services',
                'icon' => '🌳',
                'order' => 5,
                'children' => [
                    ['name' => 'Gardening', 'slug' => 'gardening', 'icon' => '🌸', 'description' => 'Garden care and landscaping'],
                    ['name' => 'Pressure Washing', 'slug' => 'pressure-washing', 'icon' => '💦', 'description' => 'Exterior cleaning'],
                    ['name' => 'Pool Maintenance', 'slug' => 'pool-maintenance', 'icon' => '🏊', 'description' => 'Swimming pool service'],
                ],
            ],
            [
                'name' => 'Moving & Delivery',
                'slug' => 'moving-delivery',
                'description' => 'Moving and delivery services',
                'icon' => '📦',
                'order' => 6,
                'children' => [
                    ['name' => 'Home Moving', 'slug' => 'home-moving', 'icon' => '🚚', 'description' => 'Residential moving services'],
                    ['name' => 'Furniture Moving', 'slug' => 'furniture-moving', 'icon' => '🛋️', 'description' => 'Furniture transportation'],
                    ['name' => 'Delivery Service', 'slug' => 'delivery-service', 'icon' => '📬', 'description' => 'Item delivery'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $category->category_id;
                $childData['order'] = 0;
                Category::create($childData);
            }
        }

        $this->command->info('Categories seeded successfully!');
    }
}
