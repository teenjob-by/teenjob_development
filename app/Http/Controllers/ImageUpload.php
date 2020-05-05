<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class ImageUpload extends Controller
{

    public function imageUploadPost()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        $imageName = time().'.'.request()->image->getClientOriginalExtension();

        request()->image->move(public_path('upload/images'), $imageName);

        return back()
            ->with('success','You have successfully upload image.')
            ->with('image',$imageName);

    }

}
