<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('admin.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' =>'string',
            'duration' =>'string',
            'thumbnail' =>'string',
            'iframe' =>'string',
            'tags' =>'required|',
            'pornstars' =>'',
            'numbers' =>'',
            'category' =>'',
            'quality' =>'',
            'channel' =>'',
            'date' =>'',
            'media_type'=>'',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        Video::create($validated);

        return back()->with('success', 'Video posted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' =>'string',
            'duration' =>'string',
            'thumbnail' =>'string',
            'iframe' =>'string',
            'tags' =>'required|string',
            'pornstars' =>'',
            'numbers' =>'string',
            'category' =>'string',
            'quality' =>'',
            'channel' =>'string',
            'date' =>'',
            'media_type'=>'',
        ]);

        $video->update($validated);

        return back()->with('success', 'Video updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $video->delete();

        return back()->with('success', 'Video deleted successfully.');
    }
}
