<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\DepartmentCourses;
use Illuminate\Http\Request;

class DepartmentCoursesController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($departmentId, $year, $semister)
    {
       
        $courses = Course::whereHas('departments', function ($query) use ($departmentId, $year, $semister) {
            $query->where('department_id', $departmentId)
                ->where('year', $year)
                ->where('semister', $semister);
        })->get();
        return response()->json($courses);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepartmentCourses $departmentCourses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DepartmentCourses $departmentCourses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentCourses $departmentCourses)
    {
        //
    }
}
