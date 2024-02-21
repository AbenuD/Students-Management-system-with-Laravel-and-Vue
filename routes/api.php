<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
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

Route::post('register/student', [StudentController::class, 'register']);
Route::post('login', [SessionController::class, 'login']);
Route::post('logout', [SessionController::class, 'logout']);



Route::post('new-department', [DepartmentController::class, 'store']);



Route::post('add-course', [CourseController::class, 'store']);
Route::post('upload-courses', [CourseController::class, 'uploadCourses']);