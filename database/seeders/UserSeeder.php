<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = \App\Models\Tenant::firstOrCreate(['id' => 'majumundur']);
        
        $admin = \App\Models\User::firstOrCreate([
            'email' => 'admin@majumundur.com'
        ], [
            'name' => 'Admin Maju Mundur',
            'password' => bcrypt('password123'),
            'tenant_id' => $tenant->id,
        ]);

        $admin->assignRole('Admin');
    }
}
