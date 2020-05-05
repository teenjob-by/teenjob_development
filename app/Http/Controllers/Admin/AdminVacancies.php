<?php

namespace App\Http\Controllers\Admin;

use App\Offer;
use App\OfferSpecialization;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Date\Date;

class AdminVacancies extends Controller
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


        $jobs = Offer::where('offer_type', 2)
            ->whereIn('status', [1, 2])
            ->orderBy('created_at', 'desc')
            ->paginate(30)
            ->onEachSide(1);


        $specializations = OfferSpecialization::all();
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);
        if (count ( $jobs ) > 0)
            return view('admin.jobs.index')->with('jobs', $jobs)->with('specializations', $specializations)->with('cities', $cities);

        return view ( 'admin.jobs.index' )->with ('query_message', 'Ничего не найдено!' )->with('jobs', $jobs)->with('specializations', $specializations)->with('cities', $cities);

    }

    public function showUnapproved()
    {
        $jobs = Offer::where('offer_type', 2)
            ->whereIn('status', [0, 3])
            ->orderBy('status', 'asc')
            ->paginate(30)
            ->onEachSide(1);

        return view('admin.jobs.index')->with('jobs', $jobs);
    }

    public function edit($id)
    {
        $job = Offer::find($id);

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

        $specialities = OfferSpecialization::all();
        return view('admin.jobs.edit')->with('job', $job)->with('cities', $cities)->with('ages', $ages)->with('specialities', $specialities);
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
        $job = Offer::find($id);
        $job->title = $request->input('title');
        $job->city_id = $request->input('city');
        $job->age = $request->input('age');
        $job->speciality = $request->input('speciality');
        $job->contact = $request->input('contact');
        $job->description = $request->input('description');
        $job->phone = $request->input('phone');
        $job->email = $request->input('email');
        $job->alt_phone = $request->input('alt_phone');


        $job->save();

        return redirect()->back();
    }

    public function approve($id)
    {
        $jobs = Offer::find($id);
        $jobs->status = 1;
        $jobs->published_at = new \Date();
        $jobs->save();

        return redirect()->back();
    }

    public function remove($id)
    {
        $jobs = Offer::find($id);
        $jobs->delete();

        return redirect()->back();
    }

    public function ban($id)
    {
        $jobs = Offer::find($id);
        $jobs->status = 3;
        $jobs->save();

        return redirect()->back();
    }

    public function getInternshipForm($id)
    {
        $job = Offer::find($id);
        return view('admin.jobs.jobForm')->with('job', $job);
    }

}
