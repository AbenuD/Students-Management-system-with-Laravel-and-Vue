<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\DepartmentCourseMarkList;
use App\Models\DepartmentCourses;
use App\Models\MarkList;
use App\Models\StudentCourseMarkList;
use App\Models\StudentRequest;
use App\Models\TeacherCourses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentCoursesController extends Controller
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
    public function show($year, $semister)
    {
        $user = Auth::user();
        $markLists = [];
        $student = User::findorfail($user->id);
        $departmentId = $student->department_id;
        $studentRequest = StudentRequest::where('user_id', $user->id)
            ->where('year', $year)
            ->where('semister', $semister)
            ->where('status', 'approved');

        if ($studentRequest) {
            $departmentCourses = DepartmentCourses::where('department_id', $user->department_id)
                ->where('year', $year)
                ->where('semister', $semister)
                ->get();

            // dd($departmentCourses);
            if ($departmentCourses->isNotEmpty()) {
                foreach ($departmentCourses as $course) {
                    // dd($course);
                    $markList = MarkList::where('course_id', $course->id)->first();
                    if ($markList) {
                     
                        // return response()->json($markLists);
                        $markLists[] = [
                            'courseName' => $course->course_id ? Course::where('id',$course->course_id)->first()->courseName : 'No course',
                            'courseCode' => $course->course_id ? Course::where('id',$course->course_id)->first()->courseCode : '',
                            'creditHour' => $course->course_id ? Course::where('id',$course->course_id)->first()->creditHour : '0',
                            'mid' => $markList->mid ? $markList->mid : '-' ,
                            'assignment' => $markList->assignment ? $markList->assignment : '-',
                            'project' => $markList->project ? $markList->project : '-',
                            'final' => $markList->final ? $markList->final :'-',
                            $total = $markList->mid + $markList->assignment + $markList->project + $markList->final,
                            'total' => $total,
                            'grade' => ($total >= 90) ? 'A+' : (($total >= 85) ? 'A' : (($total >= 80) ? 'A-' : (($total >= 75) ? 'B+' : (($total >= 70) ? 'B' : (($total >= 65) ? 'B-' : (($total >= 60) ? 'C+' : (($total >= 50) ? 'C' : (($total >= 45) ? 'C-' : (($total >= 40) ? 'D' : (($total >= 35) ? 'Fx' : (($total >= 30) ? 'F' : 'Incomplete'))))))))))),
                            $teacher=TeacherCourses::where('course_id', $course->course_id)->first(),
                            'instructor' => $teacher ? User::where('id', $teacher->teacher_id)->first()->name : 'Will be introduce',
                        ];
                    }
                    $markLists[] = [
                        'courseName' => $course->course_id ? Course::where('id',$course->course_id)->first()->courseName : 'No course',
                        'courseCode' => $course->course_id ? Course::where('id',$course->course_id)->first()->courseCode : '',
                        'creditHour' => $course->course_id ? Course::where('id',$course->course_id)->first()->creditHour : '0',
                        'mid' => '-' ,
                            'assignment' => '-',
                            'project' => '-',
                            'final' => '-',
                            'total' => 0,
                            'grade' =>  'Incomplete',
                            $teacher=TeacherCourses::where('course_id', $course->course_id)->first(),
                            'instructor' => $teacher ? User::where('id', $teacher->teacher_id)->first()->name : 'Will be introduce',
                    ];
                        // dd($markList);
                }
            } else {
                return response()->json(['message' => 'No Courses found!']);
            }
            return response()->json($markLists);
        } else {
            return response()->json(['error' => 'Not registered Yet!'], 422);
        }
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
