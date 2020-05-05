<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;


class StaticPage extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }

    public function conditions()
    {
        return view('frontend.conditions');
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
