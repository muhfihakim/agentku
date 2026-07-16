<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenancyByAuthUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user) {
            if ($user->tenant_id) {
                tenancy()->initialize($user->tenant_id);
            } elseif ($user->hasRole('Owner') && !$request->is('owner*')) {
                return redirect()->route('owner.dashboard');
            }
        }

        return $next($request);
    }
}
