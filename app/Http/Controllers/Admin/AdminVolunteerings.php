<?php

namespace App\Http\Controllers\Admin;

use App\Offer;
use App\OfferSpecialization;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Date\Date;

class AdminVolunteerings extends Controller
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


        $volunteerings = Offer::where('offer_type', 0)
            ->whereIn('status', [1, 2])
            ->orderBy('created_at', 'desc')
            ->paginate(30)
            ->onEachSide(1);

        $specializations = OfferSpecialization::orderBy('name')->get();
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);
        if (count ( $volunteerings ) > 0)
            return view('admin.volunteerings.index')->with('volunteerings', $volunteerings)->with('specializations', $specializations)->with('cities', $cities);

        return view ( 'admin.volunteerings.index' )->with ('query_message', 'Ничего не найдено!' )->with('volunteerings', $volunteerings)->with('specializations', $specializations)->with('cities', $cities);

    }

    public function showUnapproved()
    {
        $volunteerings = Offer::where('offer_type', 0)
            ->whereIn('status', [0, 3])
            ->orderBy('status', 'asc')
            ->paginate(30)
            ->onEachSide(1);

        return view('admin.volunteerings.index')->with('volunteerings', $volunteerings);
    }

    public function approve($id)
    {
        $volunteerings = Offer::find($id);
        $volunteerings->status = 1;
        $volunteerings->published_at = new \Date();
        $volunteerings->save();

        return redirect(route('admin.volunteering.moderation'));
    }

    public function remove($id)
    {
        $volunteerings = Offer::find($id);
        $volunteerings->delete();

        return redirect()->back();
    }

    public function ban($id)
    {
        $volunteerings = Offer::find($id);
        $volunteerings->status = 0;
        $volunteerings->save();

        return redirect()->back();
    }

    public function getVolunteeringForm($id)
    {
        $volunteering = Offer::find($id);
        return view('admin.volunteerings.volunteeringForm')->with('volunteering', $volunteering);
    }

    public function edit($id)
    {
        $volunteering = Offer::find($id);

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

        $specialities = OfferSpecialization::orderBy('name')->get();
        return view('admin.volunteerings.edit')->with('volunteering', $volunteering)->with('cities', $cities)->with('ages', $ages)->with('specialities', $specialities);
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
        $volunteering = Offer::find($id);
        $volunteering->title = $request->input('title');
        $volunteering->city_id = $request->input('city');
        $volunteering->age = $request->input('age');
        $volunteering->speciality = $request->input('speciality');
        $volunteering->contact = $request->input('contact');
        $volunteering->description = $request->input('description');
        $volunteering->phone = $request->input('phone');
        $volunteering->email = $request->input('email');
        $volunteering->alt_phone = $request->input('alt_phone');


        $volunteering->save();

        return redirect()->back();
    }
}
