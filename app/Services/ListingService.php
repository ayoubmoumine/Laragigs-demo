<?php 

namespace App\Services;

use App\Formfields\ListingFormFields;
use App\Models\Listing;
use App\Repositories\ListingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

class ListingService {

    protected $listingRepository;
    protected $formFields;

    public function __construct(ListingRepository $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    /**
     * @var Request $request
     */
    public function saveListing(Request $request) {
        Validator::make($request->all(), [
            ListingFormFields::titleFieldName => "required",
            ListingFormFields::descriptionFieldName => "required",
            ListingFormFields::emailFieldName => ["required", "email", Rule::unique("listings", "email")],
            ListingFormFields::tagsFieldName => "required",
            ListingFormFields::webisteFieldName => "required",
            ListingFormFields::locationFieldName => "required",
            ListingFormFields::companyFieldName => "required"
        ])->validate();
        
        $this->setFormFields($request);

        $this->formFields[Listing::userIDColumnName] = auth()->user()->id;

        $listing = $this->listingRepository->saveListing($this->formFields);
        
        return $listing;
    }

    public function updateListing(Request $request, Listing $listing) {
        
        Validator::make($request->all(), [
            ListingFormFields::titleFieldName => "required",
            ListingFormFields::descriptionFieldName => "required",
            ListingFormFields::emailFieldName => ["required", "email"],
            ListingFormFields::tagsFieldName => "required",
            ListingFormFields::webisteFieldName => "required",
            ListingFormFields::locationFieldName => "required",
            ListingFormFields::companyFieldName => "required"
        ])->validate();
        
        $this->setFormFields($request);

        $listing = $this->listingRepository->updateListing($this->formFields, $listing);

        return $listing;
    }

    public function setFormFields(Request $request) {

        $this->formFields = $request->except(['_token', '_method']);;

        if($request->hasFile(ListingFormFields::logoFieldName)) {
            $this->formFields[ListingFormFields::logoFieldName] = $request->file(ListingFormFields::logoFieldName)->store("logos", "public");
        }
    }

}