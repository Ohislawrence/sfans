<?php

use App\Models\Affiliatelink;
use Hibit\GeoDetect;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

if (!function_exists('get_affiliate_link')) {
    function get_affiliate_link($media_dimension = null, $tags = [])
    {
        $geoDetect = new GeoDetect();
        if (App::environment(['production'])) {
            $country = $geoDetect->getCountry(request()->ip())->getIsoCode();
        }else{
            $country = $geoDetect->getCountry('129.205.124.201')->getIsoCode();
        }
        
        
        // If no tags passed, fall back to cookie
        if (empty($tags)) {
            if ($visitorPreferences = Cookie::get('visitor_preferences')) {
                $preferences = json_decode($visitorPreferences, true);
                $tags = $preferences['interests'] ?? [];
            }
        }

        $query = Affiliatelink::query()
            ->when($media_dimension, fn($q) => $q->where('media_dimension', $media_dimension))
            ->where(function ($q) use ($country) {
                $q->whereNull('coutries')
                  ->orWhere('coutries', 'like', "%$country%");
            })
            ->where(function ($q) use ($tags) {
                $q->whereNull('tags');
                foreach ($tags as $tag) {
                    $q->orWhere('tags', 'like', "%$tag%");
                }
            });

            //dd($tags);
        $matchingLinks = $query->get();

        if ($matchingLinks->count()) {
            return $matchingLinks->random();
        }else{
            return Affiliatelink::inRandomOrder()->first();
        }
    

        // fallback to smartlink
        $smartlink = Affiliatelink::where('is_smartlink', 1)->inRandomOrder()->first();
        return $smartlink->link ?? null;
    }
}
