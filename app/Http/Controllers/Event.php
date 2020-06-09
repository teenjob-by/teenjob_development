<?php

namespace App\Http\Controllers;


use App\Event as EventModel;
use App\City;
use App\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Jenssegers\Date\Date;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;



class Event extends Controller
{

    protected $item_type = "event";


    public function index(Request $request)
    {
        /*
         *
         * Filter queries
         *
         */

        $sort_direction = 'asc';

        $data = EventModel::whereIn('status', [1,2])

            ->when($request->has('city'),function ($query) use ($request) {
                return $query->where('city_id', $request->input('city'));
            })

            ->when($request->has('type'),function ($query) use ($request) {

                $type_filter_values = [];
                $type_filter = explode(',',trim($request->input('type'), '[]'));


                foreach ($type_filter as $item) {

                    if($item == 'free') {
                        $type_filter_values[] =  2;
                    }

                    if($item == 'payment') {
                        $type_filter_values[] =  1;
                    }

                    if($item == 'donate') {
                        $type_filter_values[] =  3;
                    }
                }

                if(count($type_filter_values) == 0) {
                    $type_filter_value = [1, 2, 3];
                }

                return $query->whereIn('type_id', $type_filter_values);
            })

            ->when($request->has('age'),function ($query) use ($request) {
                return $query->where('age', '<=', $request->input('age'));
            })

            ->where(function ($query) use ($request, $sort_direction) {

                $date_start = Carbon::now();
                $date_end = Carbon::now();

                $date_filter_value = [['date_start', '>=', $date_start]];
                $sort_direction = 'asc';

                if($request->has('date-start')) {

                    $past = false;

                    $date_filter = explode(',',trim($request->input('date-start'), '[]'));

                    foreach ($date_filter as $item) {
                        if($item == 'today') {
                            $date = Carbon::now()->endOfDay();
                            $date_end = ($date_end >= $date)? $date: $date_end;
                        }

                        if($item == 'tomorrow') {
                            $date = Carbon::now()->addDay()->endOfDay();
                            $date_end = ($date_end >= $date)? $date: $date_end;
                        }

                        if($item == 'week') {
                            $date = Carbon::now()->endOfWeek();
                            $date_end = ($date_end >= $date)? $date: $date_end;
                        }

                        if($item == 'nextweek') {
                            $date = Carbon::now()->addWeek()->endOfWeek();
                            $date_end = ($date_end >= $date)? $date: $date_end;
                        }

                        if($item == 'past') {
                            $past = true;
                        }
                    }

                    if($past)
                    {
                        $sort_direction = 'desc';
                        $date_filter_value = [['date_start', "<=", $date_end]];
                    }
                    else {
                        $date_filter_value = [['date_start', ">=", $date_start], ['date_start', "<=", $date_end]];
                    }

                }

                return $query->where($date_filter_value);
            })

            ->join('cities', 'events.city_id', '=', 'cities.id')
            ->select('events.*', 'cities.name as city_name')
            ->when($request->has('query'),function ($query) use ($request) {
                return $query->where('title', 'like', '%'.$request->input('query').'%')
                    ->orWhere('description', 'like', '%'.$request->input('query').'%')
                    ->orWhere('name', 'like', '%'.$request->input('query').'%')
                    ->orWhere('cities.name', 'like', '%'.$request->input('query').'%');
            })
            ->orderBy('date_start', $sort_direction)
            ->paginate(30)
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

        $cities = City::all();

        $filters = array();
        $filters['cities'] = array('data' => $cities, 'type' => 'select', 'name' => 'city');
        $filters['age'] = array('data' => $ages, 'type' => 'select', 'name' => 'age');
        $filters['date'] = array('data' => $date_start, 'type' => 'checkbox', 'name' => 'date-start');
        $filters['type'] = array('data' => $type, 'type' => 'checkbox', 'name' => 'type');

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
        $types = EventType::all();
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);

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

        return view('frontend.'. $this->item_type .'.create')->with("organisation", $organisation)->with('types', $types)->with('cities', $cities)->with('ages', $ages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'date_start' => 'required',
            'time_start' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $organisation = Auth::user()->id;

        $imageName = time().'.'.request()->image->getClientOriginalExtension();

        request()->image->move(public_path('upload/images'), $imageName);

        $original_image_storage = public_path('upload/images/original/');
        $large_image_storage = public_path('upload/images/large/');
        $medium_image_storage = public_path('upload/images/medium/');
        $small_image_storage = public_path('upload/images/small/');
        $tiny_image_storage = public_path('upload/images/tiny/');
        $thumbnails_image_storage = public_path('upload/images/thumbnails/');

        //$file = request()-> file('image');


        $image = Image::make(public_path('upload/images').'/'.$imageName);
        $image->save($original_image_storage.$imageName,100)
            ->resize(860, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($large_image_storage.$imageName,85)
            ->resize(640, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($medium_image_storage.$imageName,85)
            ->resize(420, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($small_image_storage.$imageName,85)
            ->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnails_image_storage.$imageName,85)
            ->resize(10, null, function ($constraint) {
                $constraint->aspectRatio();
            })->blur(1)->save($tiny_image_storage.$imageName,85);


        $date_start = $request->input('date_start').' '.$request->input('time_start');
        $date_finish = $request->input('date_finish').' '.$request->input('time_finish');
        $event = new EventModel([
            'title' => $request->input('title'),
            'city_id' => $request->input('city'),
            'address' => $request->input('address'),
            'date_start' => \Carbon\Carbon::parse($date_start),
            'date_finish' => \Carbon\Carbon::parse($date_finish),
            'age' => $request->input('age'),
            'type_id' => $request->input('type'),
            'description' => $request->input('description'),
            'image' => '/upload/images/thumbnails/'.$imageName,
            'location' => $request->input('location'),
            'organisation_id' => $organisation
        ]);
        $event->save();

        if($request->ajax()){
            return response()->json([ "message" => "Объявление создано" ], 200);
        }

        return redirect()->route('organisation.events.create');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = EventModel::findOrFail($id);

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
        $event = EventModel::findOrFail($id);

        if((($event->organisation_id == Auth::user()->id)) || (Auth::user()->role == 0)) {
            $cities = City::all();
            $lastCity = $cities->pop();
            $cities = $cities->prepend($lastCity);
            $types = EventType::all();


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

            return view('frontend.event.edit')->with('event', $event)->with('cities', $cities)->with('ages', $ages)->with('types', $types);
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
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'date_start' => 'required',
            'time_start' => 'required',
            'address' => 'required'
        ]);



        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $event = EventModel::findOrFail($id);

        if(($event->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {



            $date_start = $request->input('date_start').' '.$request->input('time_start');
            $date_finish = $request->input('date_finish').' '.$request->input('time_finish');
            $event->title =  $request->input('title');
            $event->city_id = $request->input('city');
            $event->address = $request->input('address');
            $event->date_start = \Carbon\Carbon::parse($date_start);
            $event->date_finish = \Carbon\Carbon::parse($date_finish);
            $event->age = $request->input('age');

            if(!empty(request()->image)){
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();

                request()->image->move(public_path('upload/images'), $imageName);

                $original_image_storage = public_path('upload/images/original/');
                $large_image_storage = public_path('upload/images/large/');
                $medium_image_storage = public_path('upload/images/medium/');
                $small_image_storage = public_path('upload/images/small/');
                $tiny_image_storage = public_path('upload/images/tiny/');
                $thumbnails_image_storage = public_path('upload/images/thumbnails/');

                //$file = request()-> file('image');


                $image = Image::make(public_path('upload/images') . '/' . $imageName);
                $image->save($original_image_storage . $imageName, 100)
                    ->resize(860, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($large_image_storage . $imageName, 85)
                    ->resize(640, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($medium_image_storage . $imageName, 85)
                    ->resize(420, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($small_image_storage . $imageName, 85)
                    ->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($thumbnails_image_storage . $imageName, 85)
                    ->resize(10, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->blur(1)->save($tiny_image_storage . $imageName, 85);
                $event->image = '/upload/images/thumbnails/'.$imageName;
            }


            $event->type_id = $request->input('type');
            $event->description = $request->input('description');
            $event->location = $request->input('location');

            if(Auth::user()->role !== 0) {
                $event->status = 0;
            }

            $event->save();

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
        $event = EventModel::findOrFail($id);
        if(($event->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {

            $event->delete();
            return response()->json([ "message" => "Объявление удалено" ], 200);

        }else {
            return response()->json([ "message" => "Удаление запрещено" ], 403);
        }
    }


    public function archive($id)
    {
        $event = EventModel::findOrFail($id);
        if(($event->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {

            $event->status = 2;
            $event->save();


            return response()->json([ "message" => "Объявление заархивировано" ], 200);

        }else {
            return response()->json([ "message" => "Архивация запрещена" ], 403);
        }
    }

    public function unarchive($id)
    {
        $event = EventModel::findOrFail($id);
        if(($event->organisation_id == Auth::user()->id) || ( Auth::user()->role == 0)) {

            $event->status = 0;
            $event->save();

            return response()->json([ "message" => "Объявление разархивировано" ], 200);

        }else {
            return response()->json([ "message" => "Разархивация запрещена" ], 403);
        }
    }
}
