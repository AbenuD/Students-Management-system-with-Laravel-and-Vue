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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\UnauthorizedException;

class MarkListController extends Controller
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
    public function MarkList()
    {
        $teacher = Auth::user();

        // Fetch teacher courses for the teacher
        $teacherCourses = TeacherCourses::where('teacher_id', $teacher->id)->get();
        dd($teacherCourses);
        $markLists = [];

        foreach ($teacherCourses as $teacherCourse) {
            // Retrieve the mark list for the teacher's course
            $markList = $teacherCourse->markList;
            $markList = MarkList::where('course_id', $teacherCourse->id)->where('course_id', $course_id)->first();
            dd($markList);
            // If a mark list is found, add it to the array along with the course information
            if ($markList) {
                $total = $markList->mid + $markList->assignment + $markList->project + $markList->final;
                $grade = ($total >= 90) ? 'A+' : (($total >= 85) ? 'A' : (($total >= 80) ? 'A-' : (($total >= 75) ? 'B+' : (($total >= 70) ? 'B' : (($total >= 65) ? 'B-' : (($total >= 60) ? 'C+' : (($total >= 50) ? 'C' : (($total >= 45) ? 'C-' : (($total >= 40) ? 'D' : (($total >= 35) ? 'Fx' : (($total >= 30) ? 'F' : 'Incomplete')))))))))));

                $markLists[] = [
                    'courseName' => $teacherCourse->departmentCourse->course->courseName,
                    'courseCode' => $teacherCourse->departmentCourse->course->courseCode,
                    'creditHour' => $teacherCourse->departmentCourse->course->creditHour,
                    'mid' => $markList->mid,
                    'assignment' => $markList->assignment,
                    'project' => $markList->project,
                    'final' => $markList->final,
                    'total' => $total,
                    'grade' => $grade,
                    'instructor' => $teacher->name,
                ];
            }
        }
        dd($markLists);
    }

    public function updateStudentMarkList(Request $request)
    {
        if (!Auth::check()) {
            throw new UnauthorizedException('You must be logged in to perform this action.', 401);
        }
        $request->validate([
            'student_id' => 'required|integer',
            'course_id' => 'required|integer',
            'mid' => 'numeric|between:0,100', // Validation for mid
            'assignment' => 'numeric|between:0,100', // Validation for assignment
            'project' => 'numeric|between:0,100', // Validation for project
            'final' => 'numeric|between:0,100', // Validation for final
            // Add more validation rules as needed
        ]);
        // dd($request->stuMark->mid);
        // dd($request->data);
            $markList = new MarkList();
            $markList->student_id = $request->student_id;
            $markList->course_id = $request->course_id;
            $markList->mid = $request->mid;
            $markList->assignment = $request->assignment;
            $markList->project = $request->project;
            $markList->final = $request->final;
            // dd($markList);
            $markList->save();
            return response()->json(['markList'=> $markList,'message' => 'Mark list updated!']);

    }
    public function getMarkListsOfCourse($course_id)
    {
        $teacher = Auth::user();
        $departmentId = $teacher->department_id;
        // $students = User::whereHas('studentCourses', function ($query) use ($course_id) {
        //     $query->where('course_id', $course_id);
        // })->get();
        // dd($department);
        $department = Department::where('id', $departmentId)->with('students')->get();
        // dd($students);
        // Step 2: Fetch mark list details for the identified students
        $markLists = [];
        foreach ($department as $dep) {
            foreach ($dep->students as $student) {

                // dd($student);
                $markList = MarkList::where('student_id', $student->id)->where('course_id', $course_id)->first();
                if (!$markList) {
                    $markLists[] = [
                        'student_id' => $student->id,
                        'course_id' => $course_id,
                        'name' => $student->name,
                        'id' => "IG-0109",
                        'mid' => 0,
                        'assignment' => 0,
                        'project' => 0,
                        'final' => 0,
                        'total' => 0,
                        'grade' => 'Incomplete',
                    ];
                }
                if ($markList) {
                    $total = $markList->mid + $markList->assignment + $markList->project + $markList->final;
                    $grade = ($total >= 90) ? 'A+' : (($total >= 85) ? 'A' : (($total >= 80) ? 'A-' : (($total >= 75) ? 'B+' : (($total >= 70) ? 'B' : (($total >= 65) ? 'B-' : (($total >= 60) ? 'C+' : (($total >= 50) ? 'C' : (($total >= 45) ? 'C-' : (($total >= 40) ? 'D' : (($total >= 35) ? 'Fx' : (($total >= 30) ? 'F' : 'Incomplete')))))))))));

                    $markLists[] = [
                        'student_id' => $student->id,
                        'course_id' => $course_id,
                        'name' => $student->name,
                        'id' => "IG-0109",
                        'mid' => $markList->mid,
                        'assignment' => $markList->assignment,
                        'project' => $markList->project,
                        'final' => $markList->final,
                        'total' => $total,
                        'grade' => $grade,
                    ];
                }
                // dd($markLists);
            }
        }

        return response()->json(['markLists' => $markLists]);
    }
    public function show()
    {
        // want to show student list of courses with a marklist for a given year,semister

        $user = Auth::user();
        $student = User::findorfail($user->id);
        $departmentId = $student->department_id;
        $year = 1;
        $semister = 1;
        $markLists = [];

        $markListss = MarkList::where('courses_id', 1)->with('student')->get();
        // return response()->json($marks);

        // $markLists = MarkList::where('teacher_id', $user->id)
        //             // ->where('dep_course_id', $departmentCourse->id)
        //             ->get();
        dd($markListss);
        if ($markListss) {
            //i get courses in that year and semister now i want to feach the marklist

            // Iterate through each department course and retrieve the mark list for the student
            foreach ($markListss as $markList) {
                // Retrieve the mark list for the student in the current department course
                $departmentCourses = DepartmentCourses::whereHas('markLists', function ($query) use ($departmentId, $year, $semister) {
                    $query->where('year', $year)
                        ->where('semister', $semister)
                        ->where('department_id', $departmentId);
                })->first();

                // If a mark list is found, add it to the array along with the department course information
                // if ($markList) {
                $markLists[] = [
                    'student' => $markList->stu_id ? User::where('id', $markList->stu_id)->first()->name : 'No Name',
                    'mid' => $markList->mid,
                    'assignment' => $markList->assignment,
                    'project' => $markList->project,
                    'final' => $markList->final,
                    $total = $markList->mid + $markList->assignment + $markList->project + $markList->final,
                    'total' => $total,
                    'grade' => ($total >= 90) ? 'A+' : (($total >= 85) ? 'A' : (($total >= 80) ? 'A-' : (($total >= 75) ? 'B+' : (($total >= 70) ? 'B' : (($total >= 65) ? 'B-' : (($total >= 60) ? 'C+' : (($total >= 50) ? 'C' : (($total >= 45) ? 'C-' : (($total >= 40) ? 'D' : (($total >= 35) ? 'Fx' : (($total >= 30) ? 'F' : 'Incomplete'))))))))))),
                    'instructor' => $markList->teacher_id ? User::role('teacher')->where('id', $markList->teacher_id)->first()->name : 'Will be introduced',
                ];
                // }
            }
        }

        return response()->json($markLists);
        // } else {
        //     return response()->json(['error' => 'Not registered Yet!'], 422);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MarkList $markList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MarkList $markList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarkList $markList)
    {
        //
    }
}
