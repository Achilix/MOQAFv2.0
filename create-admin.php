<?php

// Create admin user for MOQAF
require __DIR__ . '/bootstrap/app.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Admin user credentials
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
    echo "✅ Admin user updated!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
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
    echo "✅ Admin user created!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
}

echo "\n📋 ADMIN CREDENTIALS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Email:    " . $adminEmail . "\n";
echo "Password: " . $adminPassword . "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "\n🔗 LOGIN URL: http://localhost:8000/login\n";
echo "📊 ADMIN DASHBOARD: http://localhost:8000/admin/dashboard\n";
echo "\n✨ You can now log in and access the admin interface!\n";
