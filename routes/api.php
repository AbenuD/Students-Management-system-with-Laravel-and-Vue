<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentCoursesController;
use App\Http\Controllers\MarkListController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentCoursesController;
use App\Http\Controllers\StudentRequestController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherCoursesController;
use App\Models\DepartmentCourses;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/athenticated', function () {
    return true;
});

Route::get('/student/list', [StudentController::class, 'index']);
Route::get('/student/show/{id}', [StudentController::class, 'show']);
Route::post('register/student', [StudentController::class, 'register'])->middleware('auth');

Route::get('/dep/teacher/{id}', [TeacherController::class, 'depTeacher']);

Route::get('/teacher/index/', [TeacherController::class, 'index']);
Route::put('/assign/dep_head/', [TeacherController::class, 'assignHead']);
Route::post('/assign/teacher', [TeacherController::class, 'assignTeacher']);

Route::get('/course/teachers', [TeacherCoursesController::class, 'index']);
Route::get('/teacher/courses', [TeacherCoursesController::class, 'getTeacherCourses']);

Route::post('/student/request', [StudentRequestController::class, 'store'])->middleware('auth');
Route::get('/stu/request', [StudentRequestController::class, 'index'])->middleware('auth');
Route::get('/student/request/{id}', [StudentRequestController::class, 'show'])->middleware('auth');
Route::put('/stu/request/{id}', [StudentRequestController::class, 'updateStatus']);

Route::post('login', [SessionController::class, 'login']);
Route::post('logout', [SessionController::class, 'logout']);



Route::get('/department/index', [DepartmentController::class, 'index']);
Route::post('new-department', [DepartmentController::class, 'store']);





Route::post('add-course', [CourseController::class, 'store']);
Route::post('upload-courses', [CourseController::class, 'uploadCourses']);


Route::get('/courses/{departmentId}/{year}/{semester}', [DepartmentCoursesController::class, 'show']);


Route::get('/courses/{year}/{semester}', [StudentCoursesController::class, 'show']);

Route::get('/teacher/course/{course_id}/marklist', [MarkListController::class, 'getMarkListsOfCourse']);
Route::post('/update/marklist', [MarkListController::class, 'updateStudentMarkList']);