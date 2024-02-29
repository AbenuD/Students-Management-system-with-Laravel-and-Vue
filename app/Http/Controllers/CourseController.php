<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Imports\CoursesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
class CourseController extends Controller
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
    

    // in the controller part below
    public function uploadCourses(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        $file = $request->file('file');

        Log::info('Uploaded file: ' . $file->getClientOriginalName());

        try {
            Excel::import(new CoursesImport, $file);
            Log::info('Courses imported successfully');
            return response()->json(['message' => 'Courses uploaded successfully'], 200);
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error uploading courses: ' . $e->getMessage());
    
            // Return a response with the error message
            return response()->json(['message' => 'Error uploading courses: ' . $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
