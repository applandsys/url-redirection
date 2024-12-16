<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class BlockCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the user's IP address
//        $ip = $request->ip();
//
//        // Get the country from the IP address
//        $location = GeoIP::getLocation($ip);
//        $country = $location['country'];
//
//        // List of countries to block (use country codes or names)
//        $blockedCountries = ['US']; // Example: blocking US, China, and India
//
//        // Check if the country is in the blocked list
//        if (in_array(strtoupper($country), $blockedCountries)) {
//            // Optionally, you can redirect the user or return an error
//            return response()->json(['message' => 'Access from your country is blocked'], 403);
//        }

        return $next($request);
    }
}
