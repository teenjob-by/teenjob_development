<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\City;
use App\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Jenssegers\Date\Date;
use Intervention\Image\ImageManagerStatic as Image;



class AdminEventsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->only(['city_id', 'date', 'type_id']);
        if($request->has('age')) {
            $age_filter=[
                ['age', '>=', $request->get('age')]
            ];
        }

        if($request->has('query')) {

            $events = Event::where('status', 1)
                ->where('date_start', '>=', Carbon::now()->subDays(1))
                ->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->get('query').'%')
                        ->orWhere('description', 'like', '%'.$request->get('query').'%');
                })
                ->where($filters)
                ->where($age_filter)
                ->orderBy('date_start', 'asc')
                ->paginate(30)
                ->onEachSide(1);
        }
        else{

            $events = Event::where('status', 1)
                ->where('date_start', '>=', Carbon::now()->subDays(1))
                ->orderBy('date_start', 'asc')
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
            return view('admin.event.index')->with('events', $events)->with('cities', $cities)->with('ages', $ages);

        return view ( 'admin.event.index' )->with('query_message', 'Ничего не найдено!' )->with('events', $events)->with('cities', $cities)->with('ages', $ages);
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
        return view('admin.event.create')->with("organisation", $organisation)->with('types', $types)->with('cities', $cities);
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
                'image' => "/upload/images/".$imageName,
                'location' => $request->get('location'),//$request->get('location'),
                'organisation_id' => $request->get('organisation')
            ]);
        $event->save();
        return redirect('/events')->with('success', 'Event saved!');

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

        return view('admin.event.card')->with('event', $event);
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
        return view('admin.event.edit')->with('event', $event)->with('cities', $cities)->with('ages', $ages)->with('types', $types);
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

        //$event->image = $request->get('image');
        //$event->location = $request->
        $event->save();

        return redirect('/events')->with('success', 'Event updated!');
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


    public function showUnapproved()
    {
        $events = Event::where('status', 0)
            ->orderBy('created_at', 'asc')
            ->paginate(30)
            ->onEachSide(1);

        return view('admin.event.index')->with('events', $events);
    }

    public function approve($id)
    {
        $events = Event::find($id);
        $events->status = 1;
        $events->published_at = new Date();
        $events->save();

        return redirect(route('admin.events'))->with('success', 'Event deleted!');
    }

    public function remove($id)
    {
        $events = Event::find($id);
        $events->delete();

        return redirect()->back();
    }

    public function ban($id)
    {
        $events = Event::find($id);
        $events->status = 3;
        $events->save();

        return redirect()->back();
    }

    public function getEventForm($id)
    {
        $event = Event::find($id);
        return view('admin.event.edit')->with('event', $event);
    }
}
