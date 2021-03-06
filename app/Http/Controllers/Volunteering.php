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

class Volunteering extends Controller
{

    protected $item_type = "volunteering";


    public function index(Request $request)
    {
        /*
         *
         * Filter queries
         *
         */



        $data = Offer::where('status', 1)

            ->when($request->has('section'), function ($query) use ($request) {

                $sections = explode(',', trim($request->input('section'), '[]'));

                $sections_filter = [];
                foreach ($sections as $section) {

                    if($section == 'volunteering') {
                        $sections_filter[] = 0;
                    }

                    if($section == 'internship') {
                        $sections_filter[] = 1;
                    }
                }

                //dd($sections_filter);

                $sections_filter = array(1);
                return $query->whereIn('offer_type', $sections_filter);
            })

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

        $specialities = OfferSpecialization::orderBy('name')->get();          $key = $specialities->search(function($item) {             return $item->id == 22;         });         $chunk = $specialities->pull($key);         $specialities->push($chunk);
        $cities = City::all();

        $workTime = WorkTimeType::all();

        $filters = array();

        $filters['section'] = array('data' => $section, 'type' => 'checkbox', 'name' => 'section');
        $filters['cities'] = array('data' => $cities, 'type' => 'select', 'name' => 'city');
        $filters['specialities'] = array('data' => $specialities, 'type' => 'select', 'name' => 'speciality');
        $filters['age'] = array('data' => $ages, 'type' => 'select', 'name' => 'age');
        $filters['date'] = array('data' => $date, 'type' => 'radio', 'name' => 'publish_date');

        $content = null;


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
            'email' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $organisation = Auth::user()->id;

        $volunteering = new Offer([
            'title' => $request->input('title'),
            'city_id' => $request->input('city'),
            'age' => $request->input('age'),
            'speciality' => $request->input('speciality'),
            'contact' => $request->input('contactPerson'),
            'offer_type' => 0,
            'description' => $request->input('description'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'alt_phone' => $request->input('alt_phone'),
            'organisation_id' => $organisation,
        ]);
        $role = Auth::user()->role;
        if($role = \App\Organisation::AUTHOR) {
            $volunteering->status = 1;
            $volunteering->published_at = new Date();
        }
        $volunteering->save();

        if($request->ajax()){
            return response()->json([ "message" => "Объявление создано" ], 200);
        }

        return redirect()->route('organisation.volunteerings.edit');
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

        $volunteering = Offer::findOrFail($id);

        if((($volunteering->organisation_id == Auth::user()->id)) || (Auth::user()->role == 0) || (Auth::user()->role == \App\Organisation::AUTHOR)) {
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

            return view('frontend.volunteering.edit')->with('volunteering', $volunteering)->with('cities', $cities)->with('ages', $ages)->with('specialities', $specialities)->with('salary_types', $salaryType)->with('work_times', $workTime);
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
            'email' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $volunteering = Offer::findOrFail($id);

        if(($volunteering->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0) || (Auth::user()->role == \App\Organisation::AUTHOR)) {
            $volunteering->title = $request->input('title');
            $volunteering->city_id = $request->input('city');
            $volunteering->age = $request->input('age');
            $volunteering->speciality = $request->input('speciality');
            $volunteering->contact = $request->input('contactPerson');
            $volunteering->description = $request->input('description');
            $volunteering->phone = $request->input('phone');
            $volunteering->email = $request->input('email');
            $volunteering->alt_phone = $request->input('alt_phone');


            if((Auth::user()->role !== 0) && (Auth::user()->role !== \App\Organisation::AUTHOR)) {
                $volunteering->status = 0;
            }

            $volunteering->save();

            if($request->ajax()){
                return response()->json([ "message" => "Объявление сохранено"], 200);
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
        $volunteering = Offer::findOrFail($id);
        if(($volunteering->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0) || ( Auth::user()->role == \App\Organisation::AUTHOR)) {

            $volunteering->delete();
            return response()->json([ "message" => "Объявление удалено" ], 200);

        }else {
            return response()->json([ "message" => "Удаление запрещено" ], 403);
        }
    }


    public function archive($id)
    {
        $volunteering = Offer::findOrFail($id);
        if(($volunteering->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)|| ( Auth::user()->role == \App\Organisation::AUTHOR)) {

            $volunteering->status = 2;
            $volunteering->save();


            return response()->json([ "message" => "Объявление заархивировано" ], 200);

        }else {
            return response()->json([ "message" => "Архивация запрещена" ], 403);
        }
    }

    public function unarchive($id)
    {
        $volunteering = Offer::findOrFail($id);
        if(($volunteering->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)|| ( Auth::user()->role == \App\Organisation::AUTHOR)) {

            $volunteering->status = 0;
            $volunteering->save();

            return response()->json([ "message" => "Объявление разархивировано" ], 200);

        }else {
            return response()->json([ "message" => "Разархивация запрещена" ], 403);
        }
    }
}
