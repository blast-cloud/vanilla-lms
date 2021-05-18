<?php

namespace App\Providers;





use App\Models\User;
use App\Models\ClassMaterial;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Semester;
use App\Models\Course;

use App\Models\Department;
use App\Models\CourseClass;

use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['enrollments.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['submissions.fields'], function ($view) {
            $ClassMaterialItems = ClassMaterial::pluck('title','id')->toArray();
            $view->with('ClassMaterialItems', $ClassMaterialItems);
        });
        View::composer(['submissions.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['submissions.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $ClassMaterialItems = ClassMaterial::pluck('title','id')->toArray();
            $view->with('ClassMaterialItems', $ClassMaterialItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['forums.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['forums.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $SemesterItems = Semester::pluck('code','id')->toArray();
            $view->with('SemesterItems', $SemesterItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $LecturerItems = Lecturer::pluck('first_name','id')->toArray();
            $view->with('LecturerItems', $LecturerItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $SemesterItems = Semester::pluck('code','id')->toArray();
            $view->with('SemesterItems', $SemesterItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $CourseItems = Course::pluck('name','id')->toArray();
            $view->with('CourseItems', $CourseItems);
        });
        View::composer(['courses.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['class_materials.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['calendar_entries.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['calendar_entries.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['class_materials.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['class_materials.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['calendar_entries.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['calendar_entries.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['managers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['students.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['students.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['students.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['students.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['submissions.fields'], function ($view) {
            $ClassMaterialItems = ClassMaterial::pluck('title','id')->toArray();
            $view->with('ClassMaterialItems', $ClassMaterialItems);
        });
        View::composer(['submissions.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['submissions.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['students.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['students.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['managers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $ClassMaterialItems = ClassMaterial::pluck('title','id')->toArray();
            $view->with('ClassMaterialItems', $ClassMaterialItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['forums.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['forums.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $LecturerItems = Lecturer::pluck('first_name','id')->toArray();
            $view->with('LecturerItems', $LecturerItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $SemesterItems = Semester::pluck('code','id')->toArray();
            $view->with('SemesterItems', $SemesterItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $CourseItems = Course::pluck('name','id')->toArray();
            $view->with('CourseItems', $CourseItems);
        });
        View::composer(['courses.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['class_materials.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['calendar_entries.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['calendar_entries.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $SemesterItems = Semester::pluck('code','id')->toArray();
            $view->with('SemesterItems', $SemesterItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $SemesterItems = Semester::pluck('code','id')->toArray();
            $view->with('SemesterItems', $SemesterItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $ClassMaterialItems = ClassMaterial::pluck('title','id')->toArray();
            $view->with('ClassMaterialItems', $ClassMaterialItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['forums.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['forums.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['forums.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['forums.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['class_materials.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['calendar_entries.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['calendar_entries.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $LecturerItems = Lecturer::pluck('first_name','id')->toArray();
            $view->with('LecturerItems', $LecturerItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $SemesterItems = Semester::pluck('code','id')->toArray();
            $view->with('SemesterItems', $SemesterItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $CourseItems = Course::pluck('name','id')->toArray();
            $view->with('CourseItems', $CourseItems);
        });
        View::composer(['managers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['students.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['students.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['courses.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['class_materials.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['courses.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $LecturerItems = Lecturer::pluck('first_name','id')->toArray();
            $view->with('LecturerItems', $LecturerItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $SemesterItems = Semester::pluck('code','id')->toArray();
            $view->with('SemesterItems', $SemesterItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $CourseItems = Course::pluck('name','id')->toArray();
            $view->with('CourseItems', $CourseItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $LecturerItems = Lecturer::pluck('first_name','id')->toArray();
            $view->with('LecturerItems', $LecturerItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $SemesterItems = Semester::pluck('code','id')->toArray();
            $view->with('SemesterItems', $SemesterItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $CourseItems = Course::pluck('name','id')->toArray();
            $view->with('CourseItems', $CourseItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['submissions.fields'], function ($view) {
            $ClassMaterialItems = ClassMaterial::pluck('title','id')->toArray();
            $view->with('ClassMaterialItems', $ClassMaterialItems);
        });
        View::composer(['submissions.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['submissions.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['students.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['lecturers.fields'], function ($view) {
            $UserItems = User::pluck('name','id')->toArray();
            $view->with('UserItems', $UserItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $ClassMaterialItems = ClassMaterial::pluck('title','id')->toArray();
            $view->with('ClassMaterialItems', $ClassMaterialItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['grades.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['forums.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['forums.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $SemesterItems = Semester::pluck('code','id')->toArray();
            $view->with('SemesterItems', $SemesterItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['enrollments.fields'], function ($view) {
            $StudentItems = Student::pluck('first_name','id')->toArray();
            $view->with('StudentItems', $StudentItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $LecturerItems = Lecturer::pluck('first_name','id')->toArray();
            $view->with('LecturerItems', $LecturerItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $SemesterItems = Semester::pluck('code','id')->toArray();
            $view->with('SemesterItems', $SemesterItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $CourseItems = Course::pluck('name','id')->toArray();
            $view->with('CourseItems', $CourseItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $LecturerItems = Lecturer::pluck('first_name','id')->toArray();
            $view->with('LecturerItems', $LecturerItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $SemesterItems = Semester::pluck('code','id')->toArray();
            $view->with('SemesterItems', $SemesterItems);
        });
        View::composer(['course_classes.fields'], function ($view) {
            $CourseItems = Course::pluck('name','id')->toArray();
            $view->with('CourseItems', $CourseItems);
        });
        View::composer(['courses.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['class_materials.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        View::composer(['calendar_entries.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['calendar_entries.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });

        View::composer(['announcements.fields'], function ($view) {
            $DepartmentItems = Department::pluck('name','id')->toArray();
            $view->with('DepartmentItems', $DepartmentItems);
        });
        View::composer(['announcements.fields'], function ($view) {
            $CourseClassItems = CourseClass::pluck('name','id')->toArray();
            $view->with('CourseClassItems', $CourseClassItems);
        });
        //
    }
}