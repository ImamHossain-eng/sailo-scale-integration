<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = \App\Models\Role::where('name', 'super_admin')->first();

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@sailo.com',
            'password' => Hash::make('password'),
            'phone' => '0000000000',
            'role_id' => $superAdminRole->id,
        ]);
    }
}