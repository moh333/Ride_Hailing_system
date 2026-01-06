<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $driverRole = Role::create(['name' => 'driver']);
        $passengerRole = Role::create(['name' => 'passenger']);

        // Create Permissions (example)
        Permission::create(['name' => 'view dashboard']);
        Permission::create(['name' => 'manage drivers']);
        Permission::create(['name' => 'manage passengers']);

        // Assign Permissions
        $adminRole->givePermissionTo(Permission::all());

        // Create Admin User
        $admin = User::create([
            'id' => Str::uuid(),
            'name' => 'Admin User',
            'email' => 'admin@ride.com',
            'password' => 'password', // simple password for dev
        ]);

        $admin->assignRole($adminRole);
    }
}
