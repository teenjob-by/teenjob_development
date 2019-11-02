<?php

namespace App\Http\Controllers;

use App\Internship;
use App\Organisation;
use App\Offer;
use App\OrganisationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function PHPSTORM_META\type;

class OrganisationsController extends Controller
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
        return view('home');
    }

    public function getOrganisation()
    {
        $organisation = Organisation::findOrFail(Auth::id());
        $type = OrganisationType::findOrFail($organisation->type);
        $organisation->type = $type->name;


        $internships = Offer::where('offer_type', 1)->where('organisation_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $volunteerings = Offer::where('offer_type', 0)->where('organisation_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $events = $organisation->events;
        return view('site.organisation')->with('organisation', $organisation)->with('internships', $internships)->with('volunteerings', $volunteerings)->with('events', $events);
    }

    public function getOrganisationForm()
    {
        $organisation = Organisation::find(Auth::id());
        return view('site.organisationForm')->with('organisation', $organisation);
    }

    public function update(Request $request)
    {

        $organisations = Organisation::find(Auth::id());


        if(Hash::check($request->get('current_password'), $organisations->password)) {
            $organisations->email = $request->get('email');
            $organisations->alt_email = $request->get('alt_email');
            $organisations->phone = $request->get('phone');
            $organisations->request = $request->get('request');
            if ((!empty($request->get('password'))) && ($request->get('password') == $request->get('password_confirmation') )) {
               $organisations->password = Hash::make($request->get('password'));
            }
            $organisations->save();
            return redirect('/organisation')->with('success', 'Информация сохранена');
        }
        else {
            return redirect()->back()->with('error', 'Неверный пароль');
        }

    }

    public function destroy()
    {
        $organisations = Organisation::find(Auth::id());
        Auth::logout();
        $organisations->delete();

        return redirect('/');
    }

    public function getAllOrganisations()
    {
        $organisations = Organisation::all();
        return $organisations;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'request' => ['required', 'string', 'max:255'],
            'unique_identifier' => ['required', 'digits:9'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:organisations'],
            'alt_email' => ['required', 'string', 'email', 'max:255', 'unique:organisations'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
