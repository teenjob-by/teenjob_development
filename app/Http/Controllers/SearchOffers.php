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

class SearchOffers extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOld(Request $request)
    {
        $filters = $request->only(['date', 'type_id', 'speciality']);
        $age_filter=[
            ['age', '>=', 14]
        ];
        if($request->has('age')) {
            $age_filter=[
                ['age', '<=', $request->input('age')]
            ];
        }

        $city_id_array = array(120);
        if($request->has('city_id')) {
            array_push($city_id_array, $request->input('city_id'));
        }
        var_dump($city_id_array);

        $offer_types_array = array();
        if($request->has('volunteering'))
            array_push($offer_types_array, 0);
        if($request->has('internship'))
            array_push($offer_types_array, 1);
        if($request->has('job'))
            array_push($offer_types_array, 2);

        if(empty($offer_types_array))
            $offer_types_array = array(0, 1, 2);

        $date_filter=[
            ['published_at', '<=', Carbon::now()]
        ];
        if($request->has('publish_date')) {
            $sub_days = 0;
            if($request->input('publish_date') == 3)
                $sub_days = 3;
            if($request->input('publish_date') == 'week')
                $sub_days = 7;
            if($request->input('publish_date') == 'month')
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
                    $query->where('title', 'like', '%'.$request->input('query').'%')
                        ->orWhere('description', 'like', '%'.$request->input('query').'%')
                        ->orWhere('cities.name', 'like', '%'.$request->input('query').'%');
                })
                ->where($filters)
                ->whereIn('offer_type', $offer_types_array)
                ->whereIn('city_id', $city_id_array)
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
                ->whereIn('city_id', $city_id_array)
                ->whereIn('offer_type', $offer_types_array)
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

        $specialities = OfferSpecialization::orderBy('name')->get();
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);
        if (count ( $offers ) > 0)
            return view('site.offers.index')->with('offers', $offers)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages);

        return view ( 'site.offers.index' )->with ('query_message', 'Ничего не найдено!' )->with('offers', $offers)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages);

    }

    public function index(Request $request)
    {
        $filters = $request->only(['date', 'type_id', 'speciality']);
        $age_filter=[
            ['age', '>=', 14]
        ];
        if($request->has('age')) {
            $age_filter=[
                ['age', '<=', $request->input('age')]
            ];
        }

        $city_id_array = array(120);
        $city_id = null;
        if($request->has('city_id')) {
            array_push($city_id_array, $request->input('city_id'));
        }
        else
            $city_id_array = array();

        $offer_types_array = array();
        if($request->has('volunteering'))
            array_push($offer_types_array, 0);
        if($request->has('internship'))
            array_push($offer_types_array, 1);
        if($request->has('job'))
            array_push($offer_types_array, 2);

        if(empty($offer_types_array))
            $offer_types_array = array(0, 1, 2);


        $date_filter=[
            ['published_at', '<=', Carbon::now()]
        ];
        if($request->has('publish_date')) {
            $sub_days = 0;
            if($request->input('publish_date') == 3)
                $sub_days = 3;
            if($request->input('publish_date') == 'week')
                $sub_days = 7;
            if($request->input('publish_date') == 'month')
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
                    $query->where('title', 'like', '%'.$request->input('query').'%')
                        ->orWhere('description', 'like', '%'.$request->input('query').'%')
                        ->orWhere('cities.name', 'like', '%'.$request->input('query').'%');
                })
                ->where($filters)
                ->when($request->has('city_id'), function ($query) use ($city_id_array) {
                    return $query->whereIn('city_id', $city_id_array);
                })
                ->whereIn('offer_type', $offer_types_array)
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
                ->when($request->has('city_id'), function ($query) use ($city_id_array) {
                    return $query->whereIn('city_id', $city_id_array);
                })
                ->whereIn('offer_type', $offer_types_array)
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

        $specialities = OfferSpecialization::orderBy('name')->get();
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);



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
        $specialities = OfferSpecialization::orderBy('name')->get();
        $htmlOutput = "";
        foreach ($specialities as $speciality) {
            $htmlOutput = $htmlOutput."<option value=".$speciality->id.">".$speciality->name."</option>\n";
        }

        return $htmlOutput;
    }

    public function getCities()
    {
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);

        $htmlOutput = "";
        foreach ($cities as $city) {
            $htmlOutput = $htmlOutput."<option value=".$city->id.">".$city->name."</option>\n";
        }

        return $htmlOutput;
    }




}
