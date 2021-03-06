<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\GlobalMetric;
use App\Downloading_email;
use Mail;
use Illuminate\Http\Response;



class StaticPage extends Controller
{
    public function home()
    {
        $organisation_count = GlobalMetric::where("name", "organisation_count")->get();



        $counters = [300, 8, $organisation_count[0]->value];

        return view('frontend.home')->with('counters', $counters);
    }

    public function conditions()
    {
        return view('frontend.conditions');
    }

    public function download()
    {
            $headers = [
                'Content-Type' => 'application/pdf',
                'Access-Control-Allow-Origin' => '*',
            ];

            $file = public_path()."/downloads/Мониторинг_и_оценка_среднего_образования_Беларуси_2020.pdf";

            $counter = GlobalMetric::where("name", "results_downloaded_count")->get();
            $counter[0]->value = (($counter[0]->value) + 1);
            $counter[0]->save();

            return response()->download($file, "Мониторинг_и_оценка_среднего_образования_Беларуси_2020.pdf", $headers);

    }

    public function leaveEmail(Request $request)
    {

        if($request->email)
        {
            $email = new Downloading_email([
                'email' => $request->input('email')
            ]);
            $email->save();

            return response()->json([ "message" => "Ok" ], 200);
        }

        return response()->json([ "message" => "fail" ], 500);

    }

    public function supportUs()
    {
        return view('frontend.supportUs');
    }

    public function aboutUs()
    {
        return view('frontend.aboutUs');
    }

    public function employmentLaw()
    {
        return view('frontend.employmentLaw');
    }

    public function faq()
    {
        return view('frontend.faq');
    }

    public function termsOfUse()
    {
        return view('frontend.termsOfUse');
    }

    public function whoIsIntern()
    {
        return view('frontend.whoIsIntern');
    }

    public function whoIsVolunteer()
    {
        return view('frontend.whoIsVolunteer');
    }

    public function feedback()
    {
        return view('frontend.feedback');
    }

    public function rulesForEmployers()
    {
        return view('frontend.rulesForEmployers');
    }

    public function sendEmail(Request $request)
    {
        $data = $request->all();

        Mail::send(['text'=>'emails.contact'], $data, function($message) {
            $message->to(config('mail.to'), 'Сообщение')->subject('Сообщение');
            $message->from(config('mail.from.address'),'Сообщение');
        });

        return redirect()->back()->with(['message', 'Письмо успешно отправлено']);
    }

}
