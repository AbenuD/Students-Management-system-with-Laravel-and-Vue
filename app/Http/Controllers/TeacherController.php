<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentCourses;
use App\Models\TeacherCourses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $teachers = User::role('dep_head')->get();
        // $teacherData = $teachers->map(function ($teacher) {
        //     return [
        //         'id' => $teacher->id,
        //         'name' => $teacher->name,
        //         'f_name' => $teacher->f_name,
        //         'phone' => $teacher->phone,
        //         'address' => $teacher->address,
        //         'gender' => $teacher->gender,
        //         'email' => $teacher->email,
        //         'department_id' => $teacher->department_id ? $teacher->department_id : null,
        //         'department' => $teacher->department_id ? Department::findOrFail($teacher->department_id)->departmentName : 'Have not Assigned to any Department'
        //     ];
        // });
        // $departments = Department::with('dep_head')->get();
        // foreach ($departments as $department) {
        //     $department->load(['dep_head' => function ($query) {
        //         $query->whereHas('roles', function ($q) {
        //             $q->where('name', 'dep_head');
        //         });
        //     }]);
        // }
        // $departments = Department::with(['dep_head' => function ($query) {
        //     $query->whereHas('roles', function ($q) {
        //         $q->where('name', 'dep_head');
        //     });
        // }])->get();

        $departments = Department::whereHas('dep_head', function ($query) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'dep_head');
            });
        })->with('dep_head')->get();
        return $departments;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function depTeacher(String $id)
    {

        $department = Department::findOrFail($id);
        // dd($department);
        if ($department) {

            $teachers =  $department->teachers()->get();

            // dd($teachers);
            return response()->json($teachers);
        }





        // $teachers = User::role('teacher')
        // ->whereHas('department', function ($query) use ($id) {
        //     $query->where('department_id', $id);
        // })
        // ->get();
    }

    public function assignTeacher(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:users,id'
        ]);
        if (!$validation->passes()) {
            return response()->json(['errors' => $validation->messages()], 422);
        }

        $courseId = $request->course_id;
        $teacherId = $request->teacher_id;
        $departmentId = Auth::user()->department_id;
        $alreadyAssigned = TeacherCourses::where('teacher_id', $teacherId)
            ->where('course_id', $courseId)
            ->exists();

        if ($alreadyAssigned) {
            return response()->json(['error' => 'The teacher is already assigned to the same course.'], 422);
        }

        $departmentCourses = DepartmentCourses::where('department_id', $departmentId)
            ->where('course_id', $courseId)
            ->first();
        if ($departmentCourses) {
            $teacherCourses = new TeacherCourses();
            $teacherCourses->teacher_id = $request->teacher_id;
            $teacherCourses->course_id = $request->course_id;
            $teacherCourses->save();
            return response()->json(['message' => 'Teacher assigned for this course successfully.']);
        }
    }
    public function assignHead(Request $request)
    {
        // Validate the request data
        // Find the student request by ID
        // $user = User::findOrFail($id);
        // $user->assignRole('dep_head');
        // $roles = $user->roles->pluck('name')->toArray();
        // return response()->json($roles);



        $validation = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'teacher_id' => 'required|exists:users,id'
        ]);
        if (!$validation->passes()) {
            return response()->json(['errors' => $validation->messages()], 422);
        }

        // Find the department and teacher based on the provided IDs
        $department = Department::findOrFail($request->department_id);
        $teacher = User::findOrFail($request->teacher_id);

        // Check if the selected user is already assigned as the department head
        if ($department->dep_head && $department->dep_head->id === $teacher->id) {
            return response()->json(['error' => 'Selected teacher is already the department head.'], 400);
        }

        // Remove the dep_head role from the current department head, if any
        if ($department->dep_head) {
            $department->dep_head->removeRole('dep_head');
        }

        // Assign the dep_head role to the selected teacher
        $teacher->assignRole('dep_head');

        // Update any necessary department records or relationships here if needed

        // Return a success message
        return response()->json(['message' => 'Teacher assigned as department head successfully.']);
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
    public function update(Request $request, string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
