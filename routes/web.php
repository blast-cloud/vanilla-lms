<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('/bbb-conf', function () {
    dd(\Bigbluebutton::isConnect()); //default
})->name('bbb-conf');


Route::get('dashboard/class/{id}/end-lecture/{lectureId}', [App\Http\Controllers\Dashboard\ClassDashboardController::class, 'processEndOnlineLecture'])->name('dashboard.class.end-lecture');
Route::post('dashboard/class/{id}/record-lecture/{lectureId}', [App\Http\Controllers\Dashboard\ClassDashboardController::class, 'processRecordingOnlineLecture'])->name('dashboard.class.record-lecture');


Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'displayProfile'])->name('profile');
    Route::post('/profile-update', [App\Http\Controllers\ProfileController::class, 'processProfileUpdate'])->name('profile-update');

    Route::get('dashboard/class/{id}', [App\Http\Controllers\Dashboard\ClassDashboardController::class, 'index'])->name('dashboard.class');
    Route::get('dashboard/class/{id}/start-lecture/{lectureId}', [App\Http\Controllers\Dashboard\ClassDashboardController::class, 'processStartOnlineLecture'])->name('dashboard.class.start-lecture');
    Route::get('dashboard/class/{id}/join-lecture/{lectureId}', [App\Http\Controllers\Dashboard\ClassDashboardController::class, 'processJoinOnlineLecture'])->name('dashboard.class.join-lecture');

    Route::post('/attachment', [App\Http\Controllers\AttachmentController::class,"uploadFile"])->name('attachment-upload');
    
    Route::middleware('can:isStudent')->group(function () {
        Route::get('dashboard/student', [App\Http\Controllers\Dashboard\StudentDashboardController::class, 'index'])->name('dashboard.student');
    });

    Route::middleware('can:isManager')->group(function () {
        Route::get('dashboard/manager', [App\Http\Controllers\Dashboard\ManagerDashboardController::class, 'index'])->name('dashboard.manager');
        Route::get('dashboard/manager/announcements', [App\Http\Controllers\Dashboard\ManagerDashboardController::class, 'displayAnnouncements'])->name('dashboard.manager.announcements');
        Route::get('dashboard/manager/calendars', [App\Http\Controllers\Dashboard\ManagerDashboardController::class, 'displayDepartmentCalendar'])->name('dashboard.manager.calendars');
        Route::get('dashboard/manager/classes', [App\Http\Controllers\Dashboard\ManagerDashboardController::class, 'displayClassSchedules'])->name('dashboard.manager.classes');
        Route::get('dashboard/manager/courses', [App\Http\Controllers\Dashboard\ManagerDashboardController::class, 'displayCourseCatalog'])->name('dashboard.manager.courses');
        Route::get('dashboard/manager/lecturers', [App\Http\Controllers\Dashboard\ManagerDashboardController::class, 'displayDepartmentLecturers'])->name('dashboard.manager.lecturers');
        Route::get('dashboard/manager/students', [App\Http\Controllers\Dashboard\ManagerDashboardController::class, 'displayDepartmentStudents'])->name('dashboard.manager.students');
        Route::get('dashboard/manager/student/{id}', [App\Http\Controllers\Dashboard\ManagerDashboardController::class, 'displayDepartmentStudentPage'])->name('dashboard.manager.student-page');
    });

    Route::middleware('can:isLecturer')->group(function () {
        Route::get('dashboard/lecturer', [App\Http\Controllers\Dashboard\LecturerDashboardController::class, 'index'])->name('dashboard.lecturer');
    });

    Route::middleware('can:isAdmin')->group(function () {
        Route::get('dashboard/admin', [App\Http\Controllers\Dashboard\AdminDashboardController::class, 'index'])->name('dashboard.admin');
        Route::get('dashboard/users', [App\Http\Controllers\ACL\ACLController::class, 'displayUserAccounts'])->name('dashboard.users');
        Route::get('dashboard/user/{id}', [App\Http\Controllers\ACL\ACLController::class, 'getUser'])->name('dashboard.user');
        Route::post('dashboard/user/{id}', [App\Http\Controllers\ACL\ACLController::class, 'updateUserAccount'])->name('dashboard.user-update');
        Route::post('dashboard/user-enable/{id}', [App\Http\Controllers\ACL\ACLController::class, 'enableUserAccount'])->name('dashboard.user-enable-account');
        Route::post('dashboard/user-disable/{id}', [App\Http\Controllers\ACL\ACLController::class, 'disableUserAccount'])->name('dashboard.user-disable-account');
        Route::post('dashboard/user-delete/{id}', [App\Http\Controllers\ACL\ACLController::class, 'deleteUserAccount'])->name('dashboard.user-delete-account');
        Route::post('dashboard/user-reset/{id}', [App\Http\Controllers\ACL\ACLController::class, 'resetPwdUserAccount'])->name('dashboard.user-pwd-reset');
    });

    Route::resource('semesters', App\Http\Controllers\SemesterController::class);

    Route::resource('departments', App\Http\Controllers\DepartmentController::class);

    Route::resource('courses', App\Http\Controllers\CourseController::class);

    Route::resource('courseClasses', App\Http\Controllers\CourseClassController::class);

    Route::resource('classMaterials', App\Http\Controllers\ClassMaterialController::class);

    Route::resource('grades', App\Http\Controllers\GradeController::class);

    Route::resource('announcements', App\Http\Controllers\AnnouncementController::class);

    Route::resource('calendarEntries', App\Http\Controllers\CalendarEntryController::class);

    Route::resource('lecturers', App\Http\Controllers\LecturerController::class);

    Route::resource('managers', App\Http\Controllers\ManagerController::class);

    Route::resource('students', App\Http\Controllers\StudentController::class);

    Route::resource('submissions', App\Http\Controllers\SubmissionController::class);

    Route::resource('enrollments', App\Http\Controllers\EnrollmentController::class);

    Route::resource('forums', App\Http\Controllers\ForumController::class);

    Route::resource('settings', App\Http\Controllers\SettingController::class);
});

Auth::routes();