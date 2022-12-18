<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // user login 
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return "error";
        }else{
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user = Auth::user();
                $token = $user->createToken('user Toekn')->accessToken;
                return response()->json($token, 200);
            }else{
                return response()->json('fail',404);
            }
        }        
    }

    // login user data return function
    public function user()
    {
        return response()->json(Auth::user(), 200);
    }

    // user logout function
    public function logout(Request $request)
    {
        $token = Auth()->guard('api')->user()->token();
	    $token->revoke();
	    $response = ['message' => 'You have been successfully logged out!'];
	    return response($response, 200);
    }
}
