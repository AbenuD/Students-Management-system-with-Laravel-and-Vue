<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function login(Request $request){
          $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(!$validation->passes()){
            return response()->json(['errors'=>$validation->messages()], 422);
        }
        if(Auth::attempt($request->only('email','password'))){
            return response()->json([Auth::user(),'message' => 'Login succesfully!',200]);
            }
        throw ValidationException::withMessages([
            'invalid' => ['The provided credentials are incorect.']
        ]);
    }

    public function logout(){
        Auth::logout();
    }
}
