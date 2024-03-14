<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\StudentRequest;
use App\Models\User;
use Database\Factories\StudentRequestFactory;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class StudentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if the theacher has advisor and teacher role && if the department_id of Student Request and the department_id of the teacher is the same
        // return the studentRequest which has the same department id with the teacher
        $user = Auth::user();
        if (!Auth::check()) {
            throw new UnauthorizedException('You must be logged in to perform this action.', 401);
        }
        if (Gate::denies('teacher.communicate_students')) {
            throw new UnauthorizedException('You do not have permission to create a user.', 401);
        }
        $departmentId = $user->department_id;
        return StudentRequest::where('department_id', $departmentId)
            ->get()
            ->map(function ($studentRequest) {
                return [
                    'id' => $studentRequest->id,
                    'semister' => $studentRequest->semister ? '2nd Semister' : '1st Semister',
                    'year' => $studentRequest->year,
                    'department' => Department::where('id', $studentRequest->department_id)->first()->departmentName,
                    'user_id' => $studentRequest->user_id,
                    'stuName' => User::where('id', $studentRequest->user_id)->first()->name,
                    'status' => $studentRequest->status,
                    'cafe' => $studentRequest->cafe ? 'Cafe' : 'Non-Cafe',
                ];
            });
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $studentRequest = new StudentRequest();
        // Check if the user is authenticated
        if (!$user) {
            throw new UnauthorizedException('You must be logged in to perform this action.', 401);
        }

        $validation = Validator::make($request->all(), [
            'semister' => 'required',
            'year' => 'required',
            'department_id' => 'required',
            'cafe' => 'required',

        ]);
        if (!$validation->passes()) {
            return response()->json(['errors' => $validation->messages()], 422);
        }
        $stuRequest = StudentRequest::where('user_id', $user->id)->first();
        if($stuRequest){

            if ($stuRequest->status === 'pending') {
    
                    return response()->json(['studentRequest' => null, 'message' => 'You have a pending request']);
            }
        }
        // Update user preferences
        $studentRequest->user_id = $user->id;
        $studentRequest->year = $request->year;
        $studentRequest->semister = $request->semister;
        $studentRequest->department_id = $request->department_id;
        $studentRequest->cafe = $request->cafe;
        $studentRequest->save();

        // Fetch department name (eager loading)
        $department = Department::where('id', $request->department_id)->first()->departmentName;

        // Convert semister and cafe values to string representations
        $semister = $request->semister ? '2nd Semister' : '1st Semister';
        $cafe = $request->cafe ? 'Cafe' : 'Non-Cafe';

        $stuRequest = [
            'department' => $department,
            'semister' => $semister,
            'cafe' => $cafe,
            'year' => $request->year,

        ];
        return response()->json(['studentRequest' => $stuRequest, 'message' => 'Request Submited successfully'], 200);
    }

    public function show(string $id)
    {
        // dd($id);
        if ($id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $studentRequest = StudentRequest::where('user_id', $id)->first();
        if (!$studentRequest) {
            return response()->json(['stuRequest' => null, 'noRequest' => true, 'Message' => 'NO sent Request']);
        }
        // Transforming semister and cafe attributes into human-readable format
        $semister = $studentRequest->semister ? '2nd Semister' : '1st Semister';
        $cafe = $studentRequest->cafe ? 'Cafe' : 'Non-Cafe';

        // Fetch the department name using the department ID
        $department = Department::where('id', $studentRequest->department_id)->first()->departmentName;
        // dd($department);
        // Constructing the response array
        $stuRequest = [
            'id' => $studentRequest->id,
            'semister' => $semister,
            'year' => $studentRequest->year,
            'department' => $department,
            'user_id' => $studentRequest->user_id,
            'status' => $studentRequest->status,
            'cafe' => $cafe,
        ];

        return response()->json(['stuRequest' => $stuRequest, 'noRequest' => false, 'Message' => 'nice request']);
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'status' => 'required|string', // Add any additional validation rules if needed
        ]);

        // Find the student request by ID
        $studentRequest = StudentRequest::findOrFail($id);

        // Update the status
        $studentRequest->status = $request->status; // Assuming 'status' is the field to be updated
        $studentRequest->save();
        
        $student = User::findorFail($studentRequest->user_id);

            $student->department_id = $studentRequest->department_id;
            $student->save();
            
        // Return the updated student request
        return response()->json($studentRequest);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentRequest $studentRequest)
    {
        //
    }
}
