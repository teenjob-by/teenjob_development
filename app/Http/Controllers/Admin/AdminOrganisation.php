<?php

namespace App\Http\Controllers\Admin;

use App\Organisation;
use App\OrganisationType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminOrganisation extends Controller
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
        $organisations = Organisation::where('role', '>', 0)
            ->where('status', '1')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.organisation.index')->with('organisations', $organisations);
    }

    public function showUnapproved()
    {
        $organisations = Organisation::whereIn('status', [0, 3])
            ->orderBy('status', 'asc')
            ->get();

        return view('admin.organisation.index')->with('organisations', $organisations);
    }

    public function approve($id)
    {
        $organisations = Organisation::find($id);
        $organisations->status = 1;
        $organisations->save();

        return redirect()->back();
    }

    public function remove($id)
    {
        $organisations = Organisation::find($id);
        $organisations->delete();

        return redirect()->back();
    }

    public function ban($id)
    {
        $organisations = Organisation::find($id);
        $organisations->status = 3;
        $organisations->save();

        return redirect()->back();
    }

    public function getOrganisationForm($id)
    {
        $organisation = Organisation::find($id);
        $types = OrganisationType::all();
        return view('admin.organisation.organisationForm')->with('organisation', $organisation)->with('types', $types);
    }

    public function update(Request $request)
    {

        $organisations = Organisation::find($request->input('id'));

            $organisations->name = $request->input('name');
            $organisations->link = $request->input('link');
            $organisations->type = $request->input('type');
            $organisations->contact = $request->input('contact');
            $organisations->unique_identifier = $request->input('unique_identifier');
            $organisations->alt_email = $request->input('alt_email');
            $organisations->phone = $request->input('phone');
            $organisations->request = $request->input('request');

            if ((!empty($request->input('password'))) && ($request->input('password') == $request->input('password_confirmation') )) {
                $organisations->password = Hash::make($request->input('password'));
            }
            $organisations->save();
            return redirect()->back();
    }
}