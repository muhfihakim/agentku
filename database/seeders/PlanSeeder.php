<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'Trial',
            'price' => 0,
            'agent_limit' => 1,
            'duration_days' => 3,
            'status' => 'aktif',
        ]);

        Plan::create([
            'name' => 'Basic Plan 1 Agent',
            'price' => 50000,
            'agent_limit' => 1,
            'duration_days' => 30,
            'status' => 'aktif',
        ]);

        Plan::create([
            'name' => 'Basic Plan 2 Agent',
            'price' => 80000,
            'agent_limit' => 2,
            'duration_days' => 30,
            'status' => 'aktif',
        ]);

        Plan::create([
            'name' => 'Basic Plan 5 Agent',
            'price' => 150000,
            'agent_limit' => 5,
            'duration_days' => 30,
            'status' => 'aktif',
        ]);

        Plan::create([
            'name' => 'Kontak Admin Untuk Paket Lebih Lanjut',
            'price' => 0,
            'agent_limit' => -1,
            'duration_days' => 30,
            'status' => 'aktif',
        ]);
    }
}
