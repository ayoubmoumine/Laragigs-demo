<?php

namespace App\Http\Controllers;

use App\Formfields\ListingFormFields;
use App\Models\Listing;
use App\Services\ListingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{

    protected $listingService;

    public function __construct(ListingService $listingService)
    {
        $this->listingService = $listingService;
    }

    public function index(Request $request) {
        return view('listings.index', [
            "listings" => Listing::latest()->filter(["tags" => $request->tag, "search" => $request->search])->paginate(10)
            ]
        );
    }

    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    public function create() {
        return view("listings.create");
    }

    public function store(Request $request) {

        $this->listingService->saveListing($request);

        return redirect("/")->with("message", "Post added successfuly !");
    }

    public function edit(Listing $listing)
    {
        return view('listings.edit', [
            "listing" => $listing
        ]);
    }
    
    public function update(Request $request, Listing $listing) {
        if($listing->user_id != auth()->user()->id) {
            abort(403, "unauthorized");
        }

        $this->listingService->updateListing($request, $listing);

        return back()->with("message", "Post updated successfuly !");
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();
        return redirect("/")->with("message", "Listing deleted successfully !");
    }

    public function manage() {
        return view("listings.manage", [
            "listings" => auth()->user()->listings
        ]);
    }

}
