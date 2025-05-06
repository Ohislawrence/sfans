<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use App\Models\Visitor;

class CheckAgeVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $visitorData = Cookie::get('visitor_data');

        if ($visitorData) {
            $visitor = json_decode($visitorData, true);

            if (isset($visitor['age_verified']) && $visitor['age_verified'] === true) {
                // User is verified, allow access without DB query
                return $next($request);
            }
        }

        // Still allow the page to load because JS SweetAlert handles asking
        return $next($request);
    }
}
