<?php

namespace App\Http\Controllers;

use App\Offer;
use App\OfferSpecialization;
use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
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

        $filters['offer_type'] = 1;

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
            return view('site.internship.index')->with('offers', $offers)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages);

        return view ( 'site.internship.index' )->with ('query_message', 'Ничего не найдено!' )->with('offers', $offers)->with('specialities', $specialities)->with('cities', $cities)->with('ages', $ages);

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

        return view('site.internship.create')->with("organisation", $organisation)->with('specializations', $specializations)->with('cities', $cities);
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


        $internship = new Offer([
            'title' => $request->get('title'),
            'city_id' => $request->get('city'),
            'age' => $request->get('age'),
            'speciality' => $request->get('speciality'),
            'contact' => $request->get('contact'),
            'offer_type' => 1,
            'description' => $request->get('description'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'alt_phone' => $request->get('alt_phone'),
            'organisation_id' => $organisation,
        ]);
        $internship->save();
        return redirect('/organisation#internship')->with('success', 'Offer saved!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $internship = Offer::findOrFail($id);

        return view('site.internship.card', compact('internship'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        $specialities = OfferSpecialization::all();
        return view('site.internships-for-teens.edit')->with('internship', $internship)->with('cities', $cities)->with('ages', $ages)->with('specialities', $specialities);
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
        $internship->title = $request->get('title');
        $internship->city_id = $request->get('city');
        $internship->age = $request->get('age');
        $internship->speciality = $request->get('speciality');
        $internship->contact = $request->get('contact');
        $internship->description = $request->get('description');
        $internship->phone = $request->get('phone');
        $internship->email = $request->get('email');
        $internship->alt_phone = $request->get('alt_phone');
        $internship->status = 0;

        $internship->save();

        return redirect('/internships-for-teens/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $internship = Offer::find($id);
        $internship->delete();

        return redirect('/internships-for-teens')->with('success', 'Offer deleted!');
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
