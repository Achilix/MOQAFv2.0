<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');
        
        // Order matters! Don't change the sequence
        $this->call([
            CategorySeeder::class,      // 1. Create categories first
            UserSeeder::class,           // 2. Create users (clients & handymen)
            GigSeeder::class,            // 3. Create gigs (needs handymen & categories)
            GigTierSeeder::class,        // 4. Create pricing tiers for gigs
            OrderSeeder::class,          // 5. Create orders (needs users, handymen, gigs)
            ReviewSeeder::class,         // 6. Create reviews (needs completed orders)
            FavoriteSeeder::class,       // 7. Create favorites (needs users & gigs)
            NotificationSeeder::class,   // 8. Create additional notifications
        ]);

        $this->command->newLine();
        $this->command->info('✅ Database seeded successfully!');
        $this->command->newLine();
        $this->command->info('📊 Test Data Summary:');
        $this->command->info('   • 10 Clients created');
        $this->command->info('   • 15 Handymen created');
        $this->command->info('   • 6 Parent Categories with 21 Subcategories');
        $this->command->info('   • 25+ Gigs created');
        $this->command->info('   • 45 Pricing tiers (3 tiers per gig) ⭐ NEW');
        $this->command->info('   • 30-50 Orders created');
        $this->command->info('   • Reviews with ratings for completed orders');
        $this->command->info('   • Favorites and Notifications added');
        $this->command->newLine();
        $this->command->info('🔐 Test Credentials:');
        $this->command->info('   Client: sarah0@example.com / password123');
        $this->command->info('   Handyman: ahmed0@handyman.com / password123');
    }
}

