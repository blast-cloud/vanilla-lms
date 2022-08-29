<?php

namespace App\Http\Controllers\Auth; 

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Response;
use Session;
use App\Rules\BIMSStateRule;

class BimsController extends AppBaseController
{
    public function login(Request $request)
    {
        if (request()->has('code') && request()->has('state')) {

            $validation = Validator::make(['state' => $request->get('state'), 'code' => $request->get('code')], 
            ['code' => ['required'], 'state' => ['required', new BIMSStateRule()]], 
            ['code.required' => "couldn't get authorization"]);

            if ($validation->fails()) {

                return redirect()->route('login')->withErrors($validation);
            }
            try {
                //code...
                $response = Http::acceptJson()->post('https://bims.tetfund.gov.ng/oauth/token', [

                    "grant_type" => "authorization_code",
                    "client_id" => env('BIMS_CLIENT_ID'),
                    "client_secret" => env('BIMS_CLIENT_SECRET'),
                    "code" => $request->get('code'),
                    "redirect_uri" => "http://localhost:8000",
                ])->throw(function ($response, $e) {
                    //
                });
                if ($response->ok() && $response->successful()) {
                    $res = json_decode($response->body());
                    $user = User::where('email', $res->user->email)->first();

                    if ($user != null) 
                    {
                        Auth::login($user, true);
                    } else {
                        $validation->after(function ($validator) {
                            $validator->errors()->add(
                                  'not_found', 'Please contact the system administrator to onboard you to the platform');
                           });
        
                        if ($validation->fails()) 
                        {
                            return redirect()->route('login')->withErrors($validation);
                        }
                    }
                    Session::put('access_token', $res->access_token);             
                    return redirect()->intended('home');
                }

            } catch (\Illuminate\Http\Client\RequestException $th) {
                //throw $th;
                $validation->after(function ($validator) 
                {
                    $validator->errors()->add(
                        'network', 'Something went wrong, please try again');
                });

                if ($validation->fails()) 
                {
                    return redirect()->route('login')->withErrors($validation);
                }
            }
        }
        return redirect()->intended('home');
    }
}