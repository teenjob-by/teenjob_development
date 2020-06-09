<?php

namespace App\Http\Controllers\Api\v1;

use App\Organisation as OrganisationModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Event as EventModel;
use App\Offer as OfferModel;


class AdminApi extends Controller
{


    public function getCounters()
    {
        $organisations = OrganisationModel::where('status', 0)->where('role', 1)->get();
        $events = EventModel::where('status', 0)->get();
        $internships = OfferModel::where('offer_type', 1)->where('status', 0)->get();
        $volunteerings = OfferModel::where('offer_type', 0)->where('status', 0)->get();
        $jobs = OfferModel::where('offer_type', 2)->where('status', 0)->get();

        $data = [
            "organisationCount" => count($organisations),
            "eventCount" => count($events),
            "internshipCount" => count($internships),
            "jobCount" => count($jobs),
            "volunteeringCount" => count($volunteerings),
        ];

        return response()->json([ "data" => $data ], 200);
    }


}