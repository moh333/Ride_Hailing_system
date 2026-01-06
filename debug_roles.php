<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = User::where('email', 'admin@ride.com')->first();
if (!$user) {
    echo "Admin user not found.\n";
    exit;
}

echo "User ID: " . $user->id . "\n";
echo "Roles: " . $user->getRoleNames()->implode(', ') . "\n";

$role = Role::where('name', 'admin')->first();
if ($role) {
    echo "Admin Role ID: " . $role->id . "\n";
} else {
    echo "Admin role not found.\n";
}

$hasRole = $user->hasRole('admin');
echo "Has Admin Role: " . ($hasRole ? 'Yes' : 'No') . "\n";
