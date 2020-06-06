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

class Job extends Controller
{

    protected $item_type = "job";


    public function index(Request $request)
    {
        /*
         *
         * Filter queries
         *
         */

        $data = Offer::where('status', 1)

            ->where(function ($query) use ($request) {


                if($request->has('section')) {
                    $sections = explode(',', trim($request->input('section'), '[]'));

                    $sections_filter = [];
                    foreach ($sections as $section) {

                        if($section == 'job') {
                            $sections_filter[] = 2;
                        }

                        if($section == 'internship') {
                            $sections_filter[] = 1;
                        }
                    }

                    return $query->whereIn('offer_type', $sections_filter);
                }
                else {
                    return $query->whereIn('offer_type', [1, 2]);
                }
            })

            ->when($request->has('city'), function ($query) use ($request) {
                return $query->where('city_id', $request->input('city'));
            })

            ->when($request->has('speciality'), function ($query) use ($request){
                return $query->where('speciality', $request->input('speciality'));
            })

            ->when($request->has('workTime'), function ($query) use ($request){
                return $query->where('work_time_type_id', $request->input('workTime'));
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
                    if($request->input('publish_date') == 7)
                        $last = $last->subWeek();
                    if($request->input('publish_date') == 30)
                        $last = $last->subMonth();

                    $last = $last->startOfDay();



                    $date_filter=[
                        ['published_at', '<=', $now],
                        ['published_at', '>=', $last]
                    ];
                }

                return $query->where($date_filter);
            })

            ->when(($request->has('salary-min') || $request->has('salary-max')), function ($query) use ($request){

                $min = 0;

                if($request->has('salary-min'))
                    $min = $request->input('salary-min');

                $max = 999999999;

                if($request->has('salary-max'))
                    $max = $request->input('salary-max');

                return $query->whereBetween('salary', [$min, $max]);
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

        $specialities = OfferSpecialization::orderBy('name')->get();
        $cities = City::all();

        $workTime = WorkTimeType::all();

        $filters = array();
        $section = [
            [
                'value' => 'job',
                'name'=>'job'
            ],
            [
                'value' => 'internship',
                'name'=>'internship'
            ],

        ];

        $filters['cities'] = array('data' => $cities, 'type' => 'select', 'name' => 'city');
        $filters['section'] = array('data' => $section, 'type' => 'checkbox', 'name' => 'section');
        $filters['specialities'] = array('data' => $specialities, 'type' => 'select', 'name' => 'speciality');
        //$filters['salary'] = array('data' => array(), 'type' => 'interval', 'name' => 'salary');
        $filters['workTime'] = array('data' => $workTime, 'type' => 'select', 'name' => 'workTime');
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
        $specialities = OfferSpecialization::orderBy('name')->get();
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
            'phone' => ['required', 'min:3','max:255'],
            'email' => ['required', 'email', 'max:255'],
            'salaryType' => ['required'],
            'workTime' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $organisation = Auth::user()->id;

        $job = new Offer([
            'title' => $request->input('title'),
            'city_id' => $request->input('city'),
            'age' => $request->input('age'),
            'speciality' => $request->input('speciality'),
            'contact' => $request->input('contactPerson'),
            'offer_type' => 2,
            'description' => $request->input('description'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'alt_phone' => $request->input('alt_phone'),
            'salary' => $request->input('salary'),
            'salary_type_id' => $request->input('salaryType'),
            'work_time_type_id' => $request->input('workTime'),
            'organisation_id' => $organisation,
        ]);
        $job->save();

        if($request->ajax()){
            return response()->json([ "message" => "Объявление создано" ], 200);
        }

        return redirect()->route('organisation.jobs.edit');
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

        $job = Offer::findOrFail($id);

        if((($job->organisation_id == Auth::user()->id)) || (Auth::user()->role == 0)) {
            $specialities = OfferSpecialization::orderBy('name')->get();
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

            return view('frontend.job.edit')->with('job', $job)->with('cities', $cities)->with('ages', $ages)->with('specialities', $specialities)->with('salary_types', $salaryType)->with('work_times', $workTime);
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
            'title' => ['required', 'min:3','max:255'],
            'city' => ['required'],
            'age' => ['required'],
            'speciality' => ['required'],
            'description' => ['required','max:255'],
            'contactPerson' => ['required', 'min:3','max:255'],
            'phone' => ['required', 'min:3','max:255'],
            'email' => ['email', 'max:255'],
            'salaryType' => ['required'],
            'workTime' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $job = Offer::findOrFail($id);

        if(($job->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {
            $job->title = $request->input('title');
            $job->city_id = $request->input('city');
            $job->age = $request->input('age');
            $job->speciality = $request->input('speciality');
            $job->contact = $request->input('contactPerson');
            $job->description = $request->input('description');
            $job->phone = $request->input('phone');
            $job->email = $request->input('email');
            $job->alt_phone = $request->input('alt_phone');
            $job->salary = $request->input('salary');
            $job->salary_type_id = $request->input('salaryType');
            $job->work_time_type_id = $request->input('workTime');

            if(Auth::user()->role !== 0) {
                $job->status = 0;
            }

            $job->save();

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
        $job = Offer::findOrFail($id);
        if(($job->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {

            $job->delete();
            return response()->json([ "message" => "Объявление удалено" ], 200);

        }else {
            return response()->json([ "message" => "Удаление запрещено" ], 403);
        }
    }


    public function archive($id)
    {
        $job = Offer::findOrFail($id);
        if(($job->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {

            $job->status = 2;
            $job->save();


            return response()->json([ "message" => "Объявление заархивировано" ], 200);

        }else {
            return response()->json([ "message" => "Архивация запрещена" ], 403);
        }
    }

    public function unarchive($id)
    {
        $job = Offer::findOrFail($id);
        if(($job->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {

            $job->status = 0;
            $job->save();

            return response()->json([ "message" => "Объявление разархивировано" ], 200);

        }else {
            return response()->json([ "message" => "Разархивация запрещена" ], 403);
        }
    }
}
