<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleOwner = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Owner']);
        $roleAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        
        $owner = \App\Models\User::firstOrCreate([
            'email' => 'admin@mail.id'
        ], [
            'name' => 'Admin',
            'password' => bcrypt('password123'),
        ]);

        $owner->assignRole($roleOwner);
    }
}
