<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::role('student')->get();
        $studentData = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'f_name' => $student->f_name,
                'phone' => $student->phone,
                'address' => $student->address,
                'gender' => $student->gender,
                'cafe' => $student->cafe,
                'email' => $student->email,
            ];
        });
        return $studentData;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        if (!Auth::check()) {
            throw new UnauthorizedException('You must be logged in to perform this action.',401);
        }
    
        // Check if the authenticated user has permission to create a user
        if (Gate::denies('create-user')) {
            throw new UnauthorizedException('You do not have permission to create a user.',401);
        }
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'f_name' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'age' => 'required',
            'email' => 'required',
            'cafe' => 'required'
        ]);
        if (!$validation->passes()) {
            return response()->json(['errors' => $validation->messages()], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->f_name = $request->f_name;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->age = $request->age;
        $user->email = $request->email;
        $user->cafe = $request->cafe;
        // $user->password = Hash::make(Str::random(8));
        $user->password = 'password';
        $user->batch = Date('Y');
        $user->save();
        $role = Role::where('name', 'student')->first();
        $user->assignRole($role);
        return response()->json([
            'status' => 'success',
            'message' => 'succesfully Registerd!',

        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = User::findorfail($id);
        $departmentId = $student->department_id;
        $department = Department::findOrFail($departmentId);
            return [
                'id' => $student->id,
                'name' => $student->name,
                'f_name' => $student->f_name,
                'phone' => $student->phone,
                'address' => $student->address,
                'gender' => $student->gender,
                'cafe' => $student->cafe,
                'email' => $student->email,
                'role' => $student->roles->first()->name,
                'noYears' => $department->noYears,
                'department' => $department->departmentName,
            ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


  
}
