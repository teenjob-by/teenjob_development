<?php

namespace App\Http\Controllers\Api\v1;

use App\Internship;
use App\Offer as InternshipModel;
use App\Offer;
use App\Event;
use App\City;
use App\OfferSpecialization;
use App\OfferType;
use App\SalaryType;
use App\WorkTimeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Carbon;


use function PHPSTORM_META\type;

class InternshipApi extends Controller
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
            $internships =InternshipModel::where('offer_type', 1)->with('city')->with('organisation')->get();



            return response()->json([ "data" => $internships ], 200);
        }
    }

    public function indexFilter($status)
    {
        if( /*Auth::user()->role == 0*/ true) {

            $internships = [];

            switch ($status) {
                case 'unapproved':
                    $internships = InternshipModel::where('offer_type', 1)->where('status', 0)->with('city')->with('organisation')->get();
                    break;
                case 'published':
                    $internships = InternshipModel::where('offer_type', 1)->where('status', 1)->with('city')->with('organisation')->get();
                    break;
                case 'archived':
                    $internships = InternshipModel::where('offer_type', 1)->where('status', 2)->with('city')->with('organisation')->get();
                    break;
                case 'banned':
                    $internships = InternshipModel::where('offer_type', 1)->where('status', 3)->with('city')->with('organisation')->get();
                    break;
            }



            return response()->json([ "data" => $internships ], 200);
        }
    }

    public function sortItems ($collection){
        $sorted = array(
            "published" => [],
            "pending" => [],
            "archived" => [],
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
            }
        }

        return $sorted;
    }

    public function edit($id)
    {
        $cities = City::all();
        $specialities = OfferSpecialization::orderBy('name')->get();          $key = $specialities->search(function($item) {             return $item->id == 22;         });         $chunk = $specialities->pull($key);         $specialities->push($chunk);
        $organisation = InternshipModel::findorFail($id);
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
        return response()->json([ "data" => $organisation, "specialities" => $specialities, "cities" => $cities, 'ages' => $ages], 200);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'city_id' => ['required'],
            'age' => ['required'],
            'speciality' => ['required'],
            'description' => ['required'],
            'contact' => ['required'],
            'phone' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $internship = Offer::findOrFail($request->input('id'));
        $internship->title = $request->input('title');
        $internship->city_id = $request->input('city_id');
        $internship->age = $request->input('age');
        $internship->speciality = $request->input('speciality');
        $internship->contact = $request->input('contact');
        $internship->description = $request->input('description');
        $internship->phone = $request->input('phone');
        $internship->email = $request->input('email');
        $internship->alt_phone = $request->input('alt_phone');

        $internship->save();
        return response()->json(["message" => "Информация сохранена"], 201);
    }

    public function create()
    {
        $cities = City::all();
        $specialities = OfferSpecialization::orderBy('name')->get();          $key = $specialities->search(function($item) {             return $item->id == 22;         });         $chunk = $specialities->pull($key);         $specialities->push($chunk);
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
        return response()->json([ "specialities" => $specialities, "cities" => $cities, 'ages' => $ages], 200);

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'min:3','max:255'],
            'city_id' => ['required'],
            'age' => ['required'],
            'speciality' => ['required'],
            'description' => ['required','max:255'],
            'contact' => ['required', 'min:3','max:255'],
            'phone' => ['required', 'min:3','max:255'],
            'email' => ['email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $internship = new Offer([
            'title' => $request->input('title'),
            'city_id' => $request->input('city_id'),
            'age' => $request->input('age'),
            'speciality' => $request->input('speciality'),
            'contact' => $request->input('contact'),
            'offer_type' => 1,
            'description' => $request->input('description'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'alt_phone' => $request->input('alt_phone'),
            'organisation_id' => Auth::user()->id,
        ]);

        $internship->save();
        return response()->json(["message" => "Информация сохранена"], 201);
    }


    public function destroy($id)
    {
        $organisation = InternshipModel::findOrFail($id);
        $organisation->delete();

        return response()->json([
            'message' => 'Успешно удалено',
        ], $this->successStatus);
    }

    public function ban($id)
    {
        $internships = InternshipModel::findOrFail($id);
        $internships->status = 3;
        $internships->save();

        return response()->json([
            'message' => 'Успешно заблокировано',
        ], $this->successStatus);
    }

    public function archive($id)
    {
        $events = InternshipModel::findOrFail($id);
        $events->status = 2;
        $events->save();

        return response()->json([
            'message' => 'Успешно заархивировано',
        ], $this->successStatus);
    }

    public function approve($id)
    {
        $internships = InternshipModel::findOrFail($id);
        $internships->published_at = Carbon::now();
        $internships->status = 1;
        $internships->save();

        return response()->json([
            'message' => 'Успешно одобрено',
            $this-> successStatus
        ]);
    }

    public function getAllInternships()
    {

        $internships = InternshipModel::all();
        return response()->json([
            $internships
        ], $this->successStatus);
    }

    public function showUnapproved()
    {
        $internships = InternshipModel::whereIn('status', [0, 3])
            ->orderBy('status', 'asc')
            ->get();

        return response()->json([
            $internships
        ], $this->successStatus);
    }

    public function showArchived()
    {
        $internships = InternshipModel::whereIn('status', 2)
            ->orderBy('status', 'asc')
            ->get();

        return response()->json([
            $internships
        ], $this->successStatus);
    }
}
