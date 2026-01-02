<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Handyman;
use App\Models\Gig;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = User::whereHas('client')->get();
        $handymen = Handyman::all();
        $gigs = Gig::all();

        if ($clients->isEmpty() || $handymen->isEmpty()) {
            $this->command->error('Please run UserSeeder first!');
            return;
        }

        $statuses = ['pending', 'accepted', 'completed', 'rejected', 'cancelled'];
        
        // Create 30-50 random orders
        $orderCount = rand(30, 50);

        for ($i = 0; $i < $orderCount; $i++) {
            $client = $clients->random();
            $handyman = $handymen->random();
            $gig = $gigs->isNotEmpty() ? $gigs->random() : null;
            
            // Most orders should be completed (for reviews)
            $status = $this->weightedRandomStatus();
            
            $createdAt = now()->subDays(rand(1, 90));
            
            $order = Order::create([
                'id_client' => $client->client->client_id ?? null,
                'id_handyman' => $handyman->handyman_id,
                'id_gig' => $gig ? $gig->id_gig : null,
                'price' => rand(100, 5000),
                'description' => $this->generateOrderDescription(),
                'status' => $status,
                'rating' => null, // Will be set by reviews
                'created_at' => $createdAt,
            ]);
        }

        $this->command->info('Orders seeded successfully!');
    }

    /**
     * Generate weighted random status (more completed orders)
     */
    private function weightedRandomStatus(): string
    {
        $rand = rand(1, 100);
        
        if ($rand <= 50) return 'completed'; // 50%
        if ($rand <= 70) return 'accepted';  // 20%
        if ($rand <= 85) return 'pending';   // 15%
        if ($rand <= 95) return 'rejected';  // 10%
        return 'cancelled';                   // 5%
    }

    /**
     * Generate fake order descriptions
     */
    private function generateOrderDescription(): string
    {
        $descriptions = [
            'Need urgent repair in living room. Please come ASAP.',
            'Looking for professional service to fix kitchen sink leak.',
            'Regular maintenance needed for my apartment.',
            'Installation required for new appliances purchased last week.',
            'Need someone reliable to help with home improvement project.',
            'Emergency repair needed. Water damage in bathroom.',
            'Scheduled maintenance for monthly cleaning service.',
            'Need expert to fix electrical issues in bedroom.',
            'Looking for quality work at reasonable price.',
            'Renovation project - need detailed consultation first.',
            'Furniture assembly needed for newly purchased items.',
            'Garden needs complete makeover. Budget flexible.',
            'AC not cooling properly. Need immediate inspection.',
            'Painting needed for 3 rooms. Prefer weekend schedule.',
            'Deep cleaning required before family event next month.',
            'Moving next week. Need reliable moving service.',
            'Custom carpentry work for home office setup.',
            'Pool maintenance overdue. Please schedule visit.',
            'Smart home installation - need expert advice.',
            'Office space needs complete cleaning service.',
        ];

        return $descriptions[array_rand($descriptions)];
    }
}
