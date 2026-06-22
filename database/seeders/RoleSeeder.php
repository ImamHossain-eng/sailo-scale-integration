<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'super_admin', 'display_name' => 'Super Admin', 'description' => 'Full access to all features including user and role management.'],
            ['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Manage all operations except user and role management.'],
            ['name' => 'operator', 'display_name' => 'Operator', 'description' => 'View and manage weight scale operations with XK3190-D10 device.'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}