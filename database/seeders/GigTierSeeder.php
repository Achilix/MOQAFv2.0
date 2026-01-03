<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gig;
use App\Models\GigTier;

class GigTierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tieredGigs = [
            1 => [ // Emergency Plumbing Repair
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Quick diagnosis and advice on plumbing problems',
                    'base_price' => 25.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Fix small leaks, unclog drains in one location',
                    'base_price' => 75.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Full emergency repair service including pipe replacement',
                    'base_price' => 200.00,
                    'delivery_days' => 2,
                ],
            ],
            2 => [ // Bathroom & Kitchen Plumbing
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Consultation and assessment of bathroom/kitchen fixtures',
                    'base_price' => 30.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Install or repair single fixture (sink, faucet, toilet)',
                    'base_price' => 80.00,
                    'delivery_days' => 2,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Complete bathroom or kitchen plumbing renovation',
                    'base_price' => 300.00,
                    'delivery_days' => 4,
                ],
            ],
            3 => [ // Water Heater Installation
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Inspect and diagnose water heater issues',
                    'base_price' => 40.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Repair or replace water heater (standard models)',
                    'base_price' => 150.00,
                    'delivery_days' => 2,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Complete installation with premium tankless system',
                    'base_price' => 500.00,
                    'delivery_days' => 3,
                ],
            ],
            4 => [ // Electrical Wiring & Rewiring
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Electrical inspection and safety assessment',
                    'base_price' => 35.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Rewire one room with standard cables',
                    'base_price' => 120.00,
                    'delivery_days' => 2,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Complete house rewiring with code compliance',
                    'base_price' => 400.00,
                    'delivery_days' => 5,
                ],
            ],
            5 => [ // Light Fixture Installation
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Install basic ceiling light or fix existing fixture',
                    'base_price' => 30.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Install lights in one room including chandeliers',
                    'base_price' => 75.00,
                    'delivery_days' => 2,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Complete house lighting design and installation',
                    'base_price' => 250.00,
                    'delivery_days' => 4,
                ],
            ],
            6 => [ // Electrical Panel Upgrade
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Inspect electrical panel and provide upgrade recommendations',
                    'base_price' => 45.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Upgrade panel with additional breakers',
                    'base_price' => 200.00,
                    'delivery_days' => 2,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Full panel replacement with modern safety features',
                    'base_price' => 600.00,
                    'delivery_days' => 3,
                ],
            ],
            7 => [ // Custom Cabinet Making
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Design consultation and measurements',
                    'base_price' => 50.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Build and install cabinets for one room',
                    'base_price' => 300.00,
                    'delivery_days' => 5,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Custom high-end cabinetry for entire home',
                    'base_price' => 1000.00,
                    'delivery_days' => 7,
                ],
            ],
            8 => [ // Door & Window Installation
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Install single door or window',
                    'base_price' => 60.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Install multiple doors or windows in one room',
                    'base_price' => 200.00,
                    'delivery_days' => 2,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Complete exterior door and window replacement',
                    'base_price' => 500.00,
                    'delivery_days' => 4,
                ],
            ],
            9 => [ // Furniture Repair & Restoration
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Assess furniture condition and provide repair options',
                    'base_price' => 35.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Repair single furniture piece (chair, table, etc)',
                    'base_price' => 100.00,
                    'delivery_days' => 3,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Complete furniture restoration with refinishing',
                    'base_price' => 300.00,
                    'delivery_days' => 5,
                ],
            ],
            10 => [ // Interior Painting
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Paint one room with single color',
                    'base_price' => 50.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Paint multiple rooms with custom colors',
                    'base_price' => 150.00,
                    'delivery_days' => 2,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Complete interior painting with accent walls and textures',
                    'base_price' => 350.00,
                    'delivery_days' => 3,
                ],
            ],
            11 => [ // Exterior House Painting
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Paint exterior trim and details',
                    'base_price' => 75.00,
                    'delivery_days' => 2,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Paint entire exterior with one color',
                    'base_price' => 300.00,
                    'delivery_days' => 3,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Complete exterior with multiple colors and faux finishes',
                    'base_price' => 600.00,
                    'delivery_days' => 4,
                ],
            ],
            12 => [ // Drywall Repair
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Repair small holes and cracks',
                    'base_price' => 30.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Replace drywall sections in one room',
                    'base_price' => 120.00,
                    'delivery_days' => 2,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Complete room drywall replacement with finishing',
                    'base_price' => 350.00,
                    'delivery_days' => 3,
                ],
            ],
            13 => [ // Tile Installation
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Repair or replace small tile area',
                    'base_price' => 40.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Install tiles in bathroom or kitchen',
                    'base_price' => 150.00,
                    'delivery_days' => 3,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Complete tile installation for entire home',
                    'base_price' => 500.00,
                    'delivery_days' => 5,
                ],
            ],
            14 => [ // Flooring Installation
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Install flooring in single small room',
                    'base_price' => 100.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Install flooring in multiple rooms',
                    'base_price' => 300.00,
                    'delivery_days' => 2,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Complete house flooring with subfloor preparation',
                    'base_price' => 1000.00,
                    'delivery_days' => 4,
                ],
            ],
            15 => [ // HVAC Service
                [
                    'tier_name' => 'BASIC',
                    'description' => 'Inspect HVAC system and change filters',
                    'base_price' => 40.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'MEDIUM',
                    'description' => 'Service and minor repairs to HVAC system',
                    'base_price' => 120.00,
                    'delivery_days' => 1,
                ],
                [
                    'tier_name' => 'PREMIUM',
                    'description' => 'Full HVAC system installation and setup',
                    'base_price' => 800.00,
                    'delivery_days' => 3,
                ],
            ],
        ];

        // Create tiers for first 15 gigs
        foreach ($tieredGigs as $gigId => $tiers) {
            $gig = Gig::find($gigId);
            
            if ($gig) {
                foreach ($tiers as $tierData) {
                    GigTier::create([
                        'id_gig' => $gig->id_gig,
                        'tier_name' => $tierData['tier_name'],
                        'description' => $tierData['description'],
                        'base_price' => $tierData['base_price'],
                        'delivery_days' => $tierData['delivery_days'],
                    ]);
                }
                
                $this->command->info("✅ Tiers created for: {$gig->title}");
            }
        }

        $this->command->newLine();
        $this->command->info('📊 Pricing Tiers Summary:');
        $this->command->info('   • 15 Gigs with pricing tiers');
        $this->command->info('   • 45 Total pricing tiers (3 per gig)');
        $this->command->info('   • BASIC, MEDIUM, PREMIUM pricing available');
    }
}
