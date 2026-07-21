<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Tenant;
use Carbon\Carbon;

#[Signature('billing:check')]
#[Description('Check for expired billing plans and suspend tenants')]
class CheckBillingStatus extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        
        $expiredTenants = Tenant::whereRaw("json_unquote(json_extract(data, '$.plan_ends_at')) < ?", [$now])
                                ->where(function($q) {
                                    $q->whereRaw("json_unquote(json_extract(data, '$.billing_status')) = 'lunas'")
                                      ->orWhereRaw("json_extract(data, '$.billing_status') IS NULL");
                                })
                                ->get();
                                
        $count = 0;
        foreach ($expiredTenants as $tenant) {
            $tenant->update([
                'billing_status' => 'ditangguhkan',
                'account_status' => 'nonaktif'
            ]);
            $count++;
        }
        
        $this->info("Checked billing statuses. $count tenant(s) suspended.");
    }
}
