<?php

namespace App\Http\Controllers;

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


use function PHPSTORM_META\type;

class Organisation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $organisation = OrganisationModel::findOrFail(Auth::id());
        $type = OrganisationType::findOrFail($organisation->type);
        $organisation->type = $type->name;


        $internships = Offer::where('offer_type', 1)->where('organisation_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $volunteerings = Offer::where('offer_type', 0)->where('organisation_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $jobs = Offer::where('offer_type', 2)->where('organisation_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $events = Event::where('organisation_id', Auth::id())->orderBy('created_at', 'desc')->get();

        $data = array(
            'job' => $this->sortItems($jobs),
            'internship' => $this->sortItems($internships),
            'volunteering' => $this->sortItems($volunteerings),
            'event' => $this->sortItems($events),
        );

        return view('frontend.organisation')->with('data', $data)->with('organisation', $organisation);
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

    public function getOrganisationForm()
    {
        $organisation = OrganisationModel::findorFail(Auth::id());
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);
        return view('frontend.organisationForm')->with('organisation', $organisation)->with("cities", $cities);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'alt_email' => ['email', 'max:255'],
            'phone' => ['required', 'max:255'],
            'alt_phone' => ['max:255'],
            'city' => ['required'],
            'request' => ['max:255'],
            'password' => ['min:6', 'required_with:password_repeat','same:password_repeat'],
            'password_repeat' => ['min:6'],
            'password_old' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $organisations = OrganisationModel::findorFail(Auth::id());

        if(Hash::check($request->input('password_old'), $organisations->password)) {
            $organisations->alt_email = $request->input('alt_email');
            $organisations->phone = $request->input('phone');
            $organisations->alt_phone = $request->input('alt_phone');
            $organisations->request = $request->input('request');
            $organisations->city_id = $request->input('city');
            if ((!empty($request->input('password'))) && ($request->input('password') == $request->input('password_repeat') )) {
               $organisations->password = Hash::make($request->input('password'));
            }
            else {

                if($request->ajax()){
                    return response()->json([ "password" => "Пароли не совпадают" ], 200);
                }
                return redirect()->route('organisation.update');
            }
            $organisations->save();



            if($request->ajax()) {
                return response()->json(["message" => "Информация сохранена"], 201);
            }
            return redirect()->route('organisation.update');
        }
        else {


            if($request->ajax()) {
                return response()->json(["password_old" => "Неверный пароль"], 200);
            }
            return redirect()->route('organisation.update');
        }
    }

    public function destroy()
    {
        $organisation = OrganisationModel::findOrFail(Auth::id());
        Auth::logout();
        $organisation->delete();

        return redirect()->route("frontend.index");
    }

    public function getAllOrganisations()
    {
        if( Auth::user()->role == 0) {
            $organisations = OrganisationModel::all();
            return $organisations;
        }
        else {
            return null;
        }

    }

}
