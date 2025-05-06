<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Services\VisitorService;
use Illuminate\Support\Facades\Cookie;
use Stevebauman\Location\Facades\Location;
use Jenssegers\Agent\Agent;

class AgeVerificationController extends Controller
{

    protected $request;
    protected $agent;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->agent = new Agent();
    }

    public function show()
    {
        return view('age-verification');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'confirm_age' => 'required|accepted',
        ]);

    
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

        Cookie::queue('visitor_data', json_encode([
            'visitor_id' => $visitor->id,
            'age_verified' => true,
            'country' => $location->country ?? null,
        ]), 60 * 24 * 365); // 1 year

        return response()->json(['success' => true]);
    }
}