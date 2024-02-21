<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        if(!$validation->passes()){
            return response()->json(['errors'=>$validation->messages()], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->f_name= $request->f_name;
        $user->address= $request->address;
        $user->gender= $request->gender;
        $user->phone= $request->phone;
        $user->age= $request->age;
        $user->email= $request->email;
        $user->cafe= $request->cafe;
        // $user->password = Hash::make(Str::random(8));
        $user->password = 'password';
        $user->batch = Date('Y');
        $user->save();
        $role = Role::where('name', 'student')->first();
        $user->assignRole($role);
            return response()->json([
                'status'=> 'success',
                'message' => 'succesfully Registerd!',

            ]);
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
