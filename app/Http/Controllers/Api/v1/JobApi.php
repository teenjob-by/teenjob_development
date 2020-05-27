<?php

namespace App\Http\Controllers\Api\v1;

use App\Internship;
use App\Offer as JobModel;
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

class JobApi extends Controller
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
            $jobs = JobModel::where('offer_type', 2)->with('city')->with('organisation')->get();



            return response()->json([ "data" => $jobs ], 200);
        }
    }

    public function indexFilter($status)
    {
        if( /*Auth::user()->role == 0*/ true) {
            if($status == 'unapproved')
             $jobs = JobModel::where('status', 0)->where('offer_type', 2)->with('city')->with('organisation')->get();
            if($status == 'all')
                $jobs = JobModel::where('offer_type', 2)->with('city')->with('organisation')->get();



            return response()->json([ "data" => $jobs ], 200);
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
        $salaryTypes = SalaryType::all();
        $workTimeTypes = WorkTimeType::all();
        $specialities = OfferSpecialization::all();
        $organisation = JobModel::findorFail($id);
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
        return response()->json([ "data" => $organisation, "specialities" => $specialities, "cities" => $cities, "salaryTypes" => $salaryTypes, "workTimeTypes" => $workTimeTypes, 'ages' => $ages], 200);
    }

    public function update(Request $request)
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
            'salary' => ['integer'],
            'salary_type_id' => ['required'],
            'work_time_type_id' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $job = Offer::findOrFail($request->input('id'));
        $job->title = $request->input('title');
        $job->city_id = $request->input('city_id');
        $job->age = $request->input('age');
        $job->speciality = $request->input('speciality');
        $job->contact = $request->input('contact');
        $job->description = $request->input('description');
        $job->phone = $request->input('phone');
        $job->email = $request->input('email');
        $job->alt_phone = $request->input('alt_phone');
        $job->salary = $request->input('salary');
        $job->salary_type_id = $request->input('salary_type_id');
        $job->work_time_type_id = $request->input('work_time_type_id');

        $job->save();
        return response()->json(["message" => "Информация сохранена"], 201);
    }

    public function create()
    {
        $cities = City::all();
        $salaryTypes = SalaryType::all();
        $workTimeTypes = WorkTimeType::all();
        $specialities = OfferSpecialization::all();
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
        return response()->json([ "specialities" => $specialities, "cities" => $cities, "salaryTypes" => $salaryTypes, "workTimeTypes" => $workTimeTypes, 'ages' => $ages], 200);

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
            'salary' => ['integer'],
            'salary_type_id' => ['required'],
            'work_time_type_id' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $job = new Offer([
            'title' => $request->input('title'),
            'city_id' => $request->input('city_id'),
            'age' => $request->input('age'),
            'speciality' => $request->input('speciality'),
            'contact' => $request->input('contact'),
            'offer_type' => 2,
            'description' => $request->input('description'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'alt_phone' => $request->input('alt_phone'),
            'salary' => $request->input('salary'),
            'salary_type_id' => $request->input('salary_type_id'),
            'work_time_type_id' => $request->input('work_time_type_id'),
            'organisation_id' => Auth::user()->id,
        ]);

        $job->save();
        return response()->json(["message" => "Информация сохранена"], 201);
    }


    public function destroy($id)
    {
        $organisation = JobModel::findOrFail($id);
        $organisation->delete();

        return response()->json([
            'message' => 'Успешно удалено',
        ], $this->successStatus);
    }

    public function ban($id)
    {
        $jobs = JobModel::findOrFail($id);
        $jobs->status = 3;
        $jobs->save();

        return response()->json([
            'message' => 'Успешно заблокировано',
        ], $this->successStatus);
    }

    public function approve($id)
    {
        $jobs = JobModel::findOrFail($id);
        $jobs->published_at = Carbon::now();
        $jobs->status = 1;
        $jobs->save();

        return response()->json([
            'message' => 'Успешно одобрено',
            $this-> successStatus
        ]);
    }

    public function getAllJobs()
    {

        $jobs = JobModel::all();
        return response()->json([
            $jobs
        ], $this->successStatus);
    }

    public function showUnapproved()
    {
        $jobs = JobModel::whereIn('status', [0, 3])
            ->orderBy('status', 'asc')
            ->get();

        return response()->json([
            $jobs
        ], $this->successStatus);
    }

    public function showArchived()
    {
        $jobs = JobModel::whereIn('status', 2)
            ->orderBy('status', 'asc')
            ->get();

        return response()->json([
            $jobs
        ], $this->successStatus);
    }
}
