<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;


class RulesPagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function conditions()
    {
        return view('site.conditions');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function support()
    {
        return view('site.support');
    }

    public function getTermsOfUse()
    {
        return view('site.termsOfUse');
    }

    public function getInternRules()
    {
        return view('site.internRules');
    }

    public function getVolunteerRules()
    {
        return view('site.volunteerRules');
    }

    public function howSupport()
    {
        return view('site.how-support');
    }

    public function sendEmail(Request $request)
    {
        $data = $request->all();

        Mail::send(['text'=>'emails.contact'], $data, function($message) {
            $message->to('teenjob.by@gmail.com', 'Сообщение')->subject
            ('Сообщение');
            $message->from('team@teenjob.by','Сообщение');
        });

        return redirect()->back()->with(['message', 'Письмо успешно отправлено']);
    }

}
