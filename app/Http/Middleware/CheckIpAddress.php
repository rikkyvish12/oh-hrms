<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\IpRestriction;

class CheckIpAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();
        
        // Check if IP is allowed
        if (!IpRestriction::isAllowed($ipAddress)) {
            return response('Access denied from this IP address.', 403);
        }

        return $next($request);
    }
}
