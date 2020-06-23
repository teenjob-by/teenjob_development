<?php

namespace App\Http\Controllers\Api\v1;

use App\EventType;
use App\Event as EventModel;
use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManagerStatic as Image;


use function PHPSTORM_META\type;

class EventApi extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public $successStatus = 200;

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */





    public function index()
    {
        if( /*Auth::user()->role == 0*/ true) {
            $events = EventModel::with('city')->with('organisation')->get();



            return response()->json([ "data" => $events ], 200);
        }
    }

    public function indexFilter($status)
    {
        if( /*Auth::user()->role == 0*/ true) {
            $events = [];

            switch ($status) {
                case 'unapproved':
                    $events = EventModel::where('status', 0)->with('city')->with('organisation')->get();
                    break;
                case 'published':
                    $events = EventModel::where('status', 1)->with('city')->with('organisation')->get();
                    break;
                case 'archived':
                    $events = EventModel::where('status', 2)->with('city')->with('organisation')->get();
                    break;
                case 'banned':
                    $events = EventModel::where('status', 3)->with('city')->with('organisation')->get();
                    break;
                case 'outdated':
                    $events = EventModel::where('status', 5)->with('city')->with('organisation')->get();
                    break;
            }

            return response()->json([ "data" => $events ], 200);
        }
    }

    public function sortItems ($collection){
        $sorted = array(
            "published" => [],
            "pending" => [],
            "archived" => [],
            "outdated" => [],
        );

        foreach ($collection as $item) {
            switch ($item->status) {
                case 0:
                    array_push($sorted['published'], $item);
                    break;
                case 1:
                    array_push($sorted['pending'], $item);
                    break;
                case 2:
                    array_push($sorted['archived'], $item);
                    break;
                case 5:
                    array_push($sorted['outdated'], $item);
                    break;
            }
        }

        return $sorted;
    }

    public function edit($id)
    {
        $cities = City::all();

        $eventTypes = EventType::all();
        $organisation = EventModel::findorFail($id);
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
        return response()->json([ "data" => $organisation, "types" => $eventTypes, "cities" => $cities, 'ages' => $ages], 200);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'date_start' => 'required',
            'time_start' => 'required',
            'date_finish' => 'required',
            'time_finish' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $event = EventModel::findOrFail($request->input('id'));
        $date_start = $request->input('date_start').' '.$request->input('time_start');
        $date_finish = $request->input('date_finish').' '.$request->input('time_finish');
        $event->title =  $request->input('title');
        $event->city_id = $request->input('city_id');
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


        $event->type_id = $request->input('type_id');
        $event->description = $request->input('description');
        $event->location = $request->input('location');

        $event->save();
        return response()->json(["message" => "Информация сохранена"], 201);
    }

    public function create()
    {
        $cities = City::all();
        $eventTypes = EventType::all();

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
        return response()->json([ "cities" => $cities, "types" => $eventTypes, 'ages' => $ages], 200);

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'date_start' => 'required',
            'time_start' => 'required',
            'date_finish' => 'required',
            'time_finish' => 'required',
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
            'city_id' => $request->input('city_id'),
            'address' => $request->input('address'),
            'date_start' => \Carbon\Carbon::parse($date_start),
            'date_finish' => \Carbon\Carbon::parse($date_finish),
            'age' => $request->input('age'),
            'type_id' => $request->input('type_id'),
            'description' => $request->input('description'),
            'image' => '/upload/images/thumbnails/'.$imageName,
            'location' => $request->input('location'),
            'organisation_id' => $organisation
        ]);
        $event->save();
        return response()->json(["message" => "Информация сохранена"], 201);
    }


    public function destroy($id)
    {
        $organisation = EventModel::findOrFail($id);
        $organisation->delete();

        return response()->json([
            'message' => 'Успешно удалено',
        ], $this->successStatus);
    }

    public function ban($id)
    {
        $events = EventModel::findOrFail($id);
        $events->status = 3;
        $events->save();

        return response()->json([
            'message' => 'Успешно заблокировано',
        ], $this->successStatus);
    }

    public function archive($id)
    {
        $events = EventModel::findOrFail($id);
        $events->status = 2;
        $events->save();

        return response()->json([
            'message' => 'Успешно заархивировано',
        ], $this->successStatus);
    }

    public function approve($id)
    {
        $events = EventModel::findOrFail($id);
        $events->published_at = Carbon::now();
        $events->status = 1;
        $events->save();

        return response()->json([
            'message' => 'Успешно одобрено',
            $this-> successStatus
        ]);
    }

    public function getAllEvents()
    {

        $events = EventModel::all();
        return response()->json([
            $events
        ], $this->successStatus);
    }

    public function showUnapproved()
    {
        $events = EventModel::whereIn('status', [0, 3])
            ->orderBy('status', 'asc')
            ->get();

        return response()->json([
            $events
        ], $this->successStatus);
    }

    public function showArchived()
    {
        $events = EventModel::whereIn('status', 2)
            ->orderBy('status', 'asc')
            ->get();

        return response()->json([
            $events
        ], $this->successStatus);
    }
}
