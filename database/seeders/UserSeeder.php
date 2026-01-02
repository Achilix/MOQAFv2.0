<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Handyman;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create regular clients (10)
        $clients = [
            ['fname' => 'Sarah', 'lname' => 'Ahmed', 'phone' => '+966501234567'],
            ['fname' => 'Mohammed', 'lname' => 'Ali', 'phone' => '+966501234568'],
            ['fname' => 'Fatima', 'lname' => 'Hassan', 'phone' => '+966501234569'],
            ['fname' => 'Abdullah', 'lname' => 'Khalid', 'phone' => '+966501234570'],
            ['fname' => 'Nora', 'lname' => 'Salem', 'phone' => '+966501234571'],
            ['fname' => 'Khalid', 'lname' => 'Omar', 'phone' => '+966501234572'],
            ['fname' => 'Layla', 'lname' => 'Ibrahim', 'phone' => '+966501234573'],
            ['fname' => 'Omar', 'lname' => 'Mansour', 'phone' => '+966501234574'],
            ['fname' => 'Aisha', 'lname' => 'Yousef', 'phone' => '+966501234575'],
            ['fname' => 'Hassan', 'lname' => 'Fahad', 'phone' => '+966501234576'],
        ];

        foreach ($clients as $index => $client) {
            $user = User::create([
                'fname' => $client['fname'],
                'lname' => $client['lname'],
                'email' => strtolower($client['fname']) . $index . '@example.com',
                'password' => Hash::make('password123'),
                'phone_number' => $client['phone'],
                'city' => 1,
                'address' => fake()->address(),
            ]);

            // Create client profile
            Client::create([
                'client_id' => $user->id,
                'user_id' => $user->id,
            ]);
        }

        // Create handymen (15)
        $handymen = [
            [
                'fname' => 'Ahmed',
                'lname' => 'Al-Ghamdi',
                'phone' => '+966502234567',
                'services' => ['Plumbing', 'Electrical'],
                'bio' => '10+ years experience in residential plumbing and electrical work. Licensed and insured.',
            ],
            [
                'fname' => 'Faisal',
                'lname' => 'Al-Otaibi',
                'phone' => '+966502234568',
                'services' => ['Carpentry', 'Furniture Assembly'],
                'bio' => 'Expert carpenter specializing in custom furniture and home repairs.',
            ],
            [
                'fname' => 'Yasser',
                'lname' => 'Al-Zahrani',
                'phone' => '+966502234569',
                'services' => ['Painting', 'Decoration'],
                'bio' => 'Professional painter with 8 years of experience in interior and exterior painting.',
            ],
            [
                'fname' => 'Tariq',
                'lname' => 'Al-Harbi',
                'phone' => '+966502234570',
                'services' => ['AC Maintenance', 'Electrical'],
                'bio' => 'HVAC specialist certified in AC installation, maintenance, and repair.',
            ],
            [
                'fname' => 'Majed',
                'lname' => 'Al-Shehri',
                'phone' => '+966502234571',
                'services' => ['House Cleaning', 'Deep Cleaning'],
                'bio' => 'Professional cleaning service with eco-friendly products and attention to detail.',
            ],
            [
                'fname' => 'Saud',
                'lname' => 'Al-Dossari',
                'phone' => '+966502234572',
                'services' => ['Gardening', 'Landscaping'],
                'bio' => 'Experienced gardener specializing in landscape design and maintenance.',
            ],
            [
                'fname' => 'Waleed',
                'lname' => 'Al-Qahtani',
                'phone' => '+966502234573',
                'services' => ['Appliance Installation', 'TV Mounting'],
                'bio' => 'Expert in home appliance installation and TV wall mounting services.',
            ],
            [
                'fname' => 'Rakan',
                'lname' => 'Al-Mutairi',
                'phone' => '+966502234574',
                'services' => ['Moving', 'Delivery'],
                'bio' => 'Reliable moving and delivery service with professional equipment.',
            ],
            [
                'fname' => 'Nayef',
                'lname' => 'Al-Anazi',
                'phone' => '+966502234575',
                'services' => ['Plumbing', 'General Maintenance'],
                'bio' => 'All-around handyman for quick fixes and regular maintenance needs.',
            ],
            [
                'fname' => 'Turki',
                'lname' => 'Al-Rasheed',
                'phone' => '+966502234576',
                'services' => ['Electrical', 'Smart Home'],
                'bio' => 'Electrical engineer specializing in smart home installations and automation.',
            ],
            [
                'fname' => 'Bandar',
                'lname' => 'Al-Subaie',
                'phone' => '+966502234577',
                'services' => ['Carpentry', 'Renovation'],
                'bio' => 'Complete renovation services from planning to execution.',
            ],
            [
                'fname' => 'Mansour',
                'lname' => 'Al-Dawsari',
                'phone' => '+966502234578',
                'services' => ['Painting', 'Wallpaper'],
                'bio' => 'Artistic painting and wallpaper installation with modern designs.',
            ],
            [
                'fname' => 'Saad',
                'lname' => 'Al-Malki',
                'phone' => '+966502234579',
                'services' => ['Pool Maintenance', 'Pressure Washing'],
                'bio' => 'Pool cleaning and pressure washing services for residential properties.',
            ],
            [
                'fname' => 'Abdulrahman',
                'lname' => 'Al-Tamimi',
                'phone' => '+966502234580',
                'services' => ['Office Cleaning', 'Commercial'],
                'bio' => 'Commercial cleaning services for offices and business spaces.',
            ],
            [
                'fname' => 'Meshal',
                'lname' => 'Al-Hoshan',
                'phone' => '+966502234581',
                'services' => ['Fixture Installation', 'Lighting'],
                'bio' => 'Lighting specialist for residential and commercial installations.',
            ],
        ];

        foreach ($handymen as $index => $handymanData) {
            $user = User::create([
                'fname' => $handymanData['fname'],
                'lname' => $handymanData['lname'],
                'email' => strtolower($handymanData['fname']) . $index . '@handyman.com',
                'password' => Hash::make('password123'),
                'phone_number' => $handymanData['phone'],
                'city' => rand(1, 2),
                'address' => fake()->address(),
            ]);

            // Create handyman profile
            Handyman::create([
                'handyman_id' => $user->id,
                'services' => $handymanData['services'],
                'bio' => $handymanData['bio'],
            ]);
        }

        $this->command->info('Users and Handymen seeded successfully!');
    }
}
