<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Imports\CoursesImport;
use App\Models\Department;
use App\Models\DepartmentCourses;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
    // public function uploadCourses(Request $request)
    // {
    //     $validation = Validator::make($request->all(), [
    //         'file' => 'required|mimes:xlsx,xls',
    //         'department_id' => 'required',
    //         'semister' => 'required',
    //         'year' => 'required',
    //     ]);

    //     if (!$validation->passes()) {
    //         return response()->json(['errors' => $validation->messages()], 422);
    //     }
    //     if (!$request->hasFile('file')) {
    //         return response()->json(['message' => 'File field is missing in the request'], 422);
    //     }
    //     $file = $request->file('file');

    //     Log::info('Uploaded file: ' . $file->getClientOriginalName());

    //     try {
    //         Excel::import(new CoursesImport, $file);
    //          $import = new CoursesImport();
    //          $courses = Excel::toArray($import, $file);
    //         $coursesImport = new CoursesImport();
    //         $importedCourses = $coursesImport->getImportedCourses();


    //         // Process the imported courses as needed
    //         if ($importedCourses !== null) {
    //             foreach ($importedCourses as $course) {
    //                 // Process each $course


    //                 $existingEntry = DepartmentCourses::where([
    //                     'department_id' => $request->department_id,
    //                     'course_id' => $course->id,
    //                     'semister' => $request->semister,
    //                     'year' => $request->year,
    //                 ])->first();

    //                 if (!$existingEntry) {

    //                     $departmentCourses = new DepartmentCourses();
    //                     $departmentCourses->year = $request->year;
    //                     $departmentCourses->semister = $request->semister;
    //                     $departmentCourses->department_id = $request->department_id;
    //                     $departmentCourses->course_id = $course->id; //watch
    //                     $departmentCourses->save();

    //                     Log::info($departmentCourses);
    //                     Log::info('New DepartmentCourses entry created for course: ' . $course->id);
    //                 } else {
    //                     Log::info('DepartmentCourses entry already exists for course: ' . $course->id);
    //                 }
    //             }
    //             Log::info($course);
    //         } else {
    //             Log::info('DepartmentCourses is not set.');
    //         }
    //         Log::info('Courses imported successfully');
    //         return response()->json(['message' => 'Courses uploaded successfully'], 200);
    //     } catch (\Exception $e) {
    //         // Log the exception for debugging purposes
    //         Log::error('Error uploading courses: ' . $e->getMessage());

    //         // Return a response with the error message
    //         return response()->json(['message' => 'Error uploading courses: ' . $e->getMessage()], 500);
    //     }


    // }


    public function uploadCourses(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls',
            'department_id' => 'required',
            'semister' => 'required',
            'year' => 'required',
        ]);

        if (!$validation->passes()) {
            return response()->json(['errors' => $validation->messages()], 422);
        }

        if (!$request->hasFile('file')) {
            return response()->json(['message' => 'File field is missing in the request'], 422);
        }

        $file = $request->file('file');

        Log::info('Uploaded file: ' . $file->getClientOriginalName());

        try {
            $import = new CoursesImport();
            $courses = Excel::toArray($import, $file);

            foreach ($courses[0] as $course) {
                $department = Department::find($request->department_id);
                if ($department) {
                    if ($course['code'] && $course['name'] && $course['chr']) {
                        $existingCourse = Course::where('courseCode', $course['code'])->first();

                        if (!$existingCourse) {
                            $newCourse = Course::create([
                                'courseCode' => $course['code'],
                                'courseName' => $course['name'],
                                'creditHour' => $course['chr'],
                            ]);
                        } else {
                            $newCourse = $existingCourse;
                        }

                        // Attach course to department if not already attached

                        if ($department && !$department->courses()->where('course_id', $newCourse->id)->exists()) {
                            $department->courses()->attach($newCourse->id, [
                                'semister' => $request->semister,
                                'year' => $request->year,
                            ]);

                            Log::info('New DepartmentCourses entry created for course: ' . $newCourse->id);
                        } else {
                            Log::info('DepartmentCourses entry already exists for course: ' . $course['code']);
                        }
                    } else {
                        Log::error('Empty courseName, courseCode, or creditHour');
                    }
                } else {
                    return response()->json(['message' => 'There is no such Department'], 500);
                    Log::error('There is no such department');
                }
            }

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
