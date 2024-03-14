<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
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
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'invalid' => ['The provided credentials are incorrect.']
            ]);
        }
        $user = Auth::user();


        

        $roles = $user->roles->pluck('name')->toArray(); // Get an array of role names
    
        // Return different response and render different component based on the user's roles
        if (in_array('student', $roles)) {



            $departmentId = $user->department_id;
            if($departmentId){
                $department = Department::findOrFail($departmentId);
                $departmentName = $department->departmentName;
                $noYears = $department->noYears;
            }
            else{
                $departmentName = "Fresh Man";
                $noYears = 0;
            }
                $student = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'f_name' => $user->f_name,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'gender' => $user->gender,
                    'cafe' => $user->cafe,
                    'email' => $user->email,
                    'role' => $user->roles->first()->name,
                    'department_id' => $user->department_id,
                    'noYears' => $noYears,
                    'department' => $departmentName,
                ];



            return response()->json(['user' => $student, 'roles' => $roles, 'message' => 'Login successful!', 'component' => 'StudentHome'], 200);
        } elseif (in_array('teacher', $roles)) {
            return response()->json(['user' => $user, 'roles' => $roles, 'message' => 'Login successful!', 'component' => 'TeacherHome'], 200);
        } elseif (in_array('admin', $roles)) {
            return response()->json(['user' => $user, 'roles' => $roles, 'message' => 'Login successful!', 'component' => 'AdminHome'], 200);
        } elseif (in_array('dep_head', $roles)) {
            return response()->json(['user' => $user, 'roles' => $roles, 'message' => 'Login successful!', 'component' => 'TeacherHome'], 200);
        } 
        else {
            // Handle other roles or no role
            throw ValidationException::withMessages([
                'invalid' => ['You do not have access to this system.']
            ]);
        }

        // if(Auth::attempt($request->only('email','password'))){
        //     return response()->json([Auth::user(),'message' => 'Login succesfully!',200]);
        //     }
        // throw ValidationException::withMessages([
        //     'invalid' => ['The provided credentials are incorect.']
        // ]);
    }

    public function logout(){
        Auth::logout();
    }
}
