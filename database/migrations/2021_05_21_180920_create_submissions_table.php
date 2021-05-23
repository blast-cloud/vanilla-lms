<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('upload_file_path');
            $table->integer('student_id')->unsigned();
            $table->integer('course_class_id')->unsigned();
            $table->integer('class_material_id')->unsigned()->nullable();

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('course_class_id')->references('id')->on('course_classes');
            $table->foreign('class_material_id')->references('id')->on('class_materials');

            $table->integer('grade_id')->unsigned()->nullable();
            $table->foreign('grade_id')->references('id')->on('grades');

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
        Schema::drop('submissions');
    }
}
