<?php

namespace App\Http\Controllers;

use App\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Event;
use App\Offer;
use App\City;
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Input;
use App\OfferSpecialization;
use App\WorkTimeType;
use App\EventType;

class Search extends Controller
{

    protected $item_type = "search";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataOffers = Offer::where('status', 1)
            ->join('cities', 'offers.city_id', '=', 'cities.id')
            ->select('offers.*', 'cities.name as city_name')
            ->when($request->has('query'), function ($query) use($request) {
                return $query->where('title', 'like', '%'.$request->input('query').'%')
                    ->orWhere('description', 'like', '%'.$request->input('query').'%')
                    ->orWhere('cities.name', 'like', '%'.$request->input('query').'%');
            })
            ->orderBy('published_at', 'desc')->get();

        $dataEvents = Event::whereIn('status', [1,2])
            ->join('cities', 'events.city_id', '=', 'cities.id')
            ->select('events.*', 'cities.name as city_name')
            ->when($request->has('query'), function ($query) use($request) {
                return $query->where('title', 'like', '%'.$request->input('query').'%')
                    ->orWhere('description', 'like', '%'.$request->input('query').'%')
                    ->orWhere('name', 'like', '%'.$request->input('query').'%')
                    ->orWhere('cities.name', 'like', '%'.$request->input('query').'%');
            })
            ->orderBy('date_start', 'asc')->get();



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

        $date_start = [
            [
                'value' => 'today',
                'name'=>'today'
            ],
            [
                'value' => 'tomorrow',
                'name'=>'tomorrow'
            ],
            [
                'value' => 'week',
                'name'=>'week'
            ],
            [
                'value' => 'next-week',
                'name'=>'next-week'
            ],
            [
                'value' => 'past',
                'name'=>'past'
            ]
        ];

        $type = [
            [
                'value' => 'payment',
                'name'=>'payment'
            ],
            [
                'value' => 'free',
                'name'=>'free'
            ],
            [
                'value' => 'donate',
                'name'=> 'donate'
            ],
        ];

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

        $specialities = OfferSpecialization::all();

        $workTime = WorkTimeType::all();

        $cities = City::all();

        $filters = array();
        $filters['cities'] = array('data' => $cities, 'type' => 'select', 'name' => 'city');
        $filters['age'] = array('data' => $ages, 'type' => 'select', 'name' => 'age');
        $filters['date_start'] = array('data' => $date_start, 'type' => 'checkbox', 'name' => 'date-start');
        $filters['type'] = array('data' => $type, 'type' => 'checkbox', 'name' => 'type');
        $filters['specialities'] = array('data' => $specialities, 'type' => 'select', 'name' => 'speciality');
        $filters['salary'] = array('data' => array(), 'type' => 'interval', 'name' => 'salary');
        $filters['workTime'] = array('data' => $workTime, 'type' => 'select', 'name' => 'workTime');
        $filters['publish_date'] = array('data' => $date, 'type' => 'radio', 'name' => 'publish_date');



        $data = array(
            "job" => [],
            "internship" => [],
            "volunteering" => [],
            //"event" => []
        );

        $notEmpty = false;
        if(count($dataOffers) > 0) {
            foreach ($dataOffers as $item) {
                switch ($item->offer_type) {
                    case 0:
                        array_push($data['volunteering'], $item);
                        break;
                    case 1:
                        array_push($data['internship'], $item);
                        break;
                    case 2:
                        array_push($data['job'], $item);
                        break;
                }
            }
            if(count($data['job']) > 0) {
                unset($filters['date_start']);
                unset($filters['type']);
                $notEmpty = true;
            }else {
                unset($data['job']);
            }

            if((count($data['volunteering']) > 0) || (count($data['internship']) > 0)) {
                unset($filters['salary']);
                unset($filters['workTime']);
                unset($filters['date_start']);
                unset($filters['type']);
                $notEmpty = true;
             }

            if(count($data['volunteering']) == 0) {
                unset($data['volunteering']);
            }



            if(count($data['internship']) == 0) {
                unset($data['internship']);
            }


        }
       if(count($dataEvents) > 0) {

            unset($filters['specialities']);
            unset($filters['salary']);
            unset($filters['workTime']);
            unset($filters['publish_date']);

        }


        if ($request->ajax()) {
            return view('frontend.'. $this->item_type .'.ajax')->with('data', $data)->with('dataEvents', $dataEvents)->with('ajax', true)->with('page', $dataOffers->currentPage())->with('filters', $filters)->with('item_type', $this->item_type)->with('not_empty', $notEmpty);
        }

        return view ( 'frontend.search' )->with('data', $data)->with('dataEvents', $dataEvents)->with('filters', $filters)->with('item_type', $this->item_type)->with('not_empty', $notEmpty);

    }
}
