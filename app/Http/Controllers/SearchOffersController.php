<?php

namespace App\Http\Controllers;

use App\Offer;
use App\OfferSpecialization;
use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;

class SearchOffersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOld(Request $request)
    {
        $filters = $request->only(['city_id', 'date', 'type_id', 'speciality']);
        $age_filter=[
            ['age', '>=', 14]
        ];
        if($request->has('age')) {
            $age_filter=[
                ['age', '<=', $request->get('age')]
            ];
        }
        $offer_type = -1;
        if($request->has('volunteering'))
            $offer_type = $offer_type + 1;
        if($request->has('internship'))
            $offer_type = $offer_type + 2;
        //TODO

        if(($offer_type !== 2) && ($offer_type !== -1))
            $filters['offer_type'] = $offer_type;

        $date_filter=[
            ['published_at', '<=', Carbon::now()]
        ];
        if($request->has('publish_date')) {
            $sub_days = 0;
            if($request->get('publish_date') == 3)
                $sub_days = 3;
            if($request->get('publish_date') == 'week')
                $sub_days = 7;
            if($request->get('publish_date') == 'month')
                $sub_days = 30;


            $date_filter=[
                ['published_at', '>=', Carbon::now()->subDays($sub_days)->startOfDay()],
                ['published_at', '<=', Carbon::now()->endOfDay()]
            ];
        }

        if($request->has('query')) {

            $offers = Offer::where('status', 1)
                ->join('cities', 'offers.city_id', '=', 'cities.id')
                ->select('offers.*', 'cities.name as city_name')
                ->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->get('query').'%')
                        ->orWhere('description', 'like', '%'.$request->get('query').'%')
                        ->orWhere('cities.name', 'like', '%'.$request->get('query').'%');
                })
                ->where($filters)
                ->where($age_filter)
                ->where($date_filter)
                ->orderBy('published_at', 'desc')
                ->paginate(30)
                ->onEachSide(1);
        }
        else{

            $offers = Offer::where('status', 1)
                ->join('cities', 'offers.city_id', '=', 'cities.id')
                ->select('offers.*', 'cities.name as city_name')
                ->orderBy('published_at', 'desc')
                ->where($filters)
                ->where($age_filter)
                ->where($date_filter)
                ->paginate(30)
                ->onEachSide(1);
        }

        $pagination = $offers->appends($_GET);


        $ages = [
            [
                'value' => 14,
                'name'=>'14'
            ],
            [
                'value' => 15,
                'name'=>'15'
            ],
            [
                'value' => 16,
                'name'=>'16'
            ],
            [
                'value' => 17,
                'name'=>'17'
            ]
        ];

        $specialities = OfferSpecialization::all();
        $cities = City::all();
        if (count ( $offers ) > 0)
            return view('site.offers.index')->with('offers', $offers)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages);

        return view ( 'site.offers.index' )->with ('query_message', 'Ничего не найдено!' )->with('offers', $offers)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages);

    }

    public function index(Request $request)
    {
        $filters = $request->only(['city_id', 'date', 'type_id', 'speciality']);
        $age_filter=[
            ['age', '>=', 14]
        ];
        if($request->has('age')) {
            $age_filter=[
                ['age', '<=', $request->get('age')]
            ];
        }
        $offer_type = -1;
        if($request->has('volunteering'))
            $offer_type = $offer_type + 1;
        if($request->has('internship'))
            $offer_type = $offer_type + 2;

        if(($offer_type !== 2) && ($offer_type !== -1))
            $filters['offer_type'] = $offer_type;

        $date_filter=[
            ['published_at', '<=', Carbon::now()]
        ];
        if($request->has('publish_date')) {
            $sub_days = 0;
            if($request->get('publish_date') == 3)
                $sub_days = 3;
            if($request->get('publish_date') == 'week')
                $sub_days = 7;
            if($request->get('publish_date') == 'month')
                $sub_days = 30;


            $date_filter=[
                ['published_at', '>=', Carbon::now()->subDays($sub_days)->startOfDay()],
                ['published_at', '<=', Carbon::now()->endOfDay()]
            ];
        }

        if($request->has('query')) {

            $offers = Offer::where('status', 1)
                ->join('cities', 'offers.city_id', '=', 'cities.id')
                ->select('offers.*', 'cities.name as city_name')
                ->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->get('query').'%')
                        ->orWhere('description', 'like', '%'.$request->get('query').'%')
                        ->orWhere('cities.name', 'like', '%'.$request->get('query').'%');
                })
                ->where($filters)
                ->where($age_filter)
                ->where($date_filter)
                ->orderBy('published_at', 'desc')
                ->paginate(30)
                ->onEachSide(1);
        }
        else{

            $offers = Offer::where('status', 1)
                ->join('cities', 'offers.city_id', '=', 'cities.id')
                ->select('offers.*', 'cities.name as city_name')
                ->orderBy('published_at', 'desc')
                ->where($filters)
                ->where($age_filter)
                ->where($date_filter)
                ->paginate(30)
                ->onEachSide(1);
        }

        $pagination = $offers->appends($_GET);


        $ages = [
            [
                'value' => 14,
                'name'=>'14'
            ],
            [
                'value' => 15,
                'name'=>'15'
            ],
            [
                'value' => 16,
                'name'=>'16'
            ],
            [
                'value' => 17,
                'name'=>'17'
            ]
        ];

        $specialities = OfferSpecialization::all();
        $cities = City::all();



            if ($request->ajax()) {
                return view('presultoffers')->with('data', $offers)->with('ajax', true)->with('page', $offers->currentPage());
            }
            return view('site.offers.dynTest')->with('data', $offers)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages)->with('ajax', false)->with('page', $offers->currentPage());




    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    public function getSpecialities()
    {
        $specialities = OfferSpecialization::all();
        $htmlOutput = "";
        foreach ($specialities as $speciality) {
            $htmlOutput = $htmlOutput."<option value=".$speciality->id.">".$speciality->name."</option>\n";
        }

        return $htmlOutput;
    }

    public function getCities()
    {
        $cities = City::all();
        $htmlOutput = "";
        foreach ($cities as $city) {
            $htmlOutput = $htmlOutput."<option value=".$city->id.">".$city->name."</option>\n";
        }

        return $htmlOutput;
    }




}
