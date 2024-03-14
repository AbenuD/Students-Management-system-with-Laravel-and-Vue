<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\TeacherCourses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherCoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coursesWithTeachers = Course::with('teachers')->get();
        // dd($coursesWithTeachers);
        // Now you can loop through $coursesWithTeachers to access each course and its associated teacher
        $responseData = [];
        foreach ($coursesWithTeachers as $course) {
            $teachers = $course->teachers;
            foreach ($teachers as $teacher) {
                $responseData[] = [
                    'teacher_name' => $teacher->name,
                    'teacher_email' => $teacher->email,
                    'courseName' => $course->courseName,
                    'courseCode' => $course->courseCode, // Assuming code is a field in the Course model
                    'creditHour' => $course->creditHour, // Assuming credit_hours is a field in the Course model
                ];
            }
        }

        return response()->json($responseData);
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
    public function getTeacherCourses()
    {
        $teacherId = Auth::user()->id;
        $teacher = User::with('teacherCourses.departmentCourses.course.students')->find($teacherId);
        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }
        foreach ($teacher->teacherCourses as $course) {
            if ($course->departmentCourses->isNotEmpty()) {
                foreach ($course->departmentCourses as $departmentCourse) {
                    $noStudents = $departmentCourse->course->students->count();
                    $courses[] = [
                        'id' => $course->id,
                        'courseName' => $course ? $course->courseName : 'No course',
                        'courseCode' => $course ? $course->courseCode : '',
                        'creditHour' => $course ? $course->creditHour : '0',
                        'department' => $departmentCourse->department->departmentName,
                        'noStudents' => $noStudents
                    ];
                }
            }
        }
        // dd($courses);
        return response()->json(['courses' => $courses]);
    }
    public function show(TeacherCourses $teacherCourses)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherCourses $teacherCourses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherCourses $teacherCourses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherCourses $teacherCourses)
    {
        //
    }
}
