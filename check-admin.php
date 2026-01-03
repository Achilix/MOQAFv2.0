<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$admin = User::where('email', 'admin@moqaf.com')->first();

if ($admin) {
    echo "✅ Admin User Found!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Name: " . $admin->fname . " " . $admin->lname . "\n";
    echo "Email: " . $admin->email . "\n";
    echo "Role: " . $admin->role . "\n";
    echo "Is Admin: " . ($admin->role === 'admin' ? 'YES ✓' : 'NO ✗') . "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
} else {
    echo "❌ Admin user not found!\n";
}
