<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IpRestrictionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientIP = $request->header('X-Forwarded-For') ?? $request->ip();

        // Log client's IP address
        \Log::info('Client IP: ' . $clientIP);

        $allowedIPs = ['103.197.153.63','103.199.169.30','103.197.152.71','127.0.0.1', '27.147.205.91'];

        // Check if the client's IP is in the allowed list
        if (!in_array($clientIP, $allowedIPs)) {
            abort(403, 'Unauthorized. Your IP address is not allowed.');
        }

        return $next($request);
    }
}
