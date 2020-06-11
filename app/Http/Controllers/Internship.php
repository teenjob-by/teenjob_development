<?php

namespace App\Http\Controllers;

use App\Offer;
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

class Internship extends Controller
{

    protected $item_type = "internship";


    public function index(Request $request)
    {
        /*
         *
         * Filter queries
         *
         */

        $data = Offer::where('status', 1)

            ->where('offer_type', 1)

            ->when($request->has('city'), function ($query) use ($request) {
                if($request->input('city') !== "120") {
                    return $query->whereIn('city_id', [$request->input('city'), "120"]);
                }
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
                return $query->where(
                    function ($query) use ($request) {
                        return $query->where('title', 'like', '%'.$request->input('query').'%')
                            ->orWhere('description', 'like', '%'.$request->input('query').'%')
                            ->orWhere('cities.name', 'like', '%'.$request->input('query').'%');
                    });
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

        $specialities = OfferSpecialization::orderBy('name')->get();          $key = $specialities->search(function($item) {             return $item->id == 22;         });         $chunk = $specialities->pull($key);         $specialities->push($chunk);
        $cities = City::all();

        $workTime = WorkTimeType::all();

        $filters = array();
        $filters['cities'] = array('data' => $cities, 'type' => 'select', 'name' => 'city');
        $filters['specialities'] = array('data' => $specialities, 'type' => 'select', 'name' => 'speciality');
        $filters['age'] = array('data' => $ages, 'type' => 'select', 'name' => 'age');
        $filters['date'] = array('data' => $date, 'type' => 'radio', 'name' => 'publish_date');


        if ($request->ajax()) {
            $content = view('frontend.'. $this->item_type .'.ajax')->with('data', $data)->with('ajax', true)->with('page', $data->currentPage())->with('filters', $filters)->with('item_type', $this->item_type);
        }
        else {
            $content = view ( 'frontend.search' )->with('data', $data)->with('filters', $filters)->with('item_type', $this->item_type);
        }

        return response($content,200) ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organisation = Auth::user()->id;
        $specialities = OfferSpecialization::orderBy('name')->get();          $key = $specialities->search(function($item) {             return $item->id == 22;         });         $chunk = $specialities->pull($key);         $specialities->push($chunk);
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);

        $workTime = WorkTimeType::all();

        $salaryType = SalaryType::all();


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

        return view('frontend.'. $this->item_type .'.create')->with("organisation", $organisation)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages)->with('work_times', $workTime)->with('salary_types', $salaryType);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'city' => ['required'],
            'age' => ['required'],
            'speciality' => ['required'],
            'description' => ['required'],
            'contactPerson' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $organisation = Auth::user()->id;

        $internship = new Offer([
            'title' => $request->input('title'),
            'city_id' => $request->input('city'),
            'age' => $request->input('age'),
            'speciality' => $request->input('speciality'),
            'contact' => $request->input('contactPerson'),
            'offer_type' => 1,
            'description' => $request->input('description'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'alt_phone' => $request->input('alt_phone'),
            'organisation_id' => $organisation,
        ]);
        $internship->save();

        if($request->ajax()){
            return response()->json([ "message" => "Объявление создано" ], 200);
        }

        return redirect()->route('organisation.internships.edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Offer::findOrFail($id);

        return view('frontend.'. $this->item_type .'.card', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $internship = Offer::findOrFail($id);

        if((($internship->organisation_id == Auth::user()->id)) || (Auth::user()->role == 0)) {
            $specialities = OfferSpecialization::orderBy('name')->get();          $key = $specialities->search(function($item) {             return $item->id == 22;         });         $chunk = $specialities->pull($key);         $specialities->push($chunk);
            $cities = City::all();
            $lastCity = $cities->pop();
            $cities = $cities->prepend($lastCity);

            $workTime = WorkTimeType::all();

            $salaryType = SalaryType::all();


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

            return view('frontend.internship.edit')->with('internship', $internship)->with('cities', $cities)->with('ages', $ages)->with('specialities', $specialities)->with('salary_types', $salaryType)->with('work_times', $workTime);
        }
        else {
            return response()->json([ "message" => "Редактирование запрещено" ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'city' => ['required'],
            'age' => ['required'],
            'speciality' => ['required'],
            'description' => ['required'],
            'contactPerson' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $internship = Offer::findOrFail($id);

        if(($internship->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {
            $internship->title = $request->input('title');
            $internship->city_id = $request->input('city');
            $internship->age = $request->input('age');
            $internship->speciality = $request->input('speciality');
            $internship->contact = $request->input('contactPerson');
            $internship->description = $request->input('description');
            $internship->phone = $request->input('phone');
            $internship->email = $request->input('email');
            $internship->alt_phone = $request->input('alt_phone');


            if(Auth::user()->role !== 0) {
                $internship->status = 0;
            }

            $internship->save();

            if($request->ajax()){
                return response()->json([ "message" => "Объявление сохранено" ], 200);
            }

            return redirect()->route('organisation.index');
        }
        else {
            return response()->json([ "message" => "Редактирование запрещено" ], 403);
        }


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $internship = Offer::findOrFail($id);
        if(($internship->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {

            $internship->delete();
            return response()->json([ "message" => "Объявление удалено" ], 200);

        }else {
            return response()->json([ "message" => "Удаление запрещено" ], 403);
        }
    }


    public function archive($id)
    {
        $internship = Offer::findOrFail($id);
        if(($internship->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {

            $internship->status = 2;
            $internship->save();


            return response()->json([ "message" => "Объявление заархивировано" ], 200);

        }else {
            return response()->json([ "message" => "Архивация запрещена" ], 403);
        }
    }

    public function unarchive($id)
    {
        $internship = Offer::findOrFail($id);
        if(($internship->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {

            $internship->status = 0;
            $internship->save();

            return response()->json([ "message" => "Объявление разархивировано" ], 200);

        }else {
            return response()->json([ "message" => "Разархивация запрещена" ], 403);
        }
    }
}
