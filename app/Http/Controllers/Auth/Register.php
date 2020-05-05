<?php

namespace App\Http\Controllers\Auth;

use App\City;
use App\Organisation;
use App\Http\Controllers\Controller;
use App\OrganisationType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class Register extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/organisation';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            //'city' => ['required'],
            'contactPerson' => ['required', 'string', 'max:255'],
            'unique_identifier' => ['required', 'digits:9'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:organisations'],
            'password' => ['min:6', 'required_with:password_confirmation','same:password_confirmation'],
            'password_confirmation' => ['min:6']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Organisation
     */
    protected function create(array $data)
    {
        if($data['password'] == $data['password_confirmation']) {
            return Organisation::create([
                'name' => $data['name'],
                'link' => $data['link'],
                'type' => $data['type'],
                'unique_identifier' => $data['unique_identifier'],
                'city_id' => $data['city'],
                'contact' => $data['contactPerson'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 1,
                'api_token' => Str::random(60),
            ]);
        }
        return redirect()->route('auth.registration');
    }

    public function showRegistrationForm()
    {
        $types = OrganisationType::all();
        $cities = City::all();
        $lastCity = $cities->pop();
        $cities = $cities->prepend($lastCity);

        return view("auth.register")->with("types", $types)->with("cities", $cities);
    }

    public function redirectTo(){
        return route('organisation.index');
    }
}
