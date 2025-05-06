<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class ShortsController extends Controller
{
    public function shortsviewsingle($slug)
    {
        $video = Video::where('slug', $slug)->where('media_type', 1)->firstOrFail();

        return view('frontpages.shorts', compact('video') );
    }

    public function getNextVideo(Request $request)
    {
        $excludeSlug = $request->input('exclude_slug');
        $tags = explode(',', $request->input('tags'));

        foreach ($tags as $tag) {
            $video = Video::where('slug', '!=', $excludeSlug)
                ->where('media_type', 1)
                ->where('tags', 'LIKE', '%' . trim($tag) . '%')
                ->inRandomOrder()
                ->first();

            if ($video) {
                return response()->json([
                    'video' => [
                        'slug' => $video->slug,
                        'title' => $video->title,
                        'link' => $video->link,
                        'tags' => $video->tags
                    ],
                    'url' => route('short.single', $video->slug),
                ]);
            }
        }

        // Fallback: get any random video
        $randomVideo = Video::where('slug', '!=', $excludeSlug)
            ->where('media_type', 1)
            ->inRandomOrder()
            ->first();

        if ($randomVideo) {
            return response()->json([
                'video' => [
                    'slug' => $randomVideo->slug,
                    'title' => $randomVideo->title,
                    'link' => $randomVideo->link,
                    'tags' => $randomVideo->tags
                ],
                'url' => route('short.single', $randomVideo->slug),
            ]);
        }

        return response()->json(null);
    }

    public function getPrevVideo(Request $request)
    {
        $viewedVideos = json_decode($request->input('viewed_videos'), true);

        if (!empty($viewedVideos)) {
            array_pop($viewedVideos); // Remove current video
            $lastSlug = end($viewedVideos);

            if ($lastSlug) {
                $video = Video::where('slug', $lastSlug)->where('media_type', 1)->first();
                if ($video) {
                    return response()->json([
                        'video' => [
                            'slug' => $video->slug,
                            'title' => $video->title,
                            'link' => $video->link,
                            'tags' => $video->tags
                        ],
                        'url' => route('short.single', $video->slug),
                    ]);
                }
            }
        }

        return response()->json(null);
    }
}
