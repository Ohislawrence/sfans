<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AffiliateAdService
{
    // Time-to-live for cache in minutes
    const CACHE_TTL = 60; // 1 hour
    
    public function displayAd($userCountry, $adSize, $isImageAd, $fallbackToSmartlink = true)
    {
        try {
            $cacheKey = $this->generateCacheKey($userCountry, $adSize, $isImageAd, $fallbackToSmartlink);
            
            // Get ad data with rotation index
            $cacheData = Cache::get($cacheKey);
            
            if ($cacheData === null) {
                // Cache miss - get fresh data
                $adData = $this->getAdData($userCountry, $fallbackToSmartlink);
                $cacheData = [
                    'ads' => $adData,
                    'rotation_index' => 0,
                    'expires_at' => now()->addMinutes(self::CACHE_TTL)
                ];
                Cache::put($cacheKey, $cacheData, self::CACHE_TTL);
            } elseif ($cacheData['expires_at']->isPast()) {
                // Cache expired - refresh data but maintain rotation
                $adData = $this->getAdData($userCountry, $fallbackToSmartlink);
                $cacheData['ads'] = $adData;
                $cacheData['expires_at'] = now()->addMinutes(self::CACHE_TTL);
                Cache::put($cacheKey, $cacheData, self::CACHE_TTL);
            }

            if (empty($cacheData['ads'])) {
                return $this->getFallbackAd();
            }

            // Rotate and get current ad
            $selectedAd = $this->rotateAd($cacheKey, $cacheData);
            return $this->generateAdHtml($selectedAd, $adSize, $isImageAd);
            
        } catch (\Exception $e) {
            Log::error('Affiliate ad error: ' . $e->getMessage());
            return $this->getFallbackAd();
        }
    }

    protected function generateCacheKey(...$params)
    {
        // Create a unique key without special characters
        return 'affiliate_ads_' . md5(implode('|', $params));
    }

    protected function getAdData($userCountry, $fallbackToSmartlink)
    {
        $tags = $this->getUserTags();
        
        $query = DB::table('affiliatelink')
            ->where('is_smartlink', 0)
            ->where(function($q) use ($userCountry) {
                $q->whereJsonContains('countries', $userCountry)
                  ->orWhereNull('countries')
                  ->orWhere('countries', '[]');
            });

        if (!empty($tags)) {
            $query->where(function($q) use ($tags) {
                foreach ($tags as $tag) {
                    $q->orWhereJsonContains('tags', $tag);
                }
            });
        }

        $matchingAds = $query->orderBy('cost', 'desc')->get()->toArray();

        if (empty($matchingAds) && $fallbackToSmartlink) {
            $matchingAds = DB::table('affiliatelink')
                ->where('is_smartlink', 1)
                ->orderBy('cost', 'desc')
                ->get()
                ->toArray();
        }

        return $matchingAds;
    }

    protected function rotateAd($cacheKey, &$cacheData)
    {
        $currentIndex = $cacheData['rotation_index'];
        $selectedAd = $cacheData['ads'][$currentIndex];
        
        // Update rotation index (round-robin)
        $cacheData['rotation_index'] = ($currentIndex + 1) % count($cacheData['ads']);
        
        // Update cache with new rotation index
        Cache::put($cacheKey, $cacheData, self::CACHE_TTL);
        
        return $selectedAd;
    }

    protected function generateAdHtml($ad, $adSize, $isImageAd)
    {
        if ($isImageAd) {
            return '<a href="' . e($ad->link) . '" target="_blank" rel="nofollow sponsored">' .
                   '<img src="' . e($ad->image_url ?? '') . '" alt="' . e($ad->offer_name) . '" ' .
                   'style="width: ' . e($adSize) . '; border: none;"></a>';
        }

        return '<a href="' . e($ad->link) . '" target="_blank" rel="nofollow sponsored">' . 
               e($ad->offer_name) . '</a>';
    }

    protected function getFallbackAd()
    {
        // You can return a default ad or empty string
        return '';
    }

    protected function getUserTags()
    {
        $visitorPreferences = Cookie::get('visitor_preferences');
        $tags = [];

        if ($visitorPreferences) {
            $preferences = json_decode($visitorPreferences, true);
            $tags = $preferences['interests'] ?? [];
        }

        return $tags;
    }
}