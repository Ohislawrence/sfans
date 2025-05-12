<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class FrontpageContrller extends Controller
{
    public function index()
    {
        $categories = Video::whereNull('media_type')
            ->select('category')
            ->distinct()
            ->limit(10)
            ->pluck('category');
        $visitorPreferences = Cookie::get('visitor_preferences');
        $tags = [];

        if ($visitorPreferences) {
            $preferences = json_decode($visitorPreferences, true);
            $tags = $preferences['interests'] ?? [];
        }

        // 1. Fetch matching videos first
        $videosQuery = Video::query();

        $matchedVideos = collect();
        $matchedVideoIds = [];

        if (!empty($tags)) {
            $matchedVideos = Video::whereNull('media_type')->where(function($query) use ($tags) {
                foreach ($tags as $tag) {
                    $query->orWhere('tags', 'LIKE', "%{$tag}%");
                }
            })
            ->orderBy('date', 'desc') // <-- Sort matched videos by date
            ->take(12)
            ->get();
        
            $matchedVideoIds = $matchedVideos->pluck('id')->toArray();
        }
        
        // Fetch other videos (exclude matched), also sorted by date
        $otherVideos = Video::whereNull('media_type')->whereNotIn('id', $matchedVideoIds)
                            ->orderBy('date', 'desc') // <-- Sort by date
                            ->take(12 - $matchedVideos->count())
                            ->get();

        // 3. Merge both collections together
        $videos = $matchedVideos->concat($otherVideos);

        // 4. (Optional) If you still want to paginate manually later, you can create a LengthAwarePaginator

        $page = request('page', 1);
        $perPage = 12;

        $pagedVideos = new LengthAwarePaginator(
            $videos->forPage($page, $perPage),
            $videos->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        //$pagedVideos = $videos;
        return view('frontpages.homepage', ['videos' => $pagedVideos, 'categories'=> $categories]);
    }

    public function shorts()
    {
        $shorts = Video::paginate(3);
        return $shorts;
    }

    public function shortsview()
    {
        $shorts = Video::all();
        return view('frontpages.shorts',compact('shorts'));
    }

    public function videos()
    {
        $videos = Video::whereNull('media_type')->get();
        return view('frontpages.videos', compact('videos'));
    }

    public function video( $category,$slug)
    {
        $video = Video::whereNull('media_type')->where('slug',$slug)->where('category',$category)->firstOrFail();

        // Get related videos by tags (using LIKE matching)
        $relatedVideos = Video::where('slug', '!=', $slug)
        ->whereNull('media_type')
        ->where(function($query) use ($video) {
            foreach ($video->tags as $tag) {
                $query->orWhere('tags', 'LIKE', "%{$tag}%");
            }
        })
        ->limit(12)
        ->get();

        // 1. Get existing visitor preferences
    $visitorPreferences = json_decode(Cookie::get('visitor_preferences', json_encode([
        'interests' => []
    ])), true);

    // 2. Merge current video tags into preferences
    $tags = $video->tags ?? [];
    
    foreach ($tags as $tag) {
        if (!in_array($tag, $visitorPreferences['interests'])) {
            $visitorPreferences['interests'][] = $tag;
        }
    }

    // 3. (Optional) Limit max tags
    $maxTags = 15;
    if (count($visitorPreferences['interests']) > $maxTags) {
        $visitorPreferences['interests'] = array_slice($visitorPreferences['interests'], -$maxTags);
    }

    // 4. Set updated cookie
    Cookie::queue('visitor_preferences', json_encode($visitorPreferences), 60 * 24 * 365); // 1 year
        
        return view('frontpages.video', compact('video', 'relatedVideos'));
    }

    //category
    public function categories()
    {
        $categories = Video::select('category')->distinct()->limit(10)->pluck('category');

        
        return view('frontpages.category', compact('categories'));
    }

    public function category($slug, $tab=null)
    {
        if($tab == null || $tab == 'videos')
        {
        $viewAll = Video::whereNull('media_type')->where('tags', 'LIKE', "%{$slug}%")->paginate();
        
        }
        if($tab == 'photos'){
            $viewAll = Video::where('media_type',2)->where('tags', 'LIKE', "%{$slug}%")->paginate();
            
        }
        if($tab == 'gifs'){
            $viewAll = Video::where('media_type',3)->where('tags', 'LIKE', "%{$slug}%")->paginate();
            
        }
        
        $categories = Video::select('category')->distinct()->limit(10)->pluck('category');

        // Default tab if not provided
        $tab = $tab ?? 'videos';

        // Validate tab
        if (!in_array($tab, ['photos', 'videos','gifs'])) {
            $tab = 'videos'; // fallback to 'video'
        }

        return view('frontpages.categoryview', compact('categories','slug','tab','viewAll'));
    }

    public function photocategory($slug)
    {
        $photos = Video::where('media_type',2)->where('category', $slug)->paginate();
        return view('frontpages.pictures', compact('photos '));
    }

    public function gifcategory($slug)
    {
        $gifs = Video::where('media_type',3)->where('category', $slug)->paginate();
        return view('frontpages.pictures', compact('gifs'));
    }

    //category
    public function tags()
    {
        return view('frontpages.category');
    }

    public function videotag()
    {
        return view('frontpages.category');
    }

    public function phototag()
    {
        return view('frontpages.pictures');
    }

    public function giftag()
    {
        return view('frontpages.pictures');
    }

    //photo
    public function photos()
    {
        $photos = Video::where('media_type',2)->paginate(12);
        return view('frontpages.pictures', compact('photos'));
    }

    public function photoview($slug)
    {
        $photo = Video::where('media_type',2)->where('slug', $slug)->first();
        $relatedPhotos = Video::where('slug', '!=', $slug)
        ->where('media_type', 2)
        ->where(function($query) use ($photo) {
            foreach ($photo->tags as $tag) {
                $query->orWhere('tags', 'LIKE', "%{$tag}%");
            }
        })
        ->limit(12)
        ->get();
        return view('frontpages.pictureview', compact('photo','relatedPhotos'));
    }

    //gifs
    public function gifs()
    {
        $gifs = Video::where('media_type',3)->paginate(12);
        return view('frontpages.gifs', compact('gifs'));
    }

    public function gifview($slug)
    {
        $gif = Video::where('media_type', 3)->where('slug', $slug)->first();

        $relatedGifs = collect();

        if ($gif && $gif->tags) {
            $relatedGifs = Video::where('slug', '!=', $slug)
                ->where('media_type', 3)
                ->where(function ($query) use ($gif) {
                    foreach ($gif->tags as $tag) {
                        $query->orWhere('tags', 'LIKE', '%' . $tag . '%');
                    }
                })
                ->limit(12)
                ->get();
        }
        return view('frontpages.gifsview', compact('gif','relatedGifs'));
    }

    //userlist
    public function pornstars()
    {
        $pornstars = User::role('pornstar')->get();
        return view('frontpages.pornstarlist', compact('pornstars'));
    }

    public function sluts()
    {
        $sluts = User::role('slut')->get();
        return view('frontpages.slutlist',compact('sluts'));
    }

    //profile
    public function profile($username, $tab = null)
    {
        $user = User::where('username', $username)->firstOrFail();

        if($tab == null || $tab == 'videos')
        {
        $viewAll = Video::whereNull('media_type')->where('pornstars', 'LIKE', "%{$user->username}%")->paginate();
        
        }
        if($tab == 'photos'){
            $viewAll = Video::where('media_type',2)->where('pornstars', 'LIKE', "%{$user->username}%")->paginate();
            
        }
        if($tab == 'gifs'){
            $viewAll = Video::where('media_type',3)->where('pornstars', 'LIKE', "%{$user->username}%")->paginate();
            
        }

        // Default tab if not provided
        $tab = $tab ?? 'videos';

        // Validate tab
        if (!in_array($tab, ['gifs', 'photos', 'videos'])) {
            $tab = 'videos'; // fallback to 'video'
        }

        return view('frontpages.profile', compact('user', 'tab','viewAll'));
    }

    public function shop()
    {
        $products = Shop::all();
        return view('frontpages.shop', compact('products'));
    }

    public function show($id)
    {
        $product = Shop::findOrFail($id);
        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    public function viewitem($slug)
    {
        $item = Shop::where('slug', $slug)->first();

        if (!$item || !$item->url) {
            abort(404); // or return a custom error response/view
        }

        return redirect($item->url);
    }

    public function notify()
    {
        $profile = User::role('slut')->inRandomOrder()->first();
    
        return response()->json([
            'name' => 'Need a jerk mate?',
            'avatar' => asset('storage/' . $profile->display_photo),
            'message' => "{$profile->name} is online. ",
            'link' => route('chat', $profile->username),
        ]);
    }
    
    
    
}
