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



class AdminEvents extends Controller
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
                ['age', '<=', $request->input('age')]
            ];
        }

        if($request->has('query')) {

            $events = Event::whereIn(1, 2)
                ->where($filters)
                ->where($age_filter)
                ->orderBy('date_start', 'desc')
                ->paginate(30)
                ->onEachSide(1);
        }
        else{

            $events = Event::whereIn('status', [1, 2])
                ->orderBy('date_start', 'desc')
                ->paginate(30)
                ->onEachSide(1);
        }

        $pagination = $events->appends($_GET);

        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);
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
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);
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

        $date = $request->input('date_start').' '.$request->input('time_start');
            $event = new Event([
                'title' => $request->input('title'),
                'city_id' => $request->input('city'),
                'address' => $request->input('address'),
                'date_start' => \Carbon\Carbon::parse($date),
                'date_finish' => \Carbon\Carbon::parse($request->input('date_finish')),
                'age' => $request->input('age'),
                'type_id' => $request->input('type'),
                'description' => $request->input('description'),
                'image' => "/upload/images/".$imageName,
                'location' => $request->input('location'),//$request->input('location'),
                'organisation_id' => $request->input('organisation')
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
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);
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
        $date = $request->input('date_start').' '.$request->input('time_start');
        $event->title =  $request->input('title');
        $event->city_id = $request->input('city');
        $event->address = $request->input('address');
        $event->date_start = \Carbon\Carbon::parse($date);
        $event->date_finish = \Carbon\Carbon::parse($request->input('date_finish'));
        $event->age = $request->input('age');
        if(!empty(request()->image)){
            $event->image = '/upload/images/thumbnails/'.$imageName;
        }
        else {
            $event->image = $request->input('image-path');
        }

        $event->type_id = $request->input('type');
        $event->description = $request->input('description');
        $event->location = $request->input('location');

        //$event->image = $request->input('image');
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
        $events = Event::whereIn('status', [0, 3])
            ->orderBy('status', 'asc')
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
