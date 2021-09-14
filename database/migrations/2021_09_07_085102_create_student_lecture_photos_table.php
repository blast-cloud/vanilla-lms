<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentLecturePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_lecture_photos', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->unsigned();
            $table->integer('course_class_id')->unsigned();
            $table->integer('class_material_id')->unsigned();
            $table->string('photo_file_path');
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('course_class_id')->references('id')->on('course_classes');
            $table->foreign('class_material_id')->references('id')->on('class_materials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_lecture_photos');
    }
}
