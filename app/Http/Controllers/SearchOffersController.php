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
    public function index(Request $request)
    {
        $filters = $request->only(['city_id', 'date', 'type_id', 'speciality']);
        $age_filter=[
            ['age', '>=', 14]
        ];
        if($request->has('age')) {
            $age_filter=[
                ['age', '>=', $request->get('age')]
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
                ->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->get('query').'%')
                        ->orWhere('description', 'like', '%'.$request->get('query').'%');
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
                'name'=>'14+'
            ],
            [
                'value' => 15,
                'name'=>'15+'
            ],
            [
                'value' => 16,
                'name'=>'16+'
            ],
            [
                'value' => 17,
                'name'=>'17+'
            ]
        ];

        $specialities = OfferSpecialization::all();
        $cities = City::all();
        if (count ( $offers ) > 0)
            return view('site.offers.index')->with('offers', $offers)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages);

        return view ( 'site.offers.index' )->with ('query_message', 'Ничего не найдено!' )->with('offers', $offers)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages);

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


}
