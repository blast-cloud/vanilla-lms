<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseClassesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->string('email_address')->nullable();
            $table->string('telephone')->nullable();
            $table->string('location')->nullable();
            $table->string('monday_time')->nullable();
            $table->string('tuesday_time')->nullable();
            $table->string('wednesday_time')->nullable();
            $table->string('thursday_time')->nullable();
            $table->string('friday_time')->nullable();
            $table->string('saturday_time')->nullable();
            $table->string('sunday_time')->nullable();
            $table->integer('credit_hours')->nullable();
            $table->string('next_lecture_date')->nullable();
            $table->string('next_exam_date')->nullable();
            $table->text('outline')->nullable();
            $table->integer('course_id')->unsigned()->nullable();
            $table->integer('semester_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('lecturer_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('lecturer_id')->references('id')->on('lecturers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('course_classes');
    }
}
