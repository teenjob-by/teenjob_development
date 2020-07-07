<?php

namespace App\Http\Controllers\Api\v1;

use App\Internship;
use App\Organisation as OrganisationModel;
use App\Offer;
use App\Event;
use App\City;
use App\OrganisationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Carbon;


use function PHPSTORM_META\type;

class OrganisationApi extends Controller
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
            $organisations = OrganisationModel::all();

            return response()->json([ "data" => $organisations ], 200);
        }
    }

    public function indexFilter($status)
    {
        if( /*Auth::user()->role == 0*/ true) {
            $organisations = [];

            switch ($status) {
                case 'unapproved':
                    $organisations = OrganisationModel::where('status', 0)->where('role', 1)->with('types')->get();
                    break;
                case 'published':
                    $organisations = OrganisationModel::where('status', 1)->where('role', 1)->with('types')->get();
                    break;
                case 'archived':
                    $organisations = OrganisationModel::where('status', 2)->where('role', 1)->with('types')->get();
                    break;
                case 'banned':
                    $organisations = OrganisationModel::where('status', 3)->where('role', 1)->with('types')->get();
                    break;
                case 'admin':
                    $organisations = OrganisationModel::where('role', 0)->with('types')->get();
                    break;
            }

            return response()->json([ "data" => $organisations ], 200);
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
        $types = OrganisationType::all();
        $cities = City::all();
        $organisation = OrganisationModel::findorFail($id);
        return response()->json([ "data" => $organisation, "types" => $types, "cities" => $cities], 200);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $organisations = OrganisationModel::findorFail($request->input('id'));
        $organisations->name = $request->input('name');
        $organisations->city_id = $request->input('city_id');
        $organisations->link = $request->input('link');
        $organisations->unique_identifier = $request->input('unique_identifier');
        $organisations->contact = $request->input('contact');
        $organisations->alt_email = $request->input('alt_email');
        $organisations->phone = $request->input('phone');
        $organisations->alt_phone = $request->input('alt_phone');
        $organisations->type = $request->input('type');
        $organisations->password =  Hash::make($request->input('password'));
        $organisations->save();
        return response()->json(["message" => "Информация сохранена"], 201);
    }

    public function create()
    {
        $types = OrganisationType::all();
        $cities = City::all();
        return response()->json([ "types" => $types, "cities" => $cities], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => ['required'],
            'request' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        OrganisationModel::create([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'city_id' => $request->input('city_id'),
            'type' => $request->input('type'),
            'unique_identifier' => $request->input('unique_identifier'),
            'contact' => $request->input('contactPerson'),
            'phone' =>$request->input('phone'),
            'email' => $request->input('email'),
            'alt_phone' =>$request->input('alt_phone'),
            'alt_email' => $request->input('alt_email'),
            'password' => Hash::make($request->input('password')),
            'role' => 1,
        ]);

        return response()->json(["message" => "Информация сохранена"], 201);
    }

    public function destroy($id)
    {
        $organisation = OrganisationModel::findOrFail($id);
        $organisation->delete();

        return response()->json([
            'message' => 'Успешно удалено',
        ], $this->successStatus);
    }

    public function ban($id)
    {
        $organisations = OrganisationModel::findOrFail($id);
        $organisations->status = 3;
        $organisations->save();

        return response()->json([
            'message' => 'Успешно заблокировано',
        ], $this->successStatus);
    }

    public function approve($id)
    {
        $organisations = OrganisationModel::findOrFail($id);

        $organisations->status = 1;
        $organisations->save();

        return response()->json([
            'message' => 'Успешно одобрено',
            $this-> successStatus
        ]);
    }

    public function getAllOrganisations()
    {

        $organisations = OrganisationModel::all();
        return response()->json([
            $organisations
        ], $this->successStatus);
    }

    public function showUnapproved()
    {
        $organisations = OrganisationModel::whereIn('status', [0, 3])
            ->orderBy('status', 'asc')
            ->get();

        return response()->json([
            $organisations
        ], $this->successStatus);
    }

}
