<?php

namespace App\Http\Controllers\Admin;

use App\Offer;
use App\OfferSpecialization;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Date\Date;

class AdminVolunteeringsController extends Controller
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

        $specializations = OfferSpecialization::all();
        $cities = City::all();
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
        $ages = [
            [
                'value' => 14,
                'name'=>'от 14'
            ],
            [
                'value' => 15,
                'name'=>'от 15'
            ],
            [
                'value' => 16,
                'name'=>'от 16'
            ],
            [
                'value' => 17,
                'name'=>'от 17'
            ]
        ];

        $specialities = OfferSpecialization::all();
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
        $volunteering->title = $request->get('title');
        $volunteering->city_id = $request->get('city');
        $volunteering->age = $request->get('age');
        $volunteering->speciality = $request->get('speciality');
        $volunteering->contact = $request->get('contact');
        $volunteering->description = $request->get('description');
        $volunteering->phone = $request->get('phone');
        $volunteering->email = $request->get('email');
        $volunteering->alt_phone = $request->get('alt_phone');


        $volunteering->save();

        return redirect()->back();
    }
}
