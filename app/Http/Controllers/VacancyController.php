<?php

namespace App\Http\Controllers;

use App\Offer;
use App\OfferSpecialization;
use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacancyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->only(['city_id', 'date', 'type_id', 'speciality']);
        $age_filter=[
            ['age', '>=', 14]
        ];
        if($request->has('age')) {
            $age_filter = [
                ['age', '<=', $request->get('age')]
            ];
        }

        $filters['offer_type'] = 2;

        if($request->has('query')) {

            $offers = Offer::where('status', 1)
                ->where('status', 1)
                ->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->get('query').'%')
                        ->orWhere('description', 'like', '%'.$request->get('query').'%');
                })
                ->where($filters)
                ->where($age_filter)
                ->orderBy('published_at', 'asc')
                ->paginate(30)
                ->onEachSide(1);
        }
        else{

            $offers = Offer::where('status', 1)
                ->where($filters)
                ->orderBy('published_at', 'asc')
                ->paginate(30)
                ->onEachSide(1);
        }

        $pagination = $offers->appends($_GET);


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
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);
        if (count ( $offers ) > 0)
            return view('site.vacancy.index')->with('offers', $offers)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages);

        return view ( 'site.vacancy.index' )->with ('query_message', 'Ничего не найдено!' )->with('offers', $offers)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organisation = Auth::user()->id;
        $specializations = OfferSpecialization::all();
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);
        return view('site.vacancy.create')->with("organisation", $organisation)->with('specializations', $specializations)->with('cities', $cities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organisation = Auth::user()->id;


        $vacancy = new Offer([
            'title' => $request->get('title'),
            'city_id' => $request->get('city'),
            'age' => $request->get('age'),
            'speciality' => $request->get('speciality'),
            'contact' => $request->get('contact'),
            'offer_type' => 2,
            'description' => $request->get('description'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'alt_phone' => $request->get('alt_phone'),
            'organisation_id' => $organisation,
        ]);
        $vacancy->save();
        return redirect('/organisation#vacancy')->with('success', 'Offer saved!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vacancy = Offer::findOrFail($id);

        return view('site.vacancy.card', compact('vacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        return view('site.vacancy.edit')->with('vacancy', $vacancy)->with('cities', $cities)->with('ages', $ages)->with('specialities', $specialities);
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
        $vacancy->status = 0;

        $vacancy->save();

        return redirect('/vacancy/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vacancy = Offer::find($id);
        $vacancy->delete();

        return redirect('/vacancies')->with('success', 'Offer deleted!');
    }


    public function archive($id)
    {
        $offer = Offer::find($id);
        if($offer->organisation_id == Auth::user()->id) {
            $offer->status = 2;
            $offer->save();
        }

        return redirect()->back();
    }

    public function unarchive($id)
    {
        $offer = Offer::find($id);
        if($offer->organisation_id == Auth::user()->id) {
            $offer->status = 0;
            $offer->save();
        }

        return redirect()->back();
    }


}
