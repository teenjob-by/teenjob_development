<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Organisation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class Auth extends Controller
{
    public function login(Request $request){

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $user = Organisation::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Teenjob ')->accessToken;
                $response = ['access_token' => $token, 'token_type' => 'Bearer'];
                return response()->json($response, 200);
            } else {
                $response = "Password missmatch";
                return response()->json($response, 422);
            }

        } else {
            $response = 'User does not exist';
            return  response()->json($response, 422);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            //'city' => ['required'],
            'contactPerson' => ['required', 'string', 'max:255'],
            'unique_identifier' => ['required', 'digits:9'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:organisations'],
            'password' => ['min:6', 'required_with:password_confirmation','same:password_confirmation'],
            'password_confirmation' => ['min:6']
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $user = Organisation::create([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'type' => $request->input('type'),
            'unique_identifier' => $request->input('unique_identifier'),
            'city_id' => $request->input('city'),
            'contact' => $request->input('contactPerson'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 1,
            'api_token' => Str::random(60),
        ]);

        $token =  $user->createToken('Teenjob')-> accessToken;
        $response = ['access_token' => $token, 'token_type' => 'Bearer'];
        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response()->json($response, 200);
    }

}
