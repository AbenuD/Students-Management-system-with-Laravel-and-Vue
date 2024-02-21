<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
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
    public function store(Request $request)
    {
          $validation = Validator::make($request->all(), [
            'departmentName' => 'required|string|max:255',
            'noYears' => 'required',
        ]);

        if(!$validation->passes()){
            return response()->json(['errors'=>$validation->messages()], 422);
        }

        $department = new Department();
            $department->departmentName= $request->departmentName;
            $department->noYears= $request->noYears;
            $department->save();
        return response()->json([
            'departmentId' => $department->id,
            'noYears' => $department->noYears
        ], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
