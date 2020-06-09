<?php

namespace App\Http\Controllers\Admin;

use App\Offer;
use App\OfferSpecialization;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Date\Date;

class AdminInternships extends Controller
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


        $internships = Offer::where('offer_type', 1)
            ->whereIn('status', [1, 2])
            ->orderBy('created_at', 'desc')
            ->paginate(30)
            ->onEachSide(1);


        $specializations = OfferSpecialization::orderBy('name')->get();
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);
        if (count ( $internships ) > 0)
            return view('admin.internships.index')->with('internships', $internships)->with('specializations', $specializations)->with('cities', $cities);

        return view ( 'admin.internships.index' )->with ('query_message', 'Ничего не найдено!' )->with('internships', $internships)->with('specializations', $specializations)->with('cities', $cities);

    }

    public function showUnapproved()
    {
        $internships = Offer::where('offer_type', 1)
            ->whereIn('status', [0, 3])
            ->orderBy('status', 'asc')
            ->paginate(30)
            ->onEachSide(1);

        return view('admin.internships.index')->with('internships', $internships);
    }

    public function edit($id)
    {
        $internship = Offer::find($id);

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

        $specialities = OfferSpecialization::orderBy('name')->get();          $key = $specialities->search(function($item) {             return $item->id == 22;         });         $chunk = $specialities->pull($key);         $specialities->push($chunk);
        return view('admin.internships.edit')->with('internship', $internship)->with('cities', $cities)->with('ages', $ages)->with('specialities', $specialities);
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
        $internship = Offer::find($id);
        $internship->title = $request->input('title');
        $internship->city_id = $request->input('city');
        $internship->age = $request->input('age');
        $internship->speciality = $request->input('speciality');
        $internship->contact = $request->input('contact');
        $internship->description = $request->input('description');
        $internship->phone = $request->input('phone');
        $internship->email = $request->input('email');
        $internship->alt_phone = $request->input('alt_phone');


        $internship->save();

        return redirect()->back();
    }

    public function approve($id)
    {
        $internships = Offer::find($id);
        $internships->status = 1;
        $internships->published_at = new \Date();
        $internships->save();

        return redirect()->back();
    }

    public function remove($id)
    {
        $internships = Offer::find($id);
        $internships->delete();

        return redirect()->back();
    }

    public function ban($id)
    {
        $internships = Offer::find($id);
        $internships->status = 3;
        $internships->save();

        return redirect()->back();
    }

    public function getInternshipForm($id)
    {
        $internship = Offer::find($id);
        return view('admin.internships.internshipForm')->with('internship', $internship);
    }

}
