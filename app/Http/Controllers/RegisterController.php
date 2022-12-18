<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\RegisterJob;
use App\Mail\RegisterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // user register function
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);        
        if ($validator->fails()) {            
            return response()->json(['success'=>false, 'message'=>$validator->errors()],404);
        }
        // mass asiggned data insert
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        if($user){
            // dispatch(new RegisterJob($data));
            $details['email'] = $request->email;
            dispatch(new RegisterJob($data));
            // Mail::to('sajol@gmail.com')->send(new RegisterMail());
            return response()->json(['success'=>true,'message'=>'User created successfully'], 200);
        }else{
            return response()->json(['success'=>false,'message'=>"user create fail"], 404);
        }
    }
}
