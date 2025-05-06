<?php

namespace App\Services;

use App\Models\Visitor;
use Stevebauman\Location\Facades\Location;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class VisitorService
{
    protected $request;
    protected $agent;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->agent = new Agent();
    }

    /**
     * Track visitor information
     */
    public function trackVisitor()
    {
        $ip = $this->request->ip();
        
        // Get location data
        $location = Location::get($ip);
        
        // Get device/browser info
        $browser = $this->agent->browser();
        $device = $this->agent->device();
        $os = $this->agent->platform();
        
        // Create or update visitor record
        $visitor = Visitor::updateOrCreate(
            ['ip_address' => $ip],
            [
                'country' => $location->country ?? null,
                'city' => $location->city ?? null,
                'browser' => $browser,
                'device' => $device,
                'os' => $os,
                'last_visited_at' => now(),
            ]
        );
        
        return $visitor;
    }

    /**
     * Verify age and remember choice if requested
     */
    public function verifyAge(bool $isAdult, bool $remember = false)
    {
        $visitor = $this->trackVisitor();
        
        $visitor->update([
            'age_verified' => true,
            'is_adult' => $isAdult,
        ]);
        
        if ($remember) {
            $this->setAgeVerificationCookie();
        }
        
        return $visitor;
    }

    /**
     * Set age verification cookie
     */
    protected function setAgeVerificationCookie()
    {
        Cookie::queue(
            'age_verified',
            'true',
            60 * 24 * 30, // 30 days
            null,
            null,
            $this->request->secure(),
            true, // httpOnly
            false,
            'Strict'
        );
    }

    /**
     * Check if age is verified
     */
    public function isAgeVerified(): bool
    {
        return $this->request->cookie('age_verified') === 'true';
    }

    /**
     * Clear age verification
     */
    public function clearAgeVerification()
    {
        Cookie::queue(Cookie::forget('age_verified'));
    }
}