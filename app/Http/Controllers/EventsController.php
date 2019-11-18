<?php

namespace App\Http\Controllers;


use App\Event;
use App\City;
use App\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Jenssegers\Date\Date;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;



class EventsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOld(Request $request)
    {
        $filters = $request->only(['city_id']);
        $age_filter=[
            ['age', '>=', 14]
        ];
        if($request->has('age')) {
            $age_filter=[
                ['age', '>=', $request->get('age')]
            ];
        }

        $sort_direction = 'asc';
        $date_filter = [
            'all' => [['date_start', '>=', Carbon::today()]],
            'today' => [],
            'tomorrow' => [],
            'week' => [],
            'next_week' => [],
            'past' => []
        ];




        if($request->has('today')) {
            $date_filter['all'] = [];
            $date_filter['today'] = [
                    ['date_start', '>=', Carbon::today()],
                    ['date_start', '<', Carbon::tomorrow()]
            ];
        }

        if($request->has('tomorrow')) {
            $date_filter['all'] = [];
            $date_filter['tomorrow'] = [
                ['date_start', '>=', Carbon::tomorrow()],
                ['date_start', '<', Carbon::tomorrow()->addDay()]
            ];
        }


        if($request->has('week')) {
            $date_filter['all'] = [];
            $date_filter['week'] = [
                ['date_start', '>=', Carbon::today()],
                ['date_start', '<', Carbon::today()->endOfWeek()]
            ];
        }

        if($request->has('nextweek')) {
            $date_filter['all'] = [];
            $date_filter['next_week'] = [
                ['date_start', '>=', Carbon::today()->addWeek()->startOfWeek()],
                ['date_start', '<', Carbon::today()->addWeek()->endOfWeek()]
            ];
        }


        if($request->has('past')) {
            $date_filter['all'] = [];
            $date_filter['past'] = [
                ['date_start', '<', Carbon::today()]
            ];

            $sort_direction = 'desc';

        }

        $type_filter_value = [];
        if($request->has('free')) {
            $type_filter_value[] =  2;
        }
        
        if($request->has('payment')) {
            $type_filter_value[] =  1;
        }
        
        if($request->has('donate')) {
            $type_filter_value[] =  3;
        }

        if(count($type_filter_value) == 0) {
            $type_filter_value = [1, 2, 3];
        }
        

        
        
        
        //dd($type_filter);
        if($request->has('query')) {

            $events = Event::whereIn('status', [1,2])
                ->join('cities', 'events.city_id', '=', 'cities.id')
                ->select('events.*', 'cities.name as city_name')
                ->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->get('query').'%')
                        ->orWhere('description', 'like', '%'.$request->get('query').'%')
                        ->orWhere('name', 'like', '%'.$request->get('query').'%')
                        ->orWhere('cities.name', 'like', '%'.$request->get('query').'%');
                })
                ->where($filters)
                ->where($age_filter)
                ->where(function ($datequery) use ($date_filter) {
                    $datequery->where($date_filter['all'])
                        ->orWhere($date_filter['today'])
                        ->orWhere($date_filter['tomorrow'])
                        ->orWhere($date_filter['week'])
                        ->orWhere($date_filter['next_week'])
                        ->orWhere($date_filter['past']);
                })
                ->whereIn('type_id', $type_filter_value)
                ->orderBy('date_start', $sort_direction)
                ->paginate(30)
                ->onEachSide(1);
        }
        else{

            $events = Event::whereIn('status', [1, 2])
                ->join('cities', 'events.city_id', '=', 'cities.id')
                ->select('events.*', 'cities.name as city_name')
                ->where($filters)
                ->where(function ($datequery) use ($date_filter) {
                    $datequery->where($date_filter['all'])
                        ->orWhere($date_filter['today'])
                        ->orWhere($date_filter['tomorrow'])
                        ->orWhere($date_filter['week'])
                        ->orWhere($date_filter['next_week'])
                        ->orWhere($date_filter['past']);
                })
                ->where($age_filter)
                ->whereIn('type_id', $type_filter_value)
                ->orderBy('date_start', $sort_direction)
                ->paginate(30)
                ->onEachSide(1);
        }

        $pagination = $events->appends($_GET);

        $cities = City::all();
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

        if (count ( $events ) > 0)
            return view('site.event.index')->with('events', $events)->with('cities', $cities)->with('ages', $ages);

        return view ( 'site.event.index' )->with('query_message', 'Ничего не найдено!' )->with('events', $events)->with('cities', $cities)->with('ages', $ages);
    }

    public function indexdynview(){

        $cities = City::all();
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
        return view('site.event.indexDyn')->with('cities', $cities)->with('ages', $ages);
    }
    public function index(Request $request)
    {
        $filters = $request->only(['city_id']);
        $age_filter=[
            ['age', '>=', 14]
        ];
        if($request->has('age')) {
            $age_filter=[
                ['age', '>=', $request->get('age')]
            ];
        }

        $sort_direction = 'asc';
        $date_filter = [
            'all' => [['date_start', '>=', Carbon::today()]],
            'today' => [],
            'tomorrow' => [],
            'week' => [],
            'next_week' => [],
            'past' => []
        ];




        if($request->has('today')) {
            $date_filter['all'] = [];
            $date_filter['today'] = [
                ['date_start', '>=', Carbon::today()],
                ['date_start', '<', Carbon::tomorrow()]
            ];
        }

        if($request->has('tomorrow')) {
            $date_filter['all'] = [];
            $date_filter['tomorrow'] = [
                ['date_start', '>=', Carbon::tomorrow()],
                ['date_start', '<', Carbon::tomorrow()->addDay()]
            ];
        }


        if($request->has('week')) {
            $date_filter['all'] = [];
            $date_filter['week'] = [
                ['date_start', '>=', Carbon::today()],
                ['date_start', '<', Carbon::today()->endOfWeek()]
            ];
        }

        if($request->has('nextweek')) {
            $date_filter['all'] = [];
            $date_filter['next_week'] = [
                ['date_start', '>=', Carbon::today()->addWeek()->startOfWeek()],
                ['date_start', '<', Carbon::today()->addWeek()->endOfWeek()]
            ];
        }


        if($request->has('past')) {
            $date_filter['all'] = [];
            $date_filter['past'] = [
                ['date_start', '<', Carbon::today()]
            ];

            $sort_direction = 'desc';

        }

        $type_filter_value = [];
        if($request->has('free')) {
            $type_filter_value[] =  2;
        }

        if($request->has('payment')) {
            $type_filter_value[] =  1;
        }

        if($request->has('donate')) {
            $type_filter_value[] =  3;
        }

        if(count($type_filter_value) == 0) {
            $type_filter_value = [1, 2, 3];
        }





        //dd($type_filter);
        if($request->has('query')) {

            $events = Event::whereIn('status', [1,2])
                ->join('cities', 'events.city_id', '=', 'cities.id')
                ->select('events.*', 'cities.name as city_name')
                ->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->get('query').'%')
                        ->orWhere('description', 'like', '%'.$request->get('query').'%')
                        ->orWhere('name', 'like', '%'.$request->get('query').'%')
                        ->orWhere('cities.name', 'like', '%'.$request->get('query').'%');
                })
                ->where($filters)
                ->where($age_filter)
                ->where(function ($datequery) use ($date_filter) {
                    $datequery->where($date_filter['all'])
                        ->orWhere($date_filter['today'])
                        ->orWhere($date_filter['tomorrow'])
                        ->orWhere($date_filter['week'])
                        ->orWhere($date_filter['next_week'])
                        ->orWhere($date_filter['past']);
                })
                ->whereIn('type_id', $type_filter_value)
                ->orderBy('date_start', $sort_direction)
                ->paginate(30)
                ->onEachSide(1);
        }
        else{

            $events = Event::whereIn('status', [1, 2])
                ->join('cities', 'events.city_id', '=', 'cities.id')
                ->select('events.*', 'cities.name as city_name')
                ->where($filters)
                ->where(function ($datequery) use ($date_filter) {
                    $datequery->where($date_filter['all'])
                        ->orWhere($date_filter['today'])
                        ->orWhere($date_filter['tomorrow'])
                        ->orWhere($date_filter['week'])
                        ->orWhere($date_filter['next_week'])
                        ->orWhere($date_filter['past']);
                })
                ->where($age_filter)
                ->whereIn('type_id', $type_filter_value)
                ->orderBy('date_start', $sort_direction)
                ->paginate(30)
                ->onEachSide(1);
        }

        $pagination = $events->appends($_GET);

        $cities = City::all();
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



            if ($request->ajax()) {
                return view('presult')->with('data', $events)->with('ajax', true)->with('page', $events->currentPage());
            }
            return view('site.event.dynTest')->with('data', $events)->with('cities', $cities)->with('ages', $ages)->with('ajax', false)->with('page', $events->currentPage());

    }
    public function indexdyn(Request $request)
    {
        $filters = $request->only(['city_id']);
        $age_filter=[
            ['age', '>=', 14]
        ];
        if($request->has('age')) {
            $age_filter=[
                ['age', '>=', $request->get('age')]
            ];
        }

        $sort_direction = 'asc';
        $date_filter = [
            'all' => [['date_start', '>=', Carbon::today()]],
            'today' => [],
            'tomorrow' => [],
            'week' => [],
            'next_week' => [],
            'past' => []
        ];




        if($request->has('today')) {
            $date_filter['all'] = [];
            $date_filter['today'] = [
                ['date_start', '>=', Carbon::today()],
                ['date_start', '<', Carbon::tomorrow()]
            ];
        }

        if($request->has('tomorrow')) {
            $date_filter['all'] = [];
            $date_filter['tomorrow'] = [
                ['date_start', '>=', Carbon::tomorrow()],
                ['date_start', '<', Carbon::tomorrow()->addDay()]
            ];
        }


        if($request->has('week')) {
            $date_filter['all'] = [];
            $date_filter['week'] = [
                ['date_start', '>=', Carbon::today()],
                ['date_start', '<', Carbon::today()->endOfWeek()]
            ];
        }

        if($request->has('nextweek')) {
            $date_filter['all'] = [];
            $date_filter['next_week'] = [
                ['date_start', '>=', Carbon::today()->addWeek()->startOfWeek()],
                ['date_start', '<', Carbon::today()->addWeek()->endOfWeek()]
            ];
        }


        if($request->has('past')) {
            $date_filter['all'] = [];
            $date_filter['past'] = [
                ['date_start', '<', Carbon::today()]
            ];

            $sort_direction = 'desc';

        }

        $type_filter_value = [];
        if($request->has('free')) {
            $type_filter_value[] =  2;
        }

        if($request->has('payment')) {
            $type_filter_value[] =  1;
        }

        if($request->has('donate')) {
            $type_filter_value[] =  3;
        }

        if(count($type_filter_value) == 0) {
            $type_filter_value = [1, 2, 3];
        }





        //dd($type_filter);
        if($request->has('query')) {

            $events = Event::whereIn('status', [1,2])
                ->join('cities', 'events.city_id', '=', 'cities.id')
                ->select('events.*', 'cities.name as city_name')
                ->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->get('query').'%')
                        ->orWhere('description', 'like', '%'.$request->get('query').'%')
                        ->orWhere('name', 'like', '%'.$request->get('query').'%')
                        ->orWhere('cities.name', 'like', '%'.$request->get('query').'%');
                })
                ->where($filters)
                ->where($age_filter)
                ->where(function ($datequery) use ($date_filter) {
                    $datequery->where($date_filter['all'])
                        ->orWhere($date_filter['today'])
                        ->orWhere($date_filter['tomorrow'])
                        ->orWhere($date_filter['week'])
                        ->orWhere($date_filter['next_week'])
                        ->orWhere($date_filter['past']);
                })
                ->whereIn('type_id', $type_filter_value)
                ->orderBy('date_start', $sort_direction)
                ->paginate(30)
                ->onEachSide(1);
        }
        else{

            $events = Event::whereIn('status', [1, 2])
                ->join('cities', 'events.city_id', '=', 'cities.id')
                ->select('events.*', 'cities.name as city_name')
                ->where($filters)
                ->where(function ($datequery) use ($date_filter) {
                    $datequery->where($date_filter['all'])
                        ->orWhere($date_filter['today'])
                        ->orWhere($date_filter['tomorrow'])
                        ->orWhere($date_filter['week'])
                        ->orWhere($date_filter['next_week'])
                        ->orWhere($date_filter['past']);
                })
                ->where($age_filter)
                ->whereIn('type_id', $type_filter_value)
                ->orderBy('date_start', $sort_direction)
                ->paginate(30)
                ->onEachSide(1);
        }

        $pagination = $events->appends($_GET);

        $cities = City::all();
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
        $events = $events->toArray();

        foreach($events['data'] as $key=>$event)
        {

            $str = preg_replace('/\s+/', ' ', clean($event['description']));
            $events['data'][$key]['description'] = Str::limit($str,80,'...');

            $events['data'][$key]['time_start'] = $events['data'][$key]['date_start']->format('H:i');
            $events['data'][$key]['date_start'] = $events['data'][$key]['date_start']->format('d.m.Y');
        }

        if (count ( $events ) > 0)
            //return view('site.event.index')->with('events', $events)->with('cities', $cities)->with('ages', $ages);
            return json_encode($events);

        //return view ( 'site.event.index' )->with('query_message', 'Ничего не найдено!' )->with('events', $events)->with('cities', $cities)->with('ages', $ages);
        return json_encode($events);
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
        return view('site.event.create')->with("organisation", $organisation)->with('types', $types)->with('cities', $cities);
    }

    public function archive($id)
    {
        $events = Event::find($id);
        if($events->organisation_id == Auth::user()->id) {
            $events->status = 2;
            $events->save();
        }

        return redirect()->back();
    }

    public function unarchive($id)
    {
        $events = Event::find($id);
        if($events->organisation_id == Auth::user()->id) {
            $events->status = 0;
            $events->save();
        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

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


        $date = $request->get('date_start').' '.$request->get('time_start');
        $event = new Event([
            'title' => $request->get('title'),
            'city_id' => $request->get('city'),
            'address' => $request->get('address'),
            'date_start' => \Carbon\Carbon::parse($date),
            'date_finish' => \Carbon\Carbon::parse($request->get('date_finish')),
            'age' => $request->get('age'),
            'type_id' => $request->get('type'),
            'description' => $request->get('description'),
            'image' => '/upload/images/thumbnails/'.$imageName,
            'location' => $request->get('location'),
            'organisation_id' => $request->get('organisation')
        ]);
        $event->save();
        return redirect('/organisation#events')->with('success', 'Event saved!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);

        return view('site.event.card')->with('event', $event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        $cities = City::all();
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
        $types = EventType::all();
        return view('site.event.edit')->with('event', $event)->with('cities', $cities)->with('ages', $ages)->with('types', $types);
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

        $request->validate([
            'title' => 'required|max:255'
        ]);
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

        }



        $event = Event::find($id);
        $date = $request->get('date_start').' '.$request->get('time_start');
        $event->title =  $request->get('title');
        $event->city_id = $request->get('city');
        $event->address = $request->get('address');
        $event->date_start = \Carbon\Carbon::parse($date);
        $event->date_finish = \Carbon\Carbon::parse($request->get('date_finish'));
        $event->age = $request->get('age');
        if(!empty(request()->image)){
            $event->image = '/upload/images/thumbnails/'.$imageName;
        }
        else {
            $event->image = $request->get('image-path');
        }

        $event->type_id = $request->get('type');
        $event->description = $request->get('description');
        $event->location = $request->get('location');

        $event->status = 0;
        //$event->image = $request->get('image');
        //$event->location = $request->get('location');
        $event->save();

        return redirect('/events/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        return redirect('/events')->with('success', 'Event deleted!');
    }
}
