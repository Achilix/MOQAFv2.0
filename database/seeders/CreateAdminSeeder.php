<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin exists
        $adminExists = User::where('email', 'admin@moqaf.com')->first();
        
        if ($adminExists) {
            $adminExists->update([
                'fname' => 'Admin',
                'lname' => 'User',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            echo "✅ Admin user updated successfully!\n";
        } else {
            User::create([
                'fname' => 'Admin',
                'lname' => 'User',
                'email' => 'admin@moqaf.com',
                'password' => Hash::make('Admin@12345'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            echo "✅ Admin user created successfully!\n";
        }
        
        echo "Email: admin@moqaf.com\n";
        echo "Password: Admin@12345\n";
    }
}
