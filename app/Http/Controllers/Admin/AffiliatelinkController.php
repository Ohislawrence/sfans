<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliatelink;
use App\Models\Country;
use Illuminate\Http\Request;

class AffiliatelinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $afflinks = Affiliatelink::latest()->paginate(10);
        $countries = Country::all();
        return view('admin.affiliatelink.index', compact('afflinks','countries'));
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
            'link' => 'required|string',
            'offer_by' => 'required|string|max:255',
            'cost' => 'nullable|string|max:255',
            'offer_name'=> 'nullable|string|max:255',
            'coutries'=> 'nullable',
            'media' => 'nullable',
            'media_dimension' => 'nullable',
            'is_smartlink'=> 'nullable|string|max:255',
            'tags'=> 'nullable',
            'is_tangible'=> 'nullable|string|max:255',
        ]);
        $validated['coutries'] = is_array($request->coutries) ? implode(',', $request->coutries) : $request->coutries;

        Affiliatelink::create($validated);

        return back()->with('success', 'Link Created.');
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
    public function update(Request $request, Affiliatelink $affiliatelink)
    {
        $validated = $request->validate([
            'link' => 'required|string',
            'offer_by' => 'required|string|max:255',
            'cost' => 'nullable|string|max:255',
            'offer_name'=> 'nullable|string|max:255',
            'coutries'=> 'nullable|string|max:255',
            'is_smartlink'=> 'nullable|string|max:255',
            'media' => 'nullable',
            'media_dimension' => 'nullable',
            'tags'=> 'nullable',
            'is_tangible'=> 'nullable|string|max:255',
        ]);


        $affiliatelink->update($validated);

        return back()->with('success', 'Link updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Affiliatelink $affiliatelink)
    {
        $affiliatelink->delete();

        return back()->with('success', 'Link deleted successfully.');
    }
}
