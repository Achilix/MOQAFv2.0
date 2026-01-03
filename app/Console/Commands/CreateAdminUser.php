<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user for MOQAF platform';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminEmail = 'admin@moqaf.com';
        $adminPassword = 'Admin@12345';

        // Check if admin already exists
        $existingAdmin = User::where('email', $adminEmail)->first();

        if ($existingAdmin) {
            // Update existing user to admin
            $existingAdmin->update([
                'role' => 'admin',
                'password' => Hash::make($adminPassword)
            ]);
            $this->info('✅ Admin user updated!');
        } else {
            // Create new admin user
            User::create([
                'fname' => 'Admin',
                'lname' => 'User',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'phone_number' => '+1 (555) 000-0000',
                'address' => 'Admin Office',
                'city' => 'Riyadh',
                'role' => 'admin',
                'email_verified_at' => now()
            ]);
            $this->info('✅ Admin user created!');
        }

        $this->line('');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line('📋 ADMIN CREDENTIALS');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line('Email:    ' . $adminEmail);
        $this->line('Password: ' . $adminPassword);
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line('');
        $this->info('🔗 LOGIN URL: http://localhost:8000/login');
        $this->info('📊 ADMIN DASHBOARD: http://localhost:8000/admin/dashboard');
        $this->line('');
        $this->comment('✨ You can now log in and access the admin interface!');
    }
}
