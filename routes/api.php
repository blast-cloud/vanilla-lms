<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('semesters', App\Http\Controllers\API\SemesterAPIController::class);

Route::resource('departments', App\Http\Controllers\API\DepartmentAPIController::class);

Route::resource('courses', App\Http\Controllers\API\CourseAPIController::class);

Route::resource('course_classes', App\Http\Controllers\API\CourseClassAPIController::class);

Route::resource('class_materials', App\Http\Controllers\API\ClassMaterialAPIController::class);

Route::resource('grades', App\Http\Controllers\API\GradeAPIController::class);

Route::resource('announcements', App\Http\Controllers\API\AnnouncementAPIController::class);

Route::resource('calendar_entries', App\Http\Controllers\API\CalendarEntryAPIController::class);

Route::resource('lecturers', App\Http\Controllers\API\LecturerAPIController::class);

Route::resource('managers', App\Http\Controllers\API\ManagerAPIController::class);

Route::resource('students', App\Http\Controllers\API\StudentAPIController::class);

Route::resource('submissions', App\Http\Controllers\API\SubmissionAPIController::class);

Route::resource('enrollments', App\Http\Controllers\API\EnrollmentAPIController::class);

Route::resource('forums', App\Http\Controllers\API\ForumAPIController::class);

Route::resource('settings', App\Http\Controllers\API\SettingAPIController::class);

 Route::resource('faqs', App\Http\Controllers\API\FAQAPIController::class);