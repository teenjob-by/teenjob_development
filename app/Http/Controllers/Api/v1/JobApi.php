<?php

namespace App\Http\Controllers\Api\v1;

use App\Internship;
use App\Offer as JobModel;
use App\Offer;
use App\Event;
use App\City;
use App\OfferType;
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
            $jobs = JobModel::with('city')->with('organisation')->get();



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
        $types = OfferType::all();
        $cities = City::all();
        $organisation = JobModel::findorFail($id);
        return response()->json([ "data" => $organisation, "types" => $types, "cities" => $cities], 200);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'max:255'],
            'request' => ['max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $jobs = JobModel::findorFail($request->input('id'));
        $jobs->name = $request->input('name');
        $jobs->link = $request->input('link');
        $jobs->unique_identifier = $request->input('unique_identifier');
        $jobs->contact = $request->input('contact');
        $jobs->alt_email = $request->input('alt_email');
        $jobs->phone = $request->input('phone');
        $jobs->alt_phone = $request->input('alt_phone');
        $jobs->type = $request->input('type');
        $jobs->save();
        return response()->json(["message" => "Информация сохранена"], 201);
    }

    public function create()
    {
        $types = OfferType::all();
        $cities = City::all();
        return response()->json([ "types" => $types, "cities" => $cities], 200);
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
        $jobs->status = 1;
        $jobs->save();

        return response()->json([
            'message' => 'Успешно одобрено',
            $this-> successStatus
        ]);
    }

    public function getAllJobs()
    {

        $jobs = OrganisationModel::all();
        return response()->json([
            $jobs
        ], $this->successStatus);
    }

}
