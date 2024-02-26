<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{   
    public function index()
    {
        return view('listings.index', [
            'listings' => Listing::latest()->filter
            (request(['tag', 'search']))->paginate(6)    
        ]);
    }

    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }
    
    public function create() {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $listingData = array_merge(
            $request->only(['title', 'company', 'location', 'website', 'email', 'tags', 'description']),
            ['logo' => $request->file('logo') ? $request->file('logo')->store('logos', 'public') : null],
            ['user_id' => auth()->id()]
        );

        Listing::create($listingData);

        return redirect('/')->with('message', 'The gig has been added!');
    }

    public function edit(Listing $listing){
        return view('listings.edit', ['listing' => $listing]);
    }
    
     public function update(Request $request, Listing $listing)
    {
        // Make sure logged-in user is the owner
        // This is a old project, would use model policies with ->authorize() helper for this now
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        } else {
            $formFields['logo'] = $listing->logo;
        }

        $listing->update($formFields);

        return back()->with('message', 'Gig has been updated!');
    }

    public function destroy(Listing $listing) {

        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

       $listing->delete();
       return redirect('/')->with('message', 'The gig has been deleted.');
    }

     public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
