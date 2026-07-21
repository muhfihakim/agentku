<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlanActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = tenant();
        
        // If not running in tenant context, bypass (e.g. owner)
        if (!$tenant) {
            return $next($request);
        }

        if ($tenant->plan_ends_at) {
            $endsAt = \Carbon\Carbon::parse($tenant->plan_ends_at);
            if (now()->greaterThan($endsAt)) {
                // Return json if ajax/api request
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json(['error' => 'Paket Anda sudah kadaluarsa.'], 403);
                }
                
                return redirect()->route('client.settings.index')
                    ->withErrors(['error' => 'Paket berlangganan Anda telah berakhir. Silakan upgrade paket untuk menggunakan fitur ini.']);
            }
        }

        return $next($request);
    }
}
