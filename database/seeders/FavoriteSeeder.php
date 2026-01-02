<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Gig;
use App\Models\Handyman;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = User::whereHas('client')->get();
        $gigs = Gig::all();
        $handymen = Handyman::all();

        if ($clients->isEmpty() || $gigs->isEmpty() || $handymen->isEmpty()) {
            $this->command->error('Please run UserSeeder and GigSeeder first!');
            return;
        }

        // Each client favorites 2-5 random items
        foreach ($clients as $client) {
            $favoriteCount = rand(2, 5);

            // Favorite some gigs
            $gigsToFavorite = $gigs->random(min($favoriteCount, $gigs->count()));
            foreach ($gigsToFavorite as $gig) {
                Favorite::create([
                    'user_id' => $client->id,
                    'favoritable_type' => 'App\\Models\\Gig',
                    'favoritable_id' => $gig->id_gig,
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);
            }

            // Favorite some handymen (30% of clients)
            if (rand(1, 100) <= 30) {
                $handymenToFavorite = $handymen->random(min(rand(1, 3), $handymen->count()));
                foreach ($handymenToFavorite as $handyman) {
                    Favorite::create([
                        'user_id' => $client->id,
                        'favoritable_type' => 'App\\Models\\Handyman',
                        'favoritable_id' => $handyman->handyman_id,
                        'created_at' => now()->subDays(rand(1, 60)),
                    ]);
                }
            }
        }

        $this->command->info('Favorites seeded successfully!');
    }
}
