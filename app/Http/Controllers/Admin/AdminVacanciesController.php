<?php

namespace App\Http\Controllers\Admin;

use App\Offer;
use App\OfferSpecialization;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Date\Date;

class AdminVacanciesController extends Controller
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


        $vacancies = Offer::where('offer_type', 2)
            ->whereIn('status', [1, 2])
            ->orderBy('created_at', 'desc')
            ->paginate(30)
            ->onEachSide(1);


        $specializations = OfferSpecialization::all();
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);
        if (count ( $vacancies ) > 0)
            return view('admin.vacancies.index')->with('vacancies', $vacancies)->with('specializations', $specializations)->with('cities', $cities);

        return view ( 'admin.vacancies.index' )->with ('query_message', 'Ничего не найдено!' )->with('vacancies', $vacancies)->with('specializations', $specializations)->with('cities', $cities);

    }

    public function showUnapproved()
    {
        $vacancies = Offer::where('offer_type', 2)
            ->whereIn('status', [0, 3])
            ->orderBy('status', 'asc')
            ->paginate(30)
            ->onEachSide(1);

        return view('admin.vacancies.index')->with('vacancies', $vacancies);
    }

    public function edit($id)
    {
        $vacancy = Offer::find($id);

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
        return view('admin.vacancies.edit')->with('vacancy', $vacancy)->with('cities', $cities)->with('ages', $ages)->with('specialities', $specialities);
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
        $vacancy = Offer::find($id);
        $vacancy->title = $request->get('title');
        $vacancy->city_id = $request->get('city');
        $vacancy->age = $request->get('age');
        $vacancy->speciality = $request->get('speciality');
        $vacancy->contact = $request->get('contact');
        $vacancy->description = $request->get('description');
        $vacancy->phone = $request->get('phone');
        $vacancy->email = $request->get('email');
        $vacancy->alt_phone = $request->get('alt_phone');


        $vacancy->save();

        return redirect()->back();
    }

    public function approve($id)
    {
        $vacancies = Offer::find($id);
        $vacancies->status = 1;
        $vacancies->published_at = new \Date();
        $vacancies->save();

        return redirect()->back();
    }

    public function remove($id)
    {
        $vacancies = Offer::find($id);
        $vacancies->delete();

        return redirect()->back();
    }

    public function ban($id)
    {
        $vacancies = Offer::find($id);
        $vacancies->status = 3;
        $vacancies->save();

        return redirect()->back();
    }

    public function getInternshipForm($id)
    {
        $vacancy = Offer::find($id);
        return view('admin.vacancies.vacancyForm')->with('vacancy', $vacancy);
    }

}
