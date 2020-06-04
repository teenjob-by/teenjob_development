<?php

namespace App\Http\Controllers;

use App\Offer as OfferModel;
use App\OfferSpecialization;
use App\City;
use App\WorkTimeType;
use App\SalaryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class Offer extends Controller
{

    protected $item_type = "volunteering";


    public function index(Request $request)
    {

        $data = OfferModel::where('status', 1)

            ->where('offer_type', 0)

            ->when($request->has('city'), function ($query) use ($request) {
                return $query->where('city_id', $request->input('city'));
            })

            ->when($request->has('speciality'), function ($query) use ($request){
                return $query->where('speciality', $request->input('speciality'));
            })


            ->where(function ($query) use ($request) {

                $minAge = 14;

                if($request->has('age')) {
                    return $query->where('age', '<=', $request->input('age'));
                }
                else {
                    return $query->where('age', '>=', $minAge);
                }
            })

            ->where(function ($query) use ($request){

                $now = Carbon::now()->endOfDay();
                $last = Carbon::now()->endOfDay();

                $date_filter=[
                    ['published_at', '<=', $now]
                ];

                if($request->has('publish_date')) {

                    if($request->input('publish_date') == 3)
                        $last = $last->subDays($request->input('publish_date'));
                    if($request->input('publish_date') == '7')
                        $last = $last->subWeek();
                    if($request->input('publish_date') == '30')
                        $last = $last->subMonth();

                    $last = $last->startOfDay();

                    $date_filter=[
                        ['published_at', '<=', $now],
                        ['published_at', '>=', $last]
                    ];
                }

                return $query->where($date_filter);
            })


            ->join('cities', 'offers.city_id', '=', 'cities.id')
            ->select('offers.*', 'cities.name as city_name')
            ->when($request->has('query'), function ($query) use ($request){
                return $query->where('title', 'like', '%'.$request->input('query').'%')
                    ->orWhere('description', 'like', '%'.$request->input('query').'%')
                    ->orWhere('cities.name', 'like', '%'.$request->input('query').'%');
            })
            ->orderBy('published_at', 'desc')
            ->paginate(15)
            ->onEachSide(1);

        /*
         *
         * Filters collection
         *
         */


        $ages = collect([
            (object)[
                'id' => 14,
                'name'=>'14'
            ],
            (object)[
                'id' => 15,
                'name'=>'15'
            ],
            (object)[
                'id' => 16,
                'name'=>'16'
            ],
            (object)[
                'id' => 17,
                'name'=>'17'
            ]
        ]);

        $date = [
            [
                'value' => 0,
                'name'=>'today'
            ],
            [
                'value' => 3,
                'name'=>'three'
            ],
            [
                'value' => 7,
                'name'=>'week'
            ],
            [
                'value' => 30,
                'name'=>'month'
            ]
        ];

        $section = [
            [
                'value' => 'volunteering',
                'name'=>'volunteering'
            ],
            [
                'value' => 'internship',
                'name'=>'internship'
            ],

        ];

        $specialities = OfferSpecialization::orderBy('name')->get();
        $cities = City::all();

        $workTime = WorkTimeType::all();

        $filters = array();


        $filters['cities'] = array('data' => $cities, 'type' => 'select', 'name' => 'city');
        $filters['specialities'] = array('data' => $specialities, 'type' => 'select', 'name' => 'speciality');
        $filters['age'] = array('data' => $ages, 'type' => 'select', 'name' => 'age');
        $filters['date'] = array('data' => $date, 'type' => 'radio', 'name' => 'publish_date');


        if ($request->ajax()) {
            return view('frontend.offer.ajax')->with('data', $data)->with('ajax', true)->with('page', $data->currentPage())->with('filters', $filters)->with('item_type', $this->item_type);
        }

        return view ( 'frontend.search' )->with('data', $data)->with('filters', $filters)->with('item_type', $this->item_type);

    }
}
