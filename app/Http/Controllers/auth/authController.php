<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

class authController extends Controller
{
    function loginUser(Request $request){
       $validation = Validator::make($request->all(),[
        'email'->'required|string|email|exists:users,email',
        'password'-> 'required|string'
       ]);
    //    If email not present in DB 
    if($validation->fails()){
        return response() -> json(['status'->400,'message'->$validation->error()->first()]);
    }else{
        $cred = array('email'->$request->email,'password'->$request->password);
        // Right auth 
        if(Auth::attempt($cred,false)){
            if(Auth::User()->hasRole('admin')){
                return response()->json(['status'->200,'message'->'Admin user' , 'url'=> 'admin/dashboard' ]);
            }else{
                return response()->json(['status'->200,'message'->'Non user']);
            }
        }else{
            return response()->json(['status'->404,'message'->'Wrong Cred']);
        }
    }
    }
}
