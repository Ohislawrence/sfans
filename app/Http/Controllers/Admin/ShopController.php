<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Shop::latest()->paginate(10);
        $countries = Country::all();
        return view('admin.shop.index', compact('items','countries'));
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
            'name' => 'required|string',
            'url' => 'required|string',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048', // validate multiple image files
            'price' => 'required|string',
            'discount' => 'nullable|string',
            'promote_code' => 'nullable|string',
            'description' => 'required|string',
            'is_tangible' => 'required',
            'offer_by' => 'required',
            'countries' => 'required',
            'tags' => '' ,
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/shops', 'public'); // stores in storage/app/public/uploads/shops
                $imagePaths[] = $path;
            }
        }

        $validated['images'] = implode(',', $imagePaths);
        $validated['slug'] = Str::slug($validated['name']);
        $validated['countries'] = is_array($request->countries) ? implode(',', $request->countries) : $request->countries;
        $validated['tags'] = is_array($request->tags) ? implode(',', $request->tags) : $request->tags;

        Shop::create($validated);

        return back()->with('success', 'Item Created.');
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
    public function update(Request $request, Shop $shop)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'url' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'price' => 'required|string',
            'discount' => 'nullable|string',
            'promote_code' => 'nullable|string',
            'description' => 'required|string',
            'is_tangible' => 'required',
            'offer_by' => 'required',
            'countries' => 'required',
            'tags' => 'nullable|string',
        ]);

        $imagePaths = [];

        // Existing images
        $existingImages = $shop->images ? explode(',', $shop->images) : [];

        // Upload new images if any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/shops', 'public');
                $imagePaths[] = $path;
            }
        }

        // Merge old + new images
        $allImages = array_merge($existingImages, $imagePaths);
        $validated['images'] = implode(',', $allImages);

        // Update slug (optional: only if name changes)
        $validated['slug'] = Str::slug($validated['name']);

        $shop->update($validated);

        return back()->with('success', 'Item Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();

        return back()->with('success', 'Item deleted successfully.');
    }
}
