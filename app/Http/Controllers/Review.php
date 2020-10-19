<?php

namespace App\Http\Controllers;


use App\City;
use App\WorkTimeType;
use App\SalaryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Jenssegers\Date\Date;
use App\Review as ReviewModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class Review extends Controller
{

    protected $item_type = "review";


    public function index(Request $request)
    {
        return null;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'text' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $review = new ReviewModel($request->all());

        if(!empty(request()->photo_url)){
            $imageName = time() . '.' . request()->photo_url->getClientOriginalExtension();

            request()->photo_url->move(public_path('upload/images'), $imageName);

            $original_image_storage = public_path('upload/images/original/');
            $large_image_storage = public_path('upload/images/large/');
            $medium_image_storage = public_path('upload/images/medium/');
            $small_image_storage = public_path('upload/images/small/');
            $tiny_image_storage = public_path('upload/images/tiny/');
            $thumbnails_image_storage = public_path('upload/images/thumbnails/');

            //$file = request()-> file('image');


            $image = Image::make(public_path('upload/images') . '/' . $imageName);
            $image->save($original_image_storage . $imageName, 100)
                ->resize(860, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($large_image_storage . $imageName, 85)
                ->resize(640, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($medium_image_storage . $imageName, 85)
                ->resize(420, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($small_image_storage . $imageName, 85)
                ->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbnails_image_storage . $imageName, 85)
                ->resize(10, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->blur(1)->save($tiny_image_storage . $imageName, 85);
            $review->photo_url = '/upload/images/thumbnails/'.$imageName;
        }

        $review->save();

        return response()->json([ "message" => "Отзыв отправлен" ], 200);

    }


    public function show($id)
    {
        $data = Review::findOrFail($id);

        return view('frontend.'. $this->item_type .'.card', compact('data'));
    }
}
