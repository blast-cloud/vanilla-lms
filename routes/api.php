<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Middleware\IsAdmin;

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
Route::name('api.')->group(function () {
Route::post('/bulkStudent', [\App\Http\Controllers\API\StudentAPIController::class, 'uploadBulkStudents'])->name('students.bulk');
Route::post('/bulkDepartment', [\App\Http\Controllers\API\DepartmentAPIController::class, 'uploadBulkDepartment'])->name('departments.bulk');
Route::post('/bulkStaff', [\App\Http\Controllers\API\LecturerAPIController::class, 'uploadBulkStaff'])->name('staff.bulk');
Route::post('/bulkUser', [App\Http\Controllers\ACL\ACLController::class, 'uploadBulkUsers'])->name('user.bulk');
Route::post('/bulkCourse', [App\Http\Controllers\API\CourseAPIController::class, 'uploadBulkCourses'])->name('courses.bulk');
Route::post('/bulkCourseClass/enrollment', [App\Http\Controllers\API\EnrollmentAPIController::class, 'bulkEnrollment'])->name('enrollment.bulk');
Route::post('/department/semester/course', [App\Http\Controllers\API\CourseClassAPIController::class, 'departmentSemesterCourse'])->name('department.semester.course');

Route::post('/staff-password', [\App\Http\Controllers\API\LecturerAPIController::class, 'resetLecturerPassword'])->name('staff.reset-psw');
Route::post('/student-password', [\App\Http\Controllers\API\StudentAPIController::class, 'resetStudentPassword'])->name('student.reset-psw');

 //Route::middleware(['auth:api'])->group(function () {
        
    Route::resource('semesters', App\Http\Controllers\API\SemesterAPIController::class);

    Route::resource('departments', App\Http\Controllers\API\DepartmentAPIController::class);

    Route::resource('faqs', App\Http\Controllers\API\FAQAPIController::class);

    Route::resource('courses', App\Http\Controllers\API\CourseAPIController::class);

    Route::resource('course_classes', App\Http\Controllers\API\CourseClassAPIController::class);

    Route::resource('course_class_feedbacks', App\Http\Controllers\API\CourseClassFeedbackAPIController::class);

    Route::resource('course_class_feedback_responses', App\Http\Controllers\API\CourseClassFeedbackResponseAPIController::class);

    Route::resource('class_materials', App\Http\Controllers\API\ClassMaterialAPIController::class);

    Route::resource('levels', App\Http\Controllers\API\LevelAPIController::class);

    Route::resource('grades', App\Http\Controllers\API\GradeAPIController::class);

    Route::resource('announcements', App\Http\Controllers\API\AnnouncementAPIController::class);

    Route::resource('calendar_entries', App\Http\Controllers\API\CalendarEntryAPIController::class);

    Route::resource('lecturers', App\Http\Controllers\API\LecturerAPIController::class);

    Route::resource('managers', App\Http\Controllers\API\ManagerAPIController::class);

    Route::resource('students', App\Http\Controllers\API\StudentAPIController::class);

    Route::resource('submissions', App\Http\Controllers\API\SubmissionAPIController::class);

    Route::resource('enrollments', App\Http\Controllers\API\EnrollmentAPIController::class);

    Route::resource('forums', App\Http\Controllers\API\ForumAPIController::class);
    Route::get('forums/comments/{id}', [\App\Http\Controllers\API\ForumAPIController::class, 'getForumComments'])->name('forums.comment');
    Route::put('enrollments/approval/{id}', [\App\Http\Controllers\API\EnrollmentAPIController::class, 'approveEnrollment'])->name('enrollments.approval');

    Route::middleware('can:isAdmin')->group(function() {
    Route::resource('settings', App\Http\Controllers\API\SettingAPIController::class);
  //Route::resource('faqs', App\Http\Controllers\API\FAQAPIController::class);

   });

 });