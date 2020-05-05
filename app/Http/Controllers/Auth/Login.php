<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Organisation;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;


class Login extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = route('organisation.index');
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo(){


        if(!(Organisation::findorFail(Auth::id())->role))
            return route('admin.index');

        return $this->redirectTo;

    }

    public function logout() {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
