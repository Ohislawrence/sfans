<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\GeoIP;
use Torann\GeoIP\Facades\GeoIP as FacadesGeoIP;

class SetUserCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('user_country')) {
            $country = FacadesGeoIP::getLocation($request->ip())->country;
            session(['user_country' => $country]);
        }

        return $next($request);
    }
}
