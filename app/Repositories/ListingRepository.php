<?php

namespace App\Repositories;

use App\Formfields\ListingFormFields;
use App\Models\Listing;

class ListingRepository {

    protected $listing;

    public function __construct(Listing $listing)
    {
        $this->listing = $listing;
    }

    public function saveListing($listingData) {

        $listing = new $this->listing;

        $listing->title = $listingData[Listing::titleColumnName];
        $listing->description = $listingData[Listing::descriptionColumnName];
        $listing->email = $listingData[Listing::emailColumnName];
        $listing->tags = $listingData[Listing::tagsColumnName];
        $listing->website = $listingData[Listing::websiteColumnName];
        $listing->location = $listingData[Listing::locationColumnName];
        $listing->company = $listingData[Listing::companyColumnName];
        $listing->user_id = $listingData[Listing::userIDColumnName];
        if(isset($listingData[ListingFormFields::logoFieldName]))
            $listing->logo = $listingData[ListingFormFields::logoFieldName];
            
        $listing->save();

        return $listing;
    }

    public function updateListing($listingData, Listing $listing) {
            
        $listing->update($listingData);

        return $listing;
    }
}