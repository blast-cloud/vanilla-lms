<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseClassFeedbackResponses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_class_feedback_responses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('note')->nullable();
            $table->integer('assignments_rating_point');
            $table->integer('clarification_rating_point');
            $table->integer('examination_rating_point');
            $table->integer('teaching_rating_point');
            $table->integer('course_class_feedback_id')->unsigned();
            $table->integer('course_class_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->integer('lecturer_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('semester_id')->unsigned();
           
            $table->foreign('course_class_feedback_id')->references('id')->on('course_class_feedbacks');
            $table->foreign('course_class_id')->references('id')->on('course_classes');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('lecturer_id')->references('id')->on('lecturers');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('semester_id')->references('id')->on('semesters');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_class_responses');
    }
}
